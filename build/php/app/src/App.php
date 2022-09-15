<?php

namespace Jtangas\GatewayApi;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class App
{
    private $client;
    private $request;
    private $cookieFile;
    private $lockFile;
    private GatewayConfig $config;

    public function __construct(GatewayConfig $config) {
        $this->client = new Client([
            "verify" => false,
        ]);
        $this->request = $_SERVER['REQUEST_URI'];
        $this->cookieFile = realpath(dirname(__FILE__)). '/data/cookie.json';
        $this->lockFile = "/tmp/gateway.lock";
        $this->config = $config;
    }

    private function refreshCookie($cookieData) {
        error_log("Resetting Cookie");
        $authUrl = $this->config->getUrl() . '/internal-api/api/login/Basic';
        $request = $this->client->request( 'POST', $authUrl, [
            'headers' => [
                'Host' => $this->config->getCookieBaseUrl(),
            ],
            'json' => [
                'email' => $this->config->getEmail(),
                'password' => $this->config->getPassword(),
                'username' => $this->config->getUsername(),
            ]
        ]);

        $responseData = $request->getBody()->getContents();

        foreach ($request->getHeader('Set-Cookie') as $cookie) {
            $cookieParts = explode(";", $cookie);
            list($cookieName, $cookieVal) = explode("=", $cookieParts[0], 2);
            $cookieData['data'][$cookieName] = $cookieVal;
        }

        $cookieData['expires'] = (new \DateTime('now +1 day'))->getTimestamp();
        $fh = fopen($this->cookieFile, 'w');
        if ($fh !== false) {
            error_log("COOKIE DATA: " . json_encode($cookieData));
            fwrite($fh, json_encode($cookieData));
        }
        fclose($fh);
        return $cookieData;
    }

    public function index() {
        $requestURI = $_SERVER['REQUEST_URI'];
        $cookieData = json_decode(file_get_contents($this->cookieFile),1);

        if ((new \DateTime())->getTimestamp() > $cookieData['expires']) {
            error_log('session_expired');
            $lock = fopen($this->lockFile, "w");
            if (flock($lock, LOCK_EX)) {
                error_log("GOT LOCK " . (new \DateTime())->getTimestamp());
                $cookieData = $this->refreshCookie($cookieData);
            } else {
                sleep(3);
                $cookieData = json_decode(file_get_contents($this->cookieFile), 1);
            }

            fclose($lock);
            if(file_exists($this->lockFile)) { unlink($this->lockFile); }
        }

        $jar = CookieJar::fromArray($cookieData['data'], $this->config->getUrlClean());
        try {
            $queryUrl = $this->config->getUrl() . '/internal-api' . str_replace('/ep', '', $requestURI);
            $apiResponse = $this->client->request('GET', $queryUrl, [
                'headers' => [
                    'Host' => $this->config->getCookieBaseUrl(),
                ],
                'cookies' => $jar
            ]);
            return $apiResponse->getBody()->getContents();
        } catch (\Exception | GuzzleHttp\Exception\ClientException | GuzzleHttp\Exception\RequestException $e) {
            $cookieData['expires'] = 0;
            $fh = fopen($this->cookieFile, 'w+');
            if ($fh !== false) {
                fwrite($fh, json_encode($cookieData));
            }
            fclose($fh);
        }
    }
}

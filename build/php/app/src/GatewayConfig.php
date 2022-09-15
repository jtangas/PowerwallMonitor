<?php

namespace Jtangas\GatewayApi;

class GatewayConfig {
  public String $email;
  public String $username;
  public String $password;
  public String $url;
  public String $cookieBaseUrl;

  public function __construct(array $configData) {
    foreach ($configData as $key => $value) {
      if($key === "url") {
        $value = "http://" . $value;
      }
      $this->{$key} = $value;
    }
  }

  public function getEmail(): String {
    return $this->email;
  }

  public function getUsername(): String {
    return $this->username;
  }

  public function getPassword(): String {
    return $this->password;
  }

  public function getUrl(): String {
    return $this->url;
  }

  public function getCookieBaseUrl(): String {
    return $this->cookieBaseUrl;
  }

  public function getUrlClean(): String {
    return str_replace('http://', '', $this->url);
  }
}
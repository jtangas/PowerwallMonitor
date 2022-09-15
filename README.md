# Tesla Gateway Monitor
This application is designed to be a monitor into the Tesla Gateway in order to provide more granular information than what the Tesla app provides.

This application uses, nginx, php, telegraph, influxdb, and grafana.

## Requirements
- Docker
- Docker-Compose

## Installation
---
1. Clone this repository
```sh
$ git clone https://github.com/jtangas/PowerwallMonitor
```
2. navigate to the cloned repository
```sh
$ cd PowerwallMonitor
```
3. Edit the [environment settings](#environment-config) in the `config/.env` file to match your Gateway and your network.
4. Run the containers
```sh
$ docker-compose --env-file=./config/.env up --build -d --remove-orphans
```
5. Confirm that the application is running appropriately
    - Test the connection to the gateway by opening your browser to `http://localhost/ep/api/meters/aggregates` if everything is running right, you should see a [json response from your powerwall](#sample-json-response)
    - Open your browser to `http://localhost:3000` to open grafana. Initial login is set to `admin` with password `admin`. You will be prompted to update the password.

## Environment Config
---
|Attribute|Value|
|-------|-------|
|**EMAIL**|This value should be set to your email address that you use to log in to your Tesla account|
|**USERNAME**|This setting can be set to two different values, `customer` and `installer`, for this application, it should always be set to `customer`|
|**PASSWD**|This value should be set to your password that is used to connect to your gateway, typically this can be found inside your gateway panel, or is the last 5 digits of the Serial Number|
|**URL**|This value should be set to the IP address of the device that you will be running the docker containers on|
|**COOKIEBASEURL**|This can be set to any FQDN or IP address|
|**POWERWALL_IP**|This should be set to the IP address of your Powerwall as it appears on your network|


## Sample JSON Response
---
```json
{
  "site": {
    "last_communication_time": "2022-09-14T08:50:22.700489955-07:00",
    "instant_power": 1317.3899688720703,
    "instant_reactive_power": -1117.6700439453125,
    "instant_apparent_power": 1727.6292013095492,
    "frequency": 60.0099983215332,
    "energy_exported": 2522134.323928092,
    "energy_imported": 1045445.6280947595,
    "instant_average_voltage": 120.58499908447266,
    "instant_average_current": 0,
    "i_a_current": 0,
    "i_b_current": 0,
    "i_c_current": 0,
    "last_phase_voltage_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_power_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_energy_communication_time": "0001-01-01T00:00:00Z",
    "timeout": 1500000000,
    "num_meters_aggregated": 1,
    "instant_total_current": 0
  },
  "battery": {
    "last_communication_time": "2022-09-14T08:50:22.701081178-07:00",
    "instant_power": -2180,
    "instant_reactive_power": -40,
    "instant_apparent_power": 2180.3669415949234,
    "frequency": 60.006,
    "energy_exported": 10493390,
    "energy_imported": 11876390,
    "instant_average_voltage": 240.975,
    "instant_average_current": 44.300000000000004,
    "i_a_current": 0,
    "i_b_current": 0,
    "i_c_current": 0,
    "last_phase_voltage_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_power_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_energy_communication_time": "0001-01-01T00:00:00Z",
    "timeout": 1500000000,
    "num_meters_aggregated": 4,
    "instant_total_current": 44.300000000000004
  },
  "load": {
    "last_communication_time": "2022-09-14T08:50:22.700489955-07:00",
    "instant_power": 1338.0402644519245,
    "instant_reactive_power": -731.0279459395085,
    "instant_apparent_power": 1524.7142706222412,
    "frequency": 60.0099983215332,
    "energy_exported": 0,
    "energy_imported": 7650056.11416667,
    "instant_average_voltage": 120.58499908447266,
    "instant_average_current": 11.096241444713995,
    "i_a_current": 0,
    "i_b_current": 0,
    "i_c_current": 0,
    "last_phase_voltage_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_power_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_energy_communication_time": "0001-01-01T00:00:00Z",
    "timeout": 1500000000,
    "instant_total_current": 11.096241444713995
  },
  "solar": {
    "last_communication_time": "2022-09-14T08:50:22.70059045-07:00",
    "instant_power": 2172.580078125,
    "instant_reactive_power": 414.29998779296875,
    "instant_apparent_power": 2211.7297926624956,
    "frequency": 60.0099983215332,
    "energy_exported": 10516658.617778648,
    "energy_imported": 6913.807778645906,
    "instant_average_voltage": 120.29000091552734,
    "instant_average_current": 0,
    "i_a_current": 0,
    "i_b_current": 0,
    "i_c_current": 0,
    "last_phase_voltage_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_power_communication_time": "0001-01-01T00:00:00Z",
    "last_phase_energy_communication_time": "0001-01-01T00:00:00Z",
    "timeout": 1500000000,
    "num_meters_aggregated": 1,
    "instant_total_current": 0
  }
}
```

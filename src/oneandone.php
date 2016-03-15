<?php

// Declare namespace
namespace src\oneandone;

// Qualify Class Names
use src\oneandone\Server;
use src\oneandone\Image;
use src\oneandone\SharedStorage;
use src\oneandone\FirewallPolicy;
use src\oneandone\LoadBalancer;
use src\oneandone\PublicIp;
use src\oneandone\PrivateNetwork;
use src\oneandone\MonitoringCenter;
use src\oneandone\MonitoringPolicy;
use src\oneandone\Log;
use src\oneandone\User;
use src\oneandone\Usage;
use src\oneandone\ServerAppliance;
use src\oneandone\Dvd;

// Include Library Classes/Traits
require(dirname(__DIR__).'/vendor/autoload.php');
require 'oneandone/utilities.php';
require 'oneandone/server.php';
require 'oneandone/image.php';
require 'oneandone/shared_storage.php';
require 'oneandone/firewall_policy.php';
require 'oneandone/load_balancer.php';
require 'oneandone/public_ip.php';
require 'oneandone/private_network.php';
require 'oneandone/monitoring_center.php';
require 'oneandone/monitoring_policy.php';
require 'oneandone/log.php';
require 'oneandone/user.php';
require 'oneandone/usage.php';
require 'oneandone/server_appliance.php';
require 'oneandone/dvd.php';

// Module Global Constants
define('BASE_URL', 'https://cloudpanel-api.1and1.com');
define('VERSION', '/v1');
define('QUESTION_MARK', '?');
define('SUCCESS_CODES', [200, 201, 202]);
define('GOOD_STATES', ['ACTIVE', 'POWERED_ON', 'POWERED_OFF']);


// Top-Level Module
class OneAndOne {

    // Module Variables
    public $api_token;
    public $header;

    // Constructor
    public function __construct($token) {

        $this->api_token = $token;
        $this->header = array(
            'X-TOKEN' => $token,
            'Content-Type' => 'application/json'
        );

    }

    // Server Class Init
    public function server() {

        return new Server($this->api_token, $this->header);

    }

    // Image Class Init
    public function image() {

        return new Image($this->api_token, $this->header);

    }

    // Shared Storage Class Init
    public function sharedStorage() {

        return new SharedStorage($this->api_token, $this->header);

    }

    // Firewall Policy Class Init
    public function firewallPolicy() {

        return new FirewallPolicy($this->api_token, $this->header);

    }

    // Load Balancer Class Init
    public function loadBalancer() {

        return new LoadBalancer($this->api_token, $this->header);

    }

    // Public IP Class Init
    public function publicIp() {

        return new PublicIp($this->api_token, $this->header);

    }

    // Private Network Class Init
    public function privateNetwork() {

        return new PrivateNetwork($this->api_token, $this->header);

    }

    // Monitoring Center Class Init
    public function monitoringCenter() {

        return new MonitoringCenter($this->api_token, $this->header);

    }

    // Monitoring Policy Class Init
    public function monitoringPolicy() {

        return new MonitoringPolicy($this->api_token, $this->header);

    }

    // Log Class Init
    public function log() {

        return new Log($this->api_token, $this->header);

    }

    // User Class Init
    public function user() {

        return new User($this->api_token, $this->header);

    }

    // Usage Class Init
    public function usage() {

        return new Usage($this->api_token, $this->header);

    }

    // Server Appliance Class Init
    public function serverAppliance() {

        return new ServerAppliance($this->api_token, $this->header);

    }

    // Dvd Class Init
    public function dvd() {

        return new Dvd($this->api_token, $this->header);

    }
    
}
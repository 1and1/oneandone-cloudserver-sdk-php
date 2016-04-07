<?php

require_once(dirname(__DIR__).'/src/oneandone/server_appliance.php');

class ServerApplianceTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\ServerAppliance')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-appliances.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], '55726DEDA20C99CF6F2AF8F18CAC9963');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-appliance.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('81504C620D98BCEBAA5202D145203B4C');

        // Assert
        $this->assertEquals($res['id'], '81504C620D98BCEBAA5202D145203B4C');

    }

}
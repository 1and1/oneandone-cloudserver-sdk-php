<?php

require_once(dirname(__DIR__).'/src/oneandone/monitoring_center.php');

class MonitoringCenterTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\MonitoringCenter')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-monitoring-center-usages.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], 'ABA6F4C16FE9893B09B354A4CF6321DF');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-monitoring-center.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $params = [
            'period' => 'LAST_24H'
        ];

        $res = $this->stub->get('BDAF0EC6A36E9E554B80B7E7365821F5', $params);

        // Assert
        $this->assertEquals($res['id'], 'BDAF0EC6A36E9E554B80B7E7365821F5');

    }

}
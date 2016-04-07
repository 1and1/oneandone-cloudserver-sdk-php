<?php

require_once(dirname(__DIR__).'/src/oneandone/log.php');

class LogTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\Log')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-usages.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $params = [
            'period' => 'LAST_24H'
        ];

        $res = $this->stub->all($params);

        // Assert
        $this->assertEquals($res['SERVERS'][0]['id'], 'ABA6F4C16FE9893B09B354A4CF6321DF');

    }

}
<?php

require_once(dirname(__DIR__).'/src/oneandone/log.php');

class LogTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\Log')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testList() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-logs.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('list')
             ->willReturn($data);

        // Perform call
        $params = [
            'period' => 'LAST_24H'
        ];

        $res = $this->stub->list($params);

        // Assert
        $this->assertEquals($res[0]['id'], 'E485755233541090E369E957EA2499D7');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-log.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('E485755233541090E369E957EA2499D7');

        // Assert
        $this->assertEquals($res['id'], 'E485755233541090E369E957EA2499D7');

    }

}
<?php

require_once(dirname(__DIR__).'/src/oneandone/public_ip.php');

class PublicIpTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\PublicIp')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testList() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-public-ips.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('list')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->list();

        // Assert
        $this->assertEquals($res[0]['id'], '569FA2EC06DD48C9E8635F3384A018DB');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-public-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('F77CC589EBC120905B4F4719217BFF6D');

        // Assert
        $this->assertEquals($res['id'], 'F77CC589EBC120905B4F4719217BFF6D');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-public-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->create('example.com');

        // Assert
        $this->assertEquals($res['reverse_dns'], 'example.com');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-public-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->modify('example.es',
            'F77CC589EBC120905B4F4719217BFF6D');

        // Assert
        $this->assertEquals($res['reverse_dns'], 'example.es');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-public-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('F77CC589EBC120905B4F4719217BFF6D');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }


}
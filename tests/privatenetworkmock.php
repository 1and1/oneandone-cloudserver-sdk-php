<?php

require_once(dirname(__DIR__).'/src/oneandone/private_network.php');

class PrivateNetworkTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\PrivateNetwork')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testList() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-private-networks.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('list')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->list();

        // Assert
        $this->assertEquals($res[0]['id'], '6058B5DAF8182D20E1C68C3CED78EE22');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'Example PN',
            'network_address' => '192.168.1.0',
            'subnet_mask' => '255.255.255.0'
        ];

        $res = $this->stub->create($args);

        // Assert
        $this->assertEquals($res['id'], '403B689686A5B48F84E153C3F90E6B8A');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-private-network.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('7786BE739765D4EC0635A90C19F44D91');

        // Assert
        $this->assertEquals($res['id'], '7786BE739765D4EC0635A90C19F44D91');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'Private Network'
        ];

        $res = $this->stub->modify($args, '7786BE739765D4EC0635A90C19F44D91');

        // Assert
        $this->assertEquals($res['id'], '7786BE739765D4EC0635A90C19F44D91');
        $this->assertEquals($res['name'], 'Private Network');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('7786BE739765D4EC0635A90C19F44D91');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

    public function testServers() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-pn-servers.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('servers')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->servers('7786BE739765D4EC0635A90C19F44D91');

        // Assert
        $this->assertEquals($res[0]['id'], 'C72CF0A681B0CCE7EC624DD194D585C6');

    }

    public function testServer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-pn-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('server')
             ->willReturn($data);

        // Perform call
        $server_id = 'C72CF0A681B0CCE7EC624DD194D585C6';

        $res = $this->stub->server($server_id, '7786BE739765D4EC0635A90C19F44D91');

        // Assert
        $this->assertEquals($res['id'], 'C72CF0A681B0CCE7EC624DD194D585C6');

    }

    public function testRemoveServer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-server-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeServer')
             ->willReturn($data);

        // Perform call
        $server_id = 'E9E144DED84EAC9D97C1A022E0351024';

        $res = $this->stub->removeServer($server_id, '7786BE739765D4EC0635A90C19F44D91');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

    public function testAddServers() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/attach-server-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addServers')
             ->willReturn($data);

        // Perform call
        $servers = ['E9E144DED84EAC9D97C1A022E0351024'];

        $res = $this->stub->addServers($servers, '7786BE739765D4EC0635A90C19F44D91');

        // Assert
        $this->assertEquals(count($res), 3);

    }


}
<?php

require_once(dirname(__DIR__).'/src/oneandone/user.php');

class UserTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\User')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-users.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], '7C88E50FBC500A3D9D7F94E414255D6B');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-user.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'phpTest',
            'password' => 'testpassword'
        ];

        $res = $this->stub->create($args);

        // Assert
        $this->assertEquals($res['id'], '7C88E50FBC500A3D9D7F94E414255D6B');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-user.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals($res['id'], '7C88E50FBC500A3D9D7F94E414255D6B');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-user.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'newName',
            'password' => 'newpassword'
        ];

        $res = $this->stub->modify($args);

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-user.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

    public function testApi() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-user-api.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('api')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->api('7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals($res['active'], True);

    }

    public function testEnableApi() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-user-api.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('enableApi')
             ->willReturn($data);

        // Perform call
        $active = True;

        $res = $this->stub->enableApi($active, '7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals($res['state'], 'ACTIVE');

    }

    public function testApiKey() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-user-api-key.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('apiKey')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->apiKey('7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals($res['key'], 'f03c5c76aa853ff710b879909d0d7e3b');

    }

    public function testChangeKey() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/change-api-key.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('changeKey')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->changeKey('7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

    public function testIps() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-user-ips.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ips')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->ips('7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals($res[0], '214.4.143.138');

    }

    public function testAddIps() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-new-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addIps')
             ->willReturn($data);

        // Perform call
        $ip1 = '1.2.3.4';

        $ips = [$ip1];

        $res = $this->stub->addIps($ips, '7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals(count($res['api']['allowed_ips']), 4);

    }

    public function testRemoveIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeIp')
             ->willReturn($data);

        // Perform call
        $ip = '1.2.3.4';

        $res = $this->stub->removeIp($ip, '7C88E50FBC500A3D9D7F94E414255D6B');

        // Assert
        $this->assertEquals(count($res['api']['allowed_ips']), 0);

    }


}
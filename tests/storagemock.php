<?php

require_once(dirname(__DIR__).'/src/oneandone/shared_storage.php');

class SharedStorageTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\SharedStorage')
                           ->disableOriginalConstructor()
                           ->getMock();

    }

    public function testList() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-storages.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('list')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->list();

        // Assert
        $this->assertEquals($res[0]['id'], '6AD2F180B7B666539EF75A02FE227084');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'Test Storage',
            'description' => 'Test Desc',
            'size' => 200
        ];

        $res = $this->stub->create($args);

        // Assert
        $this->assertEquals($res['id'], '6AD2F180B7B666539EF75A02FE227084');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res['id'], '6AD2F180B7B666539EF75A02FE227084');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'New Name',
            'description' => 'New Desc',
            'size' => 200
        ];

        $res = $this->stub->modify($args);

        // Assert
        $this->assertEquals($res['size'], 200);

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

    public function testServers() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/storage-servers.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('servers')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->servers('6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res[0]['id'], 'C72CF0A681B0CCE7EC624DD194D585C6');

    }

    public function testServer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('server')
             ->willReturn($data);

        // Perform call
        $server_id = '<SERVER-ID>';

        $res = $this->stub->server($server_id,
            '6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res['id'], '638ED28205B1AFD7ADEF569C725DD85F');

    }

    public function testRemoveServer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/detach-server-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeServer')
             ->willReturn($data);

        // Perform call
        $server_id = '<SERVER-ID>';

        $res = $this->stub->removeServer($server_id,
            '6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals(count($res['servers']), 1);

    }

    public function testAddServers() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/attach-server-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addServers')
             ->willReturn($data);

        // Perform call
        $server1 = [
            'id' => '638ED28205B1AFD7ADEF569C725DD85F',
            'rights' => 'R'
        ];

        $servers = [$server1];

        $res = $this->stub->addServers($servers,
            '6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res['servers'][0]['id'],
            '638ED28205B1AFD7ADEF569C725DD85F');

    }

    public function testAccess() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-credentials.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('access')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->access();

        // Assert
        $this->assertEquals($res['user_domain'], "dev1\\uid624468");

    }

    public function testChangePassword() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/change-password.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('changePassword')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->changePassword('asdasdfgagsw32');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

}
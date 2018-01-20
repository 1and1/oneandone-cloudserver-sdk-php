<?php

require_once(dirname(__DIR__).'/src/oneandone/block_storage.php');

class BlockStorageTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\BlockStorage')
                           ->disableOriginalConstructor()
                           ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-block-storages.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], '6AD2F180B7B666539EF75A02FE227084');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-block-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'My block storage 4',
            'description' => 'My block storage description',
            'size' => 200
        ];

        $res = $this->stub->create($args);

        // Assert
        $this->assertEquals($res['id'], '6AD2F180B7B666539EF75A02FE227084');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-block-storage.json');
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
            'description' => 'New Desc'
        ];

        $res = $this->stub->modify($args);

        // Assert
        $this->assertEquals($res['size'], 200);

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-block-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

    public function testAttachBlockStorage() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/attach-block-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('attachBlockStorage')
            ->willReturn($data);

        // Perform call
        $res = $this->stub->addServers('638ED28205B1AFD7ADEF569C725DD85F',
            '6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res['server']['id'],
            '638ED28205B1AFD7ADEF569C725DD85F');

    }

    public function testDetachBlockStorage() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/detach-block-storage.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('detachBlockStorage')
             ->willReturn($data);

        // Perform call
        $server_id = '<SERVER-ID>';

        $res = $this->stub->detachBlockStorage('6AD2F180B7B666539EF75A02FE227084');

        // Assert
        $this->assertEquals($res['id'], '6AD2F180B7B666539EF75A02FE227084');
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

}
<?php

require_once(dirname(__DIR__).'/src/oneandone/ssh_key.php');

class SshKeyTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\SshKey')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-ssh-keys.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], '39AA65F5D5B02FA02D58173094EBAF95');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-ssh-key.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $specs = [
            'name' => 'My SSH key 1',
            'description' => 'My SSH key description',
            'public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqGKukO1De7zhZj6+H0qtjTkVxwTCpvKe4eCZ0FPqri0cb2JZfXJ/DgYSF6vUpwmJG8wVQZKjeGcjDOL5UlsuusFncCzWBQ7RKNUSesmQRMSGkVb1/3j+skZ6UtW+5u09lHNsj6tQ51s1SPrCBkedbNf0Tp0GbMJDyR4e9T04ZZwIDAQAB'
        ];

        $res = $this->stub->create($specs);

        // Assert
        $this->assertEquals($res['id'], '39AA65F5D5B02FA02D58173094EBAF95');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-ssh-key.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '39AA65F5D5B02FA02D58173094EBAF95');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-ssh-key.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $specs = [
            'name' => 'My SSH key 1 updated',
            'description' => 'My SSH key description updated'
        ];

        $res = $this->stub->modify($specs, '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '39AA65F5D5B02FA02D58173094EBAF95');
        $this->assertEquals($res['name'], 'My SSH key 1 updated');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-ssh-key.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['state'], 'DELETING');

    }

}
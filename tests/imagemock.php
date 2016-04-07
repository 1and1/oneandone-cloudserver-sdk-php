<?php

require_once(dirname(__DIR__).'/src/oneandone/image.php');

class ImageTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\Image')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-images.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], 'A0FAA4587A7CB6BBAA1EA877C844977E');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-image.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $specs = [
            'server_id' => '<SERVER-ID>',
            'name' => 'Example Image',
            'description' => 'Example Desc',
            'frequency' => 'ONCE',
            'num_images' => 1
        ];

        $res = $this->stub->create($specs);

        // Assert
        $this->assertEquals($res['id'], 'E1817F51F5A9322116579150247E0004');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-image.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('842F09CAF954298C6A4BCD25E1CA3689');

        // Assert
        $this->assertEquals($res['id'], '842F09CAF954298C6A4BCD25E1CA3689');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/edit-image.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $specs = [
            'name' => 'New image name'
        ];

        $res = $this->stub->modify($specs, '842F09CAF954298C6A4BCD25E1CA3689');

        // Assert
        $this->assertEquals($res['id'], '842F09CAF954298C6A4BCD25E1CA3689');
        $this->assertEquals($res['name'], 'New image name');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-image.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('842F09CAF954298C6A4BCD25E1CA3689');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

}
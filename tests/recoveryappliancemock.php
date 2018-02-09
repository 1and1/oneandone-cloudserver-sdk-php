<?php

require_once(dirname(__DIR__).'/src/oneandone/recovery_appliance.php');

class RecoveryApplianceTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\RecoveryAppliance')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/tests/mock-api/list-recovery-appliances.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], '81504C620D98BCEBAA5202D145203B4B');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/tests/mock-api/get-recovery-appliance.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('81504C620D98BCEBAA5202D145203B4B');

        // Assert
        $this->assertEquals($res['id'], '81504C620D98BCEBAA5202D145203B4B');

    }

}
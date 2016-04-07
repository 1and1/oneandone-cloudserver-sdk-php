<?php

require_once(dirname(__DIR__).'/src/oneandone/load_balancer.php');

class LoadBalancerTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\LoadBalancer')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-load-balancers.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], 'B23F1B4F84E983B4FEDD5459E877058A');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $rule1 = [
            'protocol' => 'TCP',
            'port_balancer' => 80,
            'port_server' => 80,
            'source' => '0.0.0.0'
        ];

        $rules = [$rule1];

        $args = [
            'name' => 'Example LB',
            'health_check_test' => 'TCP',
            'health_check_interval' => 40,
            'persistence' => True,
            'persistence_time' => 1200,
            'method' => 'ROUND_ROBIN',
            'rules' => $rules
        ];

        $res = $this->stub->create($args);

        // Assert
        $this->assertEquals($res['id'], 'BD8318616581A9C3C53F94402503230F');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-load-balancer.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res['id'], 'B23F1B4F84E983B4FEDD5459E877058A');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'My load rename balancer',
        ];

        $res = $this->stub->modify($args, 'B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res['name'], 'My load rename balancer');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

    public function testIps() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-lb-servers.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ips')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->ips('B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res[0]['id'], '7C88E50FBC500A3D9D7F94E414255D6B');

    }

    public function testIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-lb-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ip')
             ->willReturn($data);

        // Perform call
        $ip = '7C88E50FBC500A3D9D7F94E414255D6B';

        $res = $this->stub->ip($ip, 'B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res['id'], '7C88E50FBC500A3D9D7F94E414255D6B');

    }

    public function testRemoveIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-ip-load.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeIp')
             ->willReturn($data);

        // Perform call
        $ip = '7C88E50FBC500A3D9D7F94E414255D6B';

        $res = $this->stub->removeIp($ip, 'B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

    public function testAddIps() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/assign-server-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addIps')
             ->willReturn($data);

        // Perform call
        $ip = '7C88E50FBC500A3D9D7F94E414255D6B';

        $ips = [$ip];

        $res = $this->stub->addIps($ips, 'B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals(count($res['server_ips']), 1);

    }

    public function testRules() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-lb-rules.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('rules')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->rules('B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res[0]['id'], 'BCFAF421227674B2B324F779C1163ECB');

    }

    public function testRule() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-lb-rule.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('rule')
             ->willReturn($data);

        // Perform call
        $rule = 'BCFAF421227674B2B324F779C1163ECB';

        $res = $this->stub->rule($rule, 'B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res['id'], 'BCFAF421227674B2B324F779C1163ECB');

    }

    public function testAddRules() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-rule-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addRules')
             ->willReturn($data);

        // Perform call
        $rule = [
            'protocol' => 'TCP',
            'port_balancer' => 99,
            'port_server' => 99,
            'source' => '0.0.0.0'
        ];

        $rules = [$rule];

        $res = $this->stub->addRules($rules, 'B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals(count($res['rules']), 3);

    }

    public function testDeleteRule() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-rule-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('deleteRule')
             ->willReturn($data);

        // Perform call
        $rule = 'BCFAF421227674B2B324F779C1163ECB';

        $res = $this->stub->deleteRule($rule, 'B23F1B4F84E983B4FEDD5459E877058A');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }


}
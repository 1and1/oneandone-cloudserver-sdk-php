<?php

require_once(dirname(__DIR__).'/src/oneandone/firewall_policy.php');

class FirewallPolicyTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\FirewallPolicy')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-firewalls.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], '83522FC7DA9172F229E5352C587075BA');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $rule1 = [
            'protocol' => 'TCP',
            'port' => 80,
            'action' => "allow",
            'source' => '0.0.0.0'
        ];

        $rules = [$rule1];

        $args = [
            'name' => 'Example Firewall',
            'description' => 'Example Desc',
            'rules' => $rules
        ];

        $res = $this->stub->create($args);

        // Assert
        $this->assertEquals($res['id'], '83522FC7DA9172F229E5352C587075BA');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-firewall.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['id'], '83522FC7DA9172F229E5352C587075BA');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $args = [
            'name' => 'Firewall policy rename test'
        ];

        $res = $this->stub->modify($args, '83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['name'], 'Firewall policy rename test');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-firewall-policy.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

    public function testIps() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-server-ips-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ips')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->ips('83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res[0]['id'], '01D4A802798AB77AA72DA2D05E1379E1');

    }

    public function testIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-ip-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ip')
             ->willReturn($data);

        // Perform call
        $ip_id = '01D4A802798AB77AA72DA2D05E1379E1';

        $res = $this->stub->ip($ip_id, '83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['id'], '01D4A802798AB77AA72DA2D05E1379E1');

    }

    public function testRemoveIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-ip-firewall.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeIp')
             ->willReturn($data);

        // Perform call
        $ip_id = '01D4A802798AB77AA72DA2D05E1379E1';

        $res = $this->stub->removeIp($ip_id, '83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

    public function testAddIps() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-ip-firewall.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addIps')
             ->willReturn($data);

        // Perform call
        $ip_id = '01D4A802798AB77AA72DA2D05E1379E1';

        $ips = [$ip_id];

        $res = $this->stub->addIps($ips, '83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['server_ips'][0]['id'],
            '01D4A802798AB77AA72DA2D05E1379E1');

    }

    public function testRules() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-fp-rules.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('rules')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->rules('83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res[0]['id'], 'DA5CC179ED00079AE7DE595F0073D86E');

    }

    public function testRule() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-fp-rule.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('rule')
             ->willReturn($data);

        // Perform call
        $rule_id = '353E9F751630074CF7219747436A8D71';

        $res = $this->stub->rule($rule_id, '83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['id'], '353E9F751630074CF7219747436A8D71');

    }

    public function testAddRules() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-rule-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addRules')
             ->willReturn($data);

        // Perform call
        $rule1 = [
            'protocol' => 'TCP',
            'port' => '90',
            'allow' => 'allow',
            'source' => '0.0.0.0'
        ];

        $rules = [$rule1];

        $res = $this->stub->addRules($rules,
            '83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['rules'][2]['id'],
            '353E9F751630074CF7219747436A8D71');

    }

    public function testDeleteRule() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-rule-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('deleteRule')
             ->willReturn($data);

        // Perform call
        $rule_id = '353E9F751630074CF7219747436A8D71';

        $res = $this->stub->deleteRule($rule_id, '83522FC7DA9172F229E5352C587075BA');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

}
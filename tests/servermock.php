<?php

require_once(dirname(__DIR__).'/src/oneandone/server.php');

class ServerTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\Server')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-servers.json');
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
        $file = file_get_contents('tests/mock-api/create-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $hdd1 = [
            'size' => 120,
            'is_main' => True
        ];

        $hdds = [$hdd1];

        $my_server = [
            'name' => 'Example Server',
            'description' => 'Example Desc',
            'hardware' => [
                'vcore' => 1,
                'cores_per_processor' => 1,
                'ram' => 1,
                'hdds' => $hdds
            ],
            'appliance_id' => '07C170D67C8EC776933FCFF1C299C1C5'
        ];

        $res = $this->stub->create($my_server);

        // Assert
        $this->assertEquals($res['id'], '4B86A3ACC4CEB7A89E012E49FC17F312');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server.json');
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
        $file = file_get_contents('tests/mock-api/modify-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $my_server = [
            'name' => 'My Server remame',
        ];

        $res = $this->stub->modify($my_server,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '39AA65F5D5B02FA02D58173094EBAF95');
        $this->assertEquals($res['name'], 'My Server remame');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete(False, '6DD7C9714E555230BCFFED4E249358F0');

        // Assert
        $this->assertEquals($res['status']['state'], 'REMOVING');

    }

    public function testListFixed() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/fixed-server-flavors.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('listFixed')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->listFixed();

        // Assert
        $this->assertEquals($res[0]['id'], '8C626C1A7005D0D1F527143C413D461E');

    }

    public function testGetFixed() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-fixed-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('getFixed')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->getFixed('8C626C1A7005D0D1F527143C413D461E');

        // Assert
        $this->assertEquals($res['id'], '8C626C1A7005D0D1F527143C413D461E');

    }

    public function testHardware() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-hardware.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('hardware')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->hardware('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['vcore'], 1);

    }

    public function testModifyHardware() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-server-hardware.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modifyHardware')
             ->willReturn($data);

        // Perform call
        $specs = [
            'ram' => 2
        ];

        $res = $this->stub->modifyHardware($specs,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['hardware']['ram'], 2);

    }

    public function testHdds() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-hdds.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('hdds')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->hdds('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res[0]['id'], '1964560F458D95DE1884E443B00E33E7');

    }

    public function testAddHdds() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-hdd.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addHdds')
             ->willReturn($data);

        // Perform call
        $hdd1 = [
            'size' => 40,
            'is_main' => False
        ];

        $hdds = [$hdd1];

        $res = $this->stub->addHdds($hdds, '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'CONFIGURING');

    }

    public function testHdd() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-hdd.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('hdd')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->hdd('1964560F458D95DE1884E443B00E33E7',
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '1964560F458D95DE1884E443B00E33E7');

    }

    public function testModifyHdd() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-server-hdd.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modifyHdd')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->modifyHdd(40, '1964560F458D95DE1884E443B00E33E7',
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['hardware']['hdds'][0]['size'], 40);

    }

    public function testDeleteHdd() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-hdd.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('deleteHdd')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->deleteHdd('1964560F458D95DE1884E443B00E33E7',
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'CONFIGURING');

    }

    public function testImage() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-image.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('image')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->image('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '76EBF29C1250167C8754B2B3D1C05F68');

    }

    public function testInstallImage() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/reinstall-image.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('installImage')
             ->willReturn($data);

        // Perform call
        $image = [
            'id' => '<IMAGE-ID>',
        ];

        $res = $this->stub->installImage($image,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'DEPLOYING');

    }

    public function testIps() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-server-ips.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ips')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->ips('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res[0]['id'], '01D4A802798AB77AA72DA2D05E1379E1');

    }

    public function testAddIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-server-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addIp')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->addIp('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['ips'][1]['type'], 'IPV4');

    }

    public function testIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ip')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->ip('01D4A802798AB77AA72DA2D05E1379E1',
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '01D4A802798AB77AA72DA2D05E1379E1');

    }

    public function testReleaseIp() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-server-ip.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('releaseIp')
             ->willReturn($data);

        // Perform call
        $args = [
            'ip_id' => '<IP-ID>',
            'keep_ip' => true
        ];

        $res = $this->stub->releaseIp($args, '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals(count($res['ips']), 1);

    }

    public function testFirewall() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-ip-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('firewall')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->firewall('01D4A802798AB77AA72DA2D05E1379E1',
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '01D4A802798AB77AA72DA2D05E1379E1');

    }

    public function testRemoveFirewall() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-ip-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeFirewall')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->removeFirewall('01D4A802798AB77AA72DA2D05E1379E1',
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['ips'][0]['firewall_policy'], null);

    }

    public function testAddFirewall() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/assign-ip-fp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addFirewall')
             ->willReturn($data);

        // Perform call
        $firewall = [
            'ip_id' => '<IP-ID>',
            'firewall_id' => '<FIREWALL-ID>'
        ];

        $res = $this->stub->addFirewall($firewall,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['ips'][0]['firewall_policy']['id'],
            '5DE607955050915229D602931F942F32');

    }

    public function testLoadBalancers() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-server-lbs.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('loadBalancers')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->loadBalancers('01D4A802798AB77AA72DA2D05E1379E1',
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res[0]['id'], '37E2FDEB2945990CEE4B7927FB1ED425');

    }

    public function testAddLoadBalancer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addLoadBalancer')
             ->willReturn($data);

        // Perform call
        $load_balancer = [
            'ip_id' => '<IP-ID>',
            'load_balancer_id' => '<LOAD-BALANCER-ID>'
        ];

        $res = $this->stub->addLoadBalancer($load_balancer,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['ips'][0]['load_balancers'][0]['id'],
            '4B9EF92B4954C550F0C269A6B4CB7ACC');

    }

    public function testRemoveLoadBalancer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/detach-server-lb.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeLoadBalancer')
             ->willReturn($data);

        // Perform call
        $load_balancer = [
            'ip_id' => '<IP-ID>',
            'load_balancer_id' => '<LOAD-BALANCER-ID>'
        ];

        $res = $this->stub->removeLoadBalancer($load_balancer,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['ips'][0]['load_balancers'], []);

    }

    public function testStatus() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-status.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('status')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->status('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['state'], 'POWERED_ON');

    }

    public function testChangeStatus() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/change-server-status.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('changeStatus')
             ->willReturn($data);

        // Perform call
        $action = [
            'action' => 'POWER_OFF',
            'method' => 'SOFTWARE'
        ];

        $res = $this->stub->changeStatus($action,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'POWERING_OFF');

    }

    public function testDvd() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-dvd.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('dvd')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->dvd('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], 'B77E19E062D5818532EFF11C747BD104');

    }

    public function testEjectDvd() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/eject-dvd.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ejectDvd')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->ejectDvd('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'CONFIGURING');

    }

    public function testLoadDvd() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/load-dvd.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('loadDvd')
             ->willReturn($data);

        // Perform call
        $dvd_id = '<DVD-ID>';

        $res = $this->stub->loadDvd($dvd_id, '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'CONFIGURING');

    }

    public function testPrivateNetworks() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-server-pns.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('privateNetworks')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->privateNetworks('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res[0]['id'], '6B7051F17199EF9EA994CD3E4AA450E6');

    }

    public function testPrivateNetwork() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-server-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('privateNetwork')
             ->willReturn($data);

        // Perform call
        $private_network_id = '6B7051F17199EF9EA994CD3E4AA450E6';

        $res = $this->stub->privateNetwork($private_network_id,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['id'], '6B7051F17199EF9EA994CD3E4AA450E6');

    }

    public function testRemovePrivateNetwork() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-server-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removePrivateNetwork')
             ->willReturn($data);

        // Perform call
        $private_network_id = '6B7051F17199EF9EA994CD3E4AA450E6';

        $res = $this->stub->removePrivateNetwork($private_network_id,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals(count($res['private_networks']), 1);

    }

    public function testAddPrivateNetwork() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/attach-server-pn.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addPrivateNetwork')
             ->willReturn($data);

        // Perform call
        $private_network_id = '6B7051F17199EF9EA994CD3E4AA450E6';

        $res = $this->stub->addPrivateNetwork($private_network_id,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['private_networks'], null);

    }

    public function testCreateSnapshot() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-snapshot.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('createSnapshot')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->createSnapshot('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['snapshot']['id'],
            'D609F69D08EB0C77D8EADE22F70462B4');

    }

    public function testSnapshot() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-snapshots.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('snapshot')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->snapshot('39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res[0]['id'], 'B77E19E062D5818532EFF11C747BD104');

    }

    public function testRestoreSnapshot() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/restore-snapshot.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('restoreSnapshot')
             ->willReturn($data);

        // Perform call
        $snapshot_id = 'B198CE46BDE59DDCD15C352EF10EB0EA';

        $res = $this->stub->restoreSnapshot($snapshot_id,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'CONFIGURING');

    }

    public function testDeleteSnapshot() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-snapshot.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('deleteSnapshot')
             ->willReturn($data);

        // Perform call
        $snapshot_id = 'B198CE46BDE59DDCD15C352EF10EB0EA';

        $res = $this->stub->deleteSnapshot($snapshot_id,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['status']['state'], 'CONFIGURING');

    }

    public function testCloneServer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/clone-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('cloneServer')
             ->willReturn($data);

        // Perform call
        $name = 'Test clone';

        $res = $this->stub->cloneServer($name,
            '39AA65F5D5B02FA02D58173094EBAF95');

        // Assert
        $this->assertEquals($res['name'], 'Test clone');

    }

}
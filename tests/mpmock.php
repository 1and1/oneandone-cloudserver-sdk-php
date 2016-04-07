<?php

require_once(dirname(__DIR__).'/src/oneandone/monitoring_policy.php');

class MonitoringPolicyTest extends PHPUnit_Framework_TestCase
{

    public function setup() {

        $this->stub = $this->getMockBuilder('src\oneandone\MonitoringPolicy')
                     ->disableOriginalConstructor()
                     ->getMock();

    }

    public function testAll() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-mps.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('all')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->all();

        // Assert
        $this->assertEquals($res[0]['id'], '0F9A1604FC80EB625FC6AEE7394893BE');

    }

    public function testCreate() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/create-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('create')
             ->willReturn($data);

        // Perform call
        $thresholds = [
            'cpu' => [
                'warning' => [
                    'value' => 90,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 95,
                    'alert' => True
                ]
            ],
            'ram' => [
                'warning' => [
                    'value' => 90,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 95,
                    'alert' => True
                ]
            ],
            'disk' => [
                'warning' => [
                    'value' => 80,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 90,
                    'alert' => True
                ]
            ],
            'transfer' => [
                'warning' => [
                    'value' => 1000,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 2000,
                    'alert' => True
                ]
            ],
            'internal_ping' => [
                'warning' => [
                    'value' => 50,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 100,
                    'alert' => True
                ]
            ]
        ];


        $process1 = [
            'process' => 'test',
            'alert_if' => 'NOT_RUNNING',
            'email_notification' => True
        ];

        $processes = [$process1];


        $port1 = [
            'protocol' => 'TCP',
            'port' => 22,
            'alert_if' => 'NOT_RESPONDING',
            'email_notification' => True
        ];

        $ports = [$port1];


        $args = [
            'name' => 'My monitoring policy',
            'email' => '',
            'agent' => True,
            'thresholds' => $thresholds,
            'ports' => $ports,
            'processes' => $processes
        ];

        $res = $this->stub->create($args);

        // Assert
        $this->assertEquals($res['name'], 'My monitoring policy');
        $this->assertEquals($res['state'], 'ACTIVE');

    }

    public function testGet() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('get')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->get('92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['id'], '92B74394A397ECC3359825C1656D67A6');

    }

    public function testModify() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modify')
             ->willReturn($data);

        // Perform call
        $new_thresholds = [
            'cpu' => [
                'warning' => [
                    'value' => 80,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 95,
                    'alert' => True
                ]
            ],
            'ram' => [
                'warning' => [
                    'value' => 80,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 95,
                    'alert' => True
                ]
            ],
            'disk' => [
                'warning' => [
                    'value' => 80,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 90,
                    'alert' => True
                ]
            ],
            'transfer' => [
                'warning' => [
                    'value' => 1000,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 2000,
                    'alert' => True
                ]
            ],
            'internal_ping' => [
                'warning' => [
                    'value' => 50,
                    'alert' => False
                ],
                'critical' => [
                    'value' => 100,
                    'alert' => True
                ]
            ]
        ];

        $args = [
            'name' => 'New Name',
            'email' => 'changed@example.com',
            'thresholds' => $new_thresholds
        ];

        $res = $this->stub->modify($args, '2AAA70C3661915B7CA007299C140C63D');

        // Assert
        $this->assertEquals($res['name'], 'New Monitoring Policy Name');
        $this->assertEquals($res['state'], 'ACTIVE');

    }

    public function testDelete() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/delete-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('delete')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->delete('92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['state'], 'REMOVING');

    }

    public function testPorts() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-mp-ports.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('ports')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->ports('92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res[0]['id'], '663D21E232530D79E4E584104C400EE4');

    }

    public function testAddPorts() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-port-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addPorts')
             ->willReturn($data);

        // Perform call
        $port2 = [
            'protocol' => 'TCP',
            'port' => 90,
            'alert_if' => 'RESPONDING',
            'email_notification' => False
        ];

        $ports = [$port2];

        $res = $this->stub->addPorts($ports, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals(count($res['ports']), 1);

    }

    public function testPort() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-mp-port.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('port')
             ->willReturn($data);

        // Perform call
        $port_id = '663D21E232530D79E4E584104C400EE4';

        $res = $this->stub->port($port_id, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['id'], '663D21E232530D79E4E584104C400EE4');

    }

    public function testModifyPort() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-port-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modifyPort')
             ->willReturn($data);

        // Perform call
        $port = [
            'port_id' => '<PORT-ID>',
            'protocol' => 'TCP',
            'port' => 90,
            'alert_if' => 'NOT_RESPONDING',
            'email_notification' => True
        ];

        $res = $this->stub->modifyPort($port, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['ports'][0]['protocol'], 'TCP');

    }

    public function testDeletePort() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-port-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('deletePort')
             ->willReturn($data);

        // Perform call
        $port_id = '663D21E232530D79E4E584104C400EE4';

        $res = $this->stub->deletePort($port_id, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['ports'], []);

    }

    public function testProcesses() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-mp-processes.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('processes')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->processes('92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res[0]['id'], '663D21E232530D79E4E584104C400EE4');

    }

    public function testAddProcesses() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-process-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addProcesses')
             ->willReturn($data);

        // Perform call
        $port2 = [
            'protocol' => 'TCP',
            'port' => 90,
            'alert_if' => 'RESPONDING',
            'email_notification' => False
        ];

        $processes = [$port2];

        $res = $this->stub->addProcesses($processes, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals(count($res), 3);

    }

    public function testProcess() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-mp-process.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('process')
             ->willReturn($data);

        // Perform call
        $process_id = '663D21E232530D79E4E584104C400EE4';

        $res = $this->stub->process($process_id, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['id'], '663D21E232530D79E4E584104C400EE4');

    }

    public function testModifyProcess() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/modify-process-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('modifyProcess')
             ->willReturn($data);

        // Perform call
        $process = [
            'process_id' => '04187715D8F971D3C671475D2D7C245D',
            'process' => 'test',
            'alert_if' => 'RUNNING',
            'email_notification' => False
        ];

        $res = $this->stub->modifyProcess($process, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['processes'][0]['process'], 'test');

    }

    public function testDeleteProcess() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/remove-process-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('deleteProcess')
             ->willReturn($data);

        // Perform call
        $process_id = '663D21E232530D79E4E584104C400EE4';

        $res = $this->stub->deleteProcess($process_id, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['processes'], []);

    }

    public function testServers() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/list-mp-servers.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('servers')
             ->willReturn($data);

        // Perform call
        $res = $this->stub->servers('92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res[0]['id'], 'C72CF0A681B0CCE7EC624DD194D585C6');

    }

    public function testServer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/get-mp-server.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('server')
             ->willReturn($data);

        // Perform call
        $server_id = 'C72CF0A681B0CCE7EC624DD194D585C6';

        $res = $this->stub->server($server_id, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['id'], 'C72CF0A681B0CCE7EC624DD194D585C6');

    }

    public function testRemoveServer() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/detach-server-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('removeServer')
             ->willReturn($data);

        // Perform call
        $server_id = '663D21E232530D79E4E584104C400EE4';

        $res = $this->stub->removeServer($server_id, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

    public function testAddServers() {

        // Read mock JSON data
        $file = file_get_contents('tests/mock-api/add-server-mp.json');
        $data = json_decode($file, true);

        // Create stub
        $this->stub->method('addServers')
             ->willReturn($data);

        // Perform call
        $server1 = '92AA60BEC8333A21EDB9EAAA61852860';

        $servers = [$server1];

        $res = $this->stub->addServers($servers, '92B74394A397ECC3359825C1656D67A6');

        // Assert
        $this->assertEquals($res['state'], 'CONFIGURING');

    }

}
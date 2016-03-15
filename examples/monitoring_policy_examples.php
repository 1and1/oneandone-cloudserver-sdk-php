<?php

use OneAndOne;

$client = new OneAndOne('<API-TOKEN>');




# List all monitoring policies on your account
$monitoring_policy = $client->monitoringPolicy();

$res = $monitoring_policy->list();
echo json_encode($res, JSON_PRETTY_PRINT);



# Create a monitoring policy
$monitoring_policy = $client->monitoringPolicy();

// Set threshold values
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

// Set processes
$process1 = [
    'process' => 'test',
    'alert_if' => 'NOT_RUNNING',
    'email_notification' => True
];

$processes = [$process1];

// Set ports
$port1 = [
    'protocol' => 'TCP',
    'port' => 22,
    'alert_if' => 'NOT_RESPONDING',
    'email_notification' => True
];

$ports = [$port1];

// Set Monitoring Policy Specs
$args = [
    'name' => 'Example MP',
    'email' => 'test@example.com',
    'agent' => True,
    'thresholds' => $thresholds,
    'ports' => $ports,
    'processes' => $processes
];

$res = $monitoring_policy->create($args);
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns a monitoring policy's current specs
$monitoring_policy = $client->monitoringPolicy();

$res = $monitoring_policy->get('<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a monitoring policy and its thresholds
$monitoring_policy = $client->monitoringPolicy();

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

$res = $monitoring_policy->modify($args, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a monitoring policy
$monitoring_policy = $client->monitoringPolicy();

$res = $monitoring_policy->delete('<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a monitoring policy's ports
$monitoring_policy = $client->monitoringPolicy();

$res = $monitoring_policy->ports('<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add ports to a monitoring policy
$monitoring_policy = $client->monitoringPolicy();

$port2 = [
    'protocol' => 'TCP',
    'port' => 90,
    'alert_if' => 'RESPONDING',
    'email_notification' => False
];

$ports = [$port2];

$res = $monitoring_policy->addPorts($ports, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns information about a monitoring policy's port
$monitoring_policy = $client->monitoringPolicy();

$port_id = '<PORT-ID>';

$res = $monitoring_policy->port($port_id, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a monitoring policy's port
$monitoring_policy = $client->monitoringPolicy();

$port = [
    'port_id' => '<PORT-ID>',
    'protocol' => 'TCP',
    'port' => 90,
    'alert_if' => 'NOT_RESPONDING',
    'email_notification' => True
];

$res = $monitoring_policy->modifyPort($port, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a monitoring policy's port
$monitoring_policy = $client->monitoringPolicy();

$port_id = '<PORT-ID>';

$res = $monitoring_policy->deletePort($port_id, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a monitoring policy's processes
$monitoring_policy = $client->monitoringPolicy();

$res = $monitoring_policy->processes('<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add processes to a monitoring policy
$monitoring_policy = $client->monitoringPolicy();

$process2 = [
    'process' => 'logger',
    'alert_if' => 'NOT_RUNNING',
    'email_notification' => True
];

$processes = [$process2];

$res = $monitoring_policy->addProcesses($processes, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns information about a monitoring policy's process
$monitoring_policy = $client->monitoringPolicy();

$process_id = '<PROCESS-ID>';

$res = $monitoring_policy->process($process_id, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Modify a monitoring policy's process
$monitoring_policy = $client->monitoringPolicy();

$process = [
    'process_id' => '<PROCESS-ID>',
    'process' => 'test',
    'alert_if' => 'RUNNING',
    'email_notification' => False
];

$res = $monitoring_policy->modifyProcess($process, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Delete a monitoring policy's process
$monitoring_policy = $client->monitoringPolicy();

$process_id = '<PROCESS-ID>';

$res = $monitoring_policy->deleteProcess($process_id, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# List a monitoring policy's servers
$monitoring_policy = $client->monitoringPolicy();

$res = $monitoring_policy->servers('<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Returns information about a monitoring policy's server
$monitoring_policy = $client->monitoringPolicy();

$server_id = '<SERVER-ID>';

$res = $monitoring_policy->server($server_id, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Remove a monitoring policy's server
$monitoring_policy = $client->monitoringPolicy();

$server_id = '<SERVER-ID>';

$res = $monitoring_policy->removeServer($server_id, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);



# Add servers to a monitoring policy
$monitoring_policy = $client->monitoringPolicy();

$server1 = '<SERVER-ID>';

$servers = [$server1];

$res = $monitoring_policy->addServers($servers, '<MONITORING-POLICY-ID>');
echo json_encode($res, JSON_PRETTY_PRINT);
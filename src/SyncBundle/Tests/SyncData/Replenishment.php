<?php
// src/SyncBundle/Tests/SyncData/Replenishment.php
namespace SyncBundle\Tests\SyncData;

use DateTime;

class Replenishment
{
    static public function getData()
    {
        $data = [
            'authentication' => [
                'login' => 'xxx-login',
                'password' => 'xxx-password'
            ],
            'sync' => [
                'id' => hash('sha256', '1')
            ],
        	'data' => [
        		'replenishments' => [
        			[
        				'id' => 1,
        				'datetime' => (new DateTime)->format('Y-m-d H:i:s'),
                        'operator' => [
                            'id'      => 1,
                            'nfc-tag' => [
                                'code' => "5826e4b885d0f"
                            ]
                        ],
                        'account' => [
                            'id' => '123456789'
                        ],
        				'banknotes' => [
        					[
        						'currency' => 'UAH',
        						'nominal' => 1,
        						'quantity' => 1
        					]
        				],
                        'state' => 'message describing current BM state'
        			],
                    [
        				'id' => 2,
        				'datetime' => (new DateTime)->format('Y-m-d H:i:s'),
                        'operator' => [
                            'id' => 2,
                            'nfc-tag' => [
                                'code' => "4676e4b885d1g"
                            ]
                        ],
                        'account' => [
                            'id' => '987654321'
                        ],
        				'banknotes' => [
        					[
        						'currency' => 'UAH',
        						'nominal' => 10,
        						'quantity' => 5
        					]
        				],
                        'state' => NULL
        			],
                    // ...
        		]
        	]
        ];

        $data['checksum'] = hash('sha256', json_encode($data['data']));

        return json_encode($data);
    }
}

<?php

$params = $this->container->get('parameters');

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => sprintf(
                        '%s://%s:%s@%s:%s/%s',
                        $params['db_scheme'],
                        $params['db_user'],
                        $params['db_pass'],
                        $params['db_host'],
                        $params['db_port'],
                        $params['db_name'],
                    ),
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'My\Entity' => 'my_entity',
                ],
            ],
            'my_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\XmlDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/doctrine',
            ],
        ],
    ],
];
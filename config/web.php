<?php

use yii\rbac\DbManager;
use yii\rest\UrlRule;
use yii\symfonymailer\Mailer;
use yii\web\JsonParser;
use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'EnhDsTbWG9WRuN7ZOtfpwJ1iwnJT3stH',
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        /* 'response' => [
            'format' => Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ], */
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => UrlRule::class, 'controller' => 'product',
                    // 'tokens' => [
                    //     '{id}' => '<id:\\w+>',
                    //     '{type}'=>'<type:\\w+>'
                    // ],
                    // 'extraPatterns' => [
                    //     'POST {id}/image/{type}' => 'image',
                    // ]
                    'extraPatterns' => [
                        'GET page/<page>' => 'pagination',
                    ]

                ], //'pluralize' => false
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'user',
                    'extraPatterns' => [
                        'GET page/<page>' => 'pagination',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'auth', 'pluralize' => false,
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'GET logout' => 'logout',
                    ]
                ],
            ],
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
    ],
    'params' => $params,

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

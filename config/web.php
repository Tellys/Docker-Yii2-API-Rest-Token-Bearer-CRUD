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
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EnhDsTbWG9WRuN7ZOtfpwJ1iwnJT3stH',
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                //'application/json' => JsonParser::class
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
                ['class' => UrlRule::class, 'controller' => 'product'], //'pluralize' => false
                ['class' => UrlRule::class, 'controller' => 'member'],
                ['class' => UrlRule::class, 'controller' => 'book'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                // [
                //     'class' => UrlRule::class,
                //     'controller' => 'auth',
                //     'extraPatterns' => [
                //         'POST login' => 'login',
                //         'POST logout' => 'logout',
                //     ]
                // ],

                'GET loans' => 'index',
                'POST loans' => 'borrow',
            ],
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
    ],
    'params' => $params,

];

//define('YII_ENV', 'dev');

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

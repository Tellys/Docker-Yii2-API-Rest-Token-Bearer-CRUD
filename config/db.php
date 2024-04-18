<?php

return [
    // 'class' => 'yii\db\Connection',
    // 'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    // 'username' => 'root',
    // 'password' => '',
    // 'charset' => 'utf8',

    // // for docker container name = mysql8
    'class' => 'yii\db\Connection',
     'dsn' => 'mysql:host=mysql8;dbname=yii2basic',
     'username' => 'root',
     'password' => 's3cr3t',
     'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];

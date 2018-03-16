<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->setPsr4('sonrac\\seeds\\tests\\', __DIR__);
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

if (!@mkdir(__DIR__."/_output", 0777, true) && !is_dir(__DIR__."/_output")) {
    throw new \Exception("Directory " . __DIR__."/_output" . " not writable");
}

if (!is_file(__DIR__.'/_output/db.db')) {
    file_put_contents(__DIR__.'/_output/db.db', '');
}

$app = (new \yii\console\Application([
    'id'            => 'test-console',
    'basePath'      => __DIR__,
    'bootstrap'     => ['sonrac\seeds\tests\app\Boot'],
    'vendorPath'    => realpath(__DIR__ . '/../vendor'),
    'controllerMap' => [
        'seed' => [
            'class'           => 'sonrac\seeds\SeedsController',
            'seedsNamespaces' => [
                'sonrac\seeds\tests\testTable',
                'sonrac\seeds\tests\userTable',
            ],
        ],
    ],
    'components'    => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn'   => 'sqlite:' . __DIR__ . '/_output/db.db',
        ],
    ],
]));
<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds\tests;

use PHPUnit\Framework\TestCase;
use sonrac\seeds\SeedsController;
use sonrac\seeds\tests\testTable\SeedError;
use sonrac\seeds\tests\testTable\SeedFirst;
use sonrac\seeds\tests\testTable\SeedModel;
use sonrac\seeds\tests\testTable\SeedSecond;
use sonrac\seeds\tests\userTable\UserFirst;
use yii;

/**
 * Class SeedControllerTest
 *
 * @package sonrac\seeds\tests
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class SeedControllerTest extends TestCase
{
    public function testOneSeed()
    {
        $controller = new SeedsController('seeds', Yii::$app->module->id);

        $controller->actionSeed(SeedError::class);
        $controller->actionSeed(SeedFirst::class);
        $controller->actionSeed(SeedModel::class);
        $controller->actionSeed(SeedSecond::class);
        $controller->actionSeed(UserFirst::class);

        $this->_assertions();
    }

    protected function _assertions()
    {
        $this->assertCount(8, (new yii\db\Query())->from('test')->all());
        $this->assertCount(2, (new yii\db\Query())->from('user')->all());
    }

    public function testNameSpace()
    {
        $controller = new SeedsController('seeds', Yii::$app->module->id);

        $controller->actionRunGroup('sonrac\seeds\tests\userTable');
        $controller->actionRunGroup('sonrac\seeds\tests\testTable');

        $this->_assertions();
    }

    public function testRunAllNamespacesConfig()
    {
        $controller = new SeedsController('seeds', Yii::$app->module->id, [
            'seedsNamespaces' => [
                'sonrac\seeds\tests\userTable',
                'sonrac\seeds\tests\testTable',
            ],
        ]);

        $controller->actionRunAll();

        $this->_assertions();
    }
}
<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds\tests;

use PHPUnit\Framework\TestCase;
use sonrac\seeds\ClassFinder;
use yii;

/**
 * Class ClassFinderTest
 *
 * @package sonrac\seeds\tests
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class ClassFinderTest extends TestCase
{
    public function testFind()
    {
        $this->assertEquals([
            'path'          => __DIR__,
            'namespaceReal' => 'sonrac\seeds\tests',
        ], ClassFinder::getInstance(yii::$app->vendorPath)->getNameSpacePath('sonrac\seeds\tests'));

        $this->assertEquals([
            'path'          => realpath(__DIR__ . '/../src'),
            'namespaceReal' => 'sonrac\seeds',
        ], ClassFinder::getInstance(yii::$app->vendorPath)->getNameSpacePath('sonrac\seeds'));

        $this->assertEquals([
            __DIR__.'/app/Boot.php',
            __DIR__.'/app/TableMigrations.php',
            __DIR__.'/app/TestModel.php',
        ], ClassFinder::recFindByExt(__DIR__ . '/app/', ['php'], false));

        $this->assertCount(12, ClassFinder::recFindByExt(__DIR__, ['php']));
    }

    public function testException()
    {
        $this->expectException(\Exception::class);
        ClassFinder::getInstance();
    }
}
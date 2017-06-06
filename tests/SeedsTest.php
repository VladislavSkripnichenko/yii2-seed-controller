<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds\tests;

use PHPUnit\Framework\TestCase;
use sonrac\seeds\tests\testTable\SeedError;
use sonrac\seeds\tests\testTable\SeedFirst;
use sonrac\seeds\tests\testTable\SeedModel;
use yii\db\IntegrityException;
use yii\db\Query;

/**
 * Class SeedsTest
 *
 * @package sonrac\seeds\tests
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class SeedsTest extends TestCase
{
    public function testActionOneSeedError()
    {
        $seed = new SeedError();

        $this->assertTrue($seed->handle());

        try {
            $this->assertFalse($seed->run());
        } catch (\Exception $e) {
            $this->assertInstanceOf(IntegrityException::class, $e);
        }

        $this->assertCount(2, (new Query())->from('test')->all());
    }

    public function testModelSeed()
    {
        $seed = new SeedModel();

        $this->testActionOneSeed($seed);
    }

    public function testActionOneSeed($seed = null)
    {
        $seed = $seed ?? new SeedFirst();

        $this->assertTrue($seed->handle());
        $this->assertTrue($seed->run());

        $this->assertCount(4, (new Query())->from('test')->all());
    }
}
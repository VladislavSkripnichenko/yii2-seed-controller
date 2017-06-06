<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds\tests\userTable;

use sonrac\seeds\Seed;

/**
 * Class SeedFirst
 *
 * @package sonrac\seeds\tests\testTable
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class UserFirst extends Seed
{
    public $tableName = 'user';

    /**
     * @inheritDoc
     */
    public function run(): bool
    {
        return $this->handle();
    }

    public function getData(): array
    {
        return [
            [
                'name'     => 'David',
                'email'    => 'david@gmail.com',
                'password' => 'pass',
            ],
            [
                'name'     => 'Viktor',
                'email'    => 'viktor@gmail.com',
                'password' => 'viktor',
            ],
        ];
    }
}
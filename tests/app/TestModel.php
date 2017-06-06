<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds\tests\app;

use yii\db\ActiveRecord;

/**
 * Class TestModel
 *
 * @package sonrac\seeds\tests\app
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class TestModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'test';
    }

    public function rules()
    {
        return [
            ['name', 'string', 'max' => 255],
        ];
    }
}
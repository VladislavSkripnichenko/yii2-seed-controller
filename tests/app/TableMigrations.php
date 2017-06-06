<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds\tests\app;

use Yii;
use yii\db\Migration;

/**
 * Class TableMigrations
 *
 * @package sonrac\seeds\tests\app
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class TableMigrations extends Migration
{
    public function up()
    {
        $this->createTable('test', [
            'id'   => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('user', [
            'id'       => $this->primaryKey(),
            'name'     => $this->string(),
            'email'    => $this->string(),
            'password' => $this->string(),
        ]);
    }

    public function down()
    {
        if (in_array('user', Yii::$app->db->schema->getTableNames())) {
            $this->dropTable('user');
        }
        if (in_array('test', Yii::$app->db->schema->getTableNames())) {
            $this->dropTable('test');
        }
    }
}
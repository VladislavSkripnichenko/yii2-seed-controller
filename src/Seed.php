<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Object;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\helpers\Console;

/**
 * Class Seed
 * Base seed class
 *
 * @property null|string               $tableName     Table name. Define if you define data in getData() method and
 *           inserted into table from array
 * @property null|\yii\db\ActiveRecord $modelClass    Table      name. Define if you define data in getData() method and
 *           inserted into table from array
 * @property bool                      $runValidation Run validation for next record which will be inserted
 *
 * @package sonrac\seeds
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
abstract class Seed extends Object implements ISeed
{
    /**
     * Table name. Define if you define data in getData() method and inserted into table from array
     *
     * @var null|string
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $tableName = null;

    /**
     * Model class. Define if add data needed adding from model
     *
     * @var null|\yii\db\ActiveRecord
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $modelClass = null;

    /**
     * Run validation for next record which will be inserted
     *
     * @var bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $runModelValidation = true;

    /**
     * DB component
     *
     * @var null|Connection
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $db = null;

    /**
     * Current seed execution controller
     *
     * @var Controller
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $_controller;

    /**
     * @inheritdoc
     * @{inheritdoc}
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->modelClass && !in_array('yii\db\ActiveRecordInterface', class_implements($this->modelClass))) {
            throw new InvalidConfigException('Model class does not \yii\db\ActiveRecord');
        }

        $this->db = $this->db ? Yii::$app->get($this->db) : Yii::$app->db;
    }

    /**
     * @inheritdoc
     * @{inheritdoc}
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function handle(): bool
    {
        $transaction = $this->db->beginTransaction();
        if (count($data = $this->getData())) {
            if ($this->modelClass) {
                foreach ($data as $datum) {
                    /** @var ActiveRecord $model */
                    $model = new $this->modelClass();
                    $model->load($datum, '');
                    if (!$model->save()) {
                        echo $this->_controller->ansiFormat('Save error: ' . json_encode($model->getErrors()) . PHP_EOL, Console::FG_RED);
                        $transaction->rollBack();
                        return false;
                    }
                }
            } else {
                try {
                    $columns = array_keys($data[0]);
                    $this->db->createCommand()
                        ->batchInsert($this->tableName, $columns, $data)
                        ->execute();
                } catch (\Exception $exception) {
                    $transaction->rollBack();
                    throw $exception;
                }
            }
        }
        $transaction->commit();
        return true;
    }

    /**
     * Get data for seeds if tableName or modelClass property is instead
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getData(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     * @{inheritdoc}
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    abstract public function run(): bool;

    /**
     * @inheritDoc
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @inheritDoc
     */
    public function setController($controller)
    {
        $this->_controller = $controller;
    }


}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: sonrac
 * Date: 3/16/18
 * Time: 4:57 PM
 */

namespace sonrac\seeds;

use yii\console\Controller;

/**
 * Class GeneratorController.
 * Generate seed data class from resource.
 *
 * @package sonrac\seeds
 */
class GeneratorController extends Controller
{
    public $generators = [];

    public $filesList = [];

    public $tableName;
    public $outDir;
    public $namespace;

    public function init()
    {
        parent::init();


    }

    public function actionGenerate() {
        if (is_string($this->filesList)) {
            $this->filesList = explode(',', $this->filesList);
        }

        if ($this->tableName) { // Parse from tables

        }
    }

    protected function getFromTable() {

    }
}
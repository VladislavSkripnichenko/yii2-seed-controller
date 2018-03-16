<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds;

use yii;
use yii\base\InvalidParamException;
use yii\console\Controller;
use yii\db\Exception;
use yii\helpers\Console;

/**
 * Class SeedsController
 *
 * @package sonrac\seeds
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class SeedsController extends Controller
{
    /**
     * Namespaces for seeds
     *
     * @var array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public $seedsNamespaces = [];

    /**
     * Run all seeds
     *
     * @throws \yii\db\Exception
     *
     * @author Donii Sergii <doniyas@gmail.com>
     */
    public function actionRunAll()
    {
        $result = true;

        foreach ($this->seedsNamespaces as $seedsNamespace) {
            echo $this->ansiFormat(PHP_EOL . 'Run seeds from ' . $seedsNamespace . PHP_EOL . PHP_EOL, Console::FG_BLUE);

            if (!$this->actionRunGroup($seedsNamespace)) {
                echo $this->ansiFormat("Seeds for {$seedsNamespace} failed" . PHP_EOL, Console::FG_RED);
                $result = false;
            }
        }

        if (!$result) {
            echo $this->ansiFormat(PHP_EOL . 'Error during seeds' . PHP_EOL, Console::FG_RED);
        } else {
            echo $this->ansiFormat(PHP_EOL . 'Seeds finished successfully' . PHP_EOL, Console::FG_GREEN);
        }
    }

    /**
     * Run seed commands group
     *
     * @param $namespace
     *
     * @return bool|null
     * @throws \yii\db\Exception
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionRunGroup($namespace)
    {
        if (class_exists($namespace)) {
            return $this->actionSeed($namespace);
        }
        $namespaceInfo = ClassFinder::getInstance(Yii::$app->vendorPath)->getNameSpacePath($namespace);

        $path = $namespaceInfo['path'];

        if (!is_dir($path)) {
            throw new \InvalidArgumentException('Namespace not found');
        }

        $files = $this->filterSeeds(ClassFinder::recFindByExt($path, ['php'], false), $namespace);

        if (!count($files)) {
            echo $this->ansiFormat('Seeds not found in namespace' . PHP_EOL, Console::FG_RED);
        }

        $result = true;

        foreach ($files as $file) {
            /** @var Seed $seed */
            $seed = new $file;
            $seed->controller = $this;
            if (!$seed->run()) {
                $result = false;
                echo $this->ansiFormat(get_class($seed) . " run with errors" . PHP_EOL, Console::FG_RED);
            } else {
                echo $this->ansiFormat(get_class($seed) . " finished successfully" . PHP_EOL, Console::FG_GREEN);
            }
        }

        return $result;
    }

    /**
     * Run seed action
     *
     * @param null|string $className Classname
     * @param null|string $tableName Migration tablename
     *
     * @throws \yii\db\Exception
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function actionSeed($className = null, $tableName = null)
    {
        /** @var Seed $class */
        $class = new $className;
        $class->controller = $this;

        if ($tableName) {
            $class->tableName = $tableName;
        }

        if (!$class->run()) {
            throw new Exception('Seed ' . $className . ' run failed');
        }
    }

    /**
     * Filter seeds
     *
     * @param array  $files
     * @param string $namespace
     *
     * @return array
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected function filterSeeds(array $files, string $namespace): array
    {
        $seedFiles = [];
        foreach ($files as $file) {
            $className = $namespace . "\\" . pathinfo($file, PATHINFO_FILENAME);

            if (!class_exists($className)) {
                continue;
            }

            if (in_array(ISeed::class, class_implements($className), false)) {
                $seedFiles[] = $className;
            }

        }

        return $seedFiles;
    }
}
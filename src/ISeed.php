<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds;


/**
 * Class ISeed
 * Implementation for seed
 *
 * @property \yii\console\Controller $controller    Current seed execution controller
 *
 * @package sonrac\seeds
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
interface ISeed
{
    /**
     * Auto runner for seed
     *
     * @return bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function handle(): bool;

    /**
     * Run seed manually
     *
     * @return bool
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function run(): bool;

    /**
     * Get seed execution controller
     *
     * @return \yii\console\Controller
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function getController();

    /**
     * Set seed execution controller
     *
     * @param \yii\console\Controller $controller
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    public function setController($controller);
}
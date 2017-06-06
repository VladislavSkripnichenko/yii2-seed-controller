<?php
/**
 * @author Donii Sergii <doniysa@gmail.com>
 */

namespace sonrac\seeds\tests\app;

use yii\base\BootstrapInterface;

/**
 * Class Boot
 *
 * @package sonrac\seeds\tests\app
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 */
class Boot implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        ob_start();
        $m = new TableMigrations();
        $m->down();
        $m->up();
        ob_clean();
    }
}
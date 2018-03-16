<?php
/**
 * Created by IntelliJ IDEA.
 * User: sonrac
 * Date: 3/16/18
 * Time: 5:00 PM
 */

namespace sonrac\seeds\Generator;

use yii\db\Query;

/**
 * Interface DBGeneratorInterface.
 * Generate seed from DB data interface.
 *
 * @package sonrac\seeds\GeneratorController
 */
interface DBGeneratorInterface extends GeneratorInterface
{
    /**
     * Get table name.
     *
     * @return string
     */
    public function getTableName();

    /**
     * Prepare request.
     *
     * @param \yii\db\Query $query
     *
     * @return \yii\db\Query
     */
    public function prepareRequest(Query $query);
}
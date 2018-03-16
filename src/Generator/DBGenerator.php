<?php
/**
 * Created by IntelliJ IDEA.
 * User: sonrac
 * Date: 3/16/18
 * Time: 4:59 PM
 */

namespace sonrac\seeds\Generator;
use yii\db\Query;

/**
 * Class DBGenerator.
 * DB GeneratorController.
 *
 * @package sonrac\seeds\GeneratorController
 */
class DBGenerator implements DBGeneratorInterface
{
    /**
     * Query builder
     *
     * @var \yii\db\Query
     */
    protected $_queryBuilder;

    /**
     * Table name.
     *
     * @var string
     */
    protected $_tableName;

    /**
     * DBGenerator constructor.
     *
     * @param string $tableName
     */
    public function __construct($tableName)
    {
        $this->_tableName = $tableName;
    }

    /**
     * @inheritDoc
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * @inheritDoc
     */
    public function prepareRequest(Query $query)
    {
        return $query;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $query = (new Query())
            ->from($this->_tableName);

        $query = $this->prepareRequest($query);

        $data = $query->all();

        return $data ? : [];
    }

    /**
     * @return \yii\db\Query
     */
    public function getQueryBuilder()
    {
        return $this->_queryBuilder;
    }

    /**
     * @param \yii\db\Query $queryBuilder
     */
    public function setQueryBuilder(Query $queryBuilder)
    {
        $this->_queryBuilder = $queryBuilder;
    }

}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: sonrac
 * Date: 3/16/18
 * Time: 4:58 PM
 */

namespace sonrac\seeds;


use sonrac\seeds\Generator\GeneratorInterface;

class ArrayGenerator implements GeneratorInterface
{
    /**
     * Filename.
     *
     * @var string
     */
    protected $_fileName;

    /**
     * Table name.
     *
     * @var string
     */
    protected $_tableName;

    /**
     * ArrayGenerator constructor.
     *
     * @param string $filename
     * @param string $tablename
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($filename = null, $tablename = null)
    {
        $this->_fileName = $filename;
        $this->_tableName = $tablename;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return require $this->_fileName;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->_fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->_fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
    }


}
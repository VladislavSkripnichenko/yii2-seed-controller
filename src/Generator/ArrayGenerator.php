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
    protected $tablename;

    /**
     * ArrayGenerator constructor.
     *
     * @param string $filename
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($filename, $tablename)
    {
        if (!is_string($filename) && !is_file($filename)) {
            throw new \InvalidArgumentException('Incorrect format');
        }

        $this->_fileName = $filename;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return require $this->_fileName;
    }


}
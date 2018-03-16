<?php
/**
 * Created by IntelliJ IDEA.
 * User: sonrac
 * Date: 3/16/18
 * Time: 4:59 PM
 */

namespace sonrac\seeds\Generator;

/**
 * Interface GeneratorInterface.
 * Data generator interface.
 *
 * @package sonrac\seeds\Generator
 */
interface GeneratorInterface
{
    /**
     * Get data from resource.
     *
     * @return array
     */
    public function getData();
}
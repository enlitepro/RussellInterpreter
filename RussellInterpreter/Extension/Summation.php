<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once './../Extension.php';

/**
 * Class Summation
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Summation
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return array_sum($arguments);
    }
}
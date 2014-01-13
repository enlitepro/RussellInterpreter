<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once './../Extension.php';

/**
 * Class Arr
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Arr
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments;
    }
}
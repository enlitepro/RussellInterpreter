<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once './../Extension.php';

/**
 * Class Division
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Division
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments[0] / $arguments[1];
    }
}
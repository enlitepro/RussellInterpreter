<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once 'RussellInterpreter/Extension.php';

/**
 * Class Equal
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Equal
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return ($arguments[0] == $arguments[1]);
    }
}
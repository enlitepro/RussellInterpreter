<?php

namespace RussellInterpreter\Method;

use RussellInterpreter;

include_once 'Interpreter/Method.php';

/**
 * Class Division
 * @package RussellInterpreter\Method
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Division
    extends RussellInterpreter\Method
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments[0] / $arguments[1];
    }
}
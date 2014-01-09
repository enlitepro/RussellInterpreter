<?php

namespace RussellInterpreter\Method;

use RussellInterpreter;

include_once 'Interpreter/Method.php';

/**
 * Class Subtraction
 * @package RussellInterpreter\Method
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Subtraction
    extends RussellInterpreter\Method
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments[0] - $arguments[1];
    }
}
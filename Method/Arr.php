<?php

namespace RussellInterpreter\Method;

use RussellInterpreter;

include_once 'Interpreter/Method.php';

/**
 * Class Arr
 * @package RussellInterpreter\Method
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Arr
    extends RussellInterpreter\Method
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments;
    }
}
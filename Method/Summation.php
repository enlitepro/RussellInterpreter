<?php

namespace RussellInterpreter\Method;

use RussellInterpreter;

include_once 'Interpreter/Method.php';

/**
 * Class Summation
 * @package RussellInterpreter\Method
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Summation
    extends RussellInterpreter\Method
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return array_sum($arguments);
    }
}
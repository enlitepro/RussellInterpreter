<?php

namespace RussellInterpreter\Method;

use RussellInterpreter;

include_once 'Interpreter/Method.php';

/**
 * Class Random
 * @package RussellInterpreter\Method
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Random
    extends RussellInterpreter\Method
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        $min = (int)$arguments[0];
        $max = (int)$arguments[1];

        return rand($min, $max);
    }
}
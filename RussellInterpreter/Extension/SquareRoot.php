<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * Class SquareRoot
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class SquareRoot
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return sqrt($arguments[0]);
    }
}
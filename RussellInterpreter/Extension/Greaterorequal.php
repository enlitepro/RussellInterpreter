<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * Class Greaterorequal
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Greaterorequal
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments[0] >= $arguments[1];
    }
}
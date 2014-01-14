<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * Class Exponential
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Exponential
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return pow($arguments[0], $arguments[1]);
    }
}
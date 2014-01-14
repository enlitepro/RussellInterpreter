<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * Class Modulo
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Modulo
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return false;
    }
}
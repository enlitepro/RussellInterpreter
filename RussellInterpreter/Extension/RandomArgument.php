<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * Class RandomArgument
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class RandomArgument
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments[rand(0, count($arguments)-1)];
    }
}
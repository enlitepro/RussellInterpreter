<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class True
    extends RussellInterpreter\Extension
{
    public function init(RussellInterpreter\Interpreter $core)
    {
        $core->setVariable('true', true);
    }

    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return ($arguments[0] == true);
    }
}
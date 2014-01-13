<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;
use RussellInterpreter\Interpreter;

/**
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class False
    extends RussellInterpreter\Extension
{
    public function init(Interpreter $core)
    {
        $core->setVariable('false', false);
    }

    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return ($arguments[0] == false);
    }
}
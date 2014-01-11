<?php

namespace RussellInterpreter\Extension;

include_once 'RussellInterpreter/Extension.php';

use RussellInterpreter;

/**
 * Class Variable
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Assignment
    extends RussellInterpreter\Extension
{
    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        $name = trim($arguments[0], '\'"');

        if ($core->isVariable($name, false)) {
            $core->setVariable($name, $arguments[1]);
        }
        else {
            throw new RussellInterpreter\Exception("Variable name '{$arguments[0]}' is not valid");
        }
    }
}
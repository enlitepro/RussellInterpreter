<?php

namespace RussellInterpreter\Method;

use RussellInterpreter;

include_once 'Interpreter/Method.php';

/**
 * Class Variable
 * @package RussellInterpreter\Method
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Variable
    extends RussellInterpreter\Method
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
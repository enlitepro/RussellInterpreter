<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

/**
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Decrement
    extends RussellInterpreter\Extension
{
    /**
     * @param array $arguments
     * @param RussellInterpreter\Interpreter $core
     * @return mixed
     */
    public function calculationArguments(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return $arguments;
    }

    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        $value = $arguments[0];
        if (is_array($value)) {
            $name = $value['name'];
            $value = $core->getVariable($name, 0);
            $value--;
            $core->setVariable($name, $value);
        }
        else {
            if (! is_numeric($arguments[0])) {
                $value = $core->calculation($arguments[0]);
            }

            $value--;
        }

        return $value;
    }
}
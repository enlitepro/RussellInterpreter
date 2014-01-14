<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once 'RussellInterpreter/Exception.php';

/**
 * Class ConditionalOperator
 *
 * IF condition THEN consequent ELSE alternative
 *
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class ConditionalOperator
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
        $condition = $arguments[0];
        $consequent = $arguments[1];
        $alternative = isset($arguments[2]) ? $arguments[2] : false;

        if ($core->calculation($condition)) {
            return $core->calculation($consequent);
        }
        elseif ($alternative) {
            return $core->calculation($alternative);
        }

        return null;
    }
}
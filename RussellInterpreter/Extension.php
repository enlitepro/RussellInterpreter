<?php

namespace RussellInterpreter;

/**
 * Class Method
 * @package RussellInterpreter
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
abstract class Extension
{
    /**
     * @param array $arguments
     * @param Interpreter $core
     * @return mixed
     */
    public function calculationArguments(array $arguments, Interpreter $core)
    {
        foreach ($arguments as $key => $argument) {
            $arguments[$key] = $core->calculation($argument);
        }
        return $arguments;
    }

    abstract public function execute(array $arguments, Interpreter $core);
}
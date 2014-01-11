<?php

namespace RussellInterpreter;

/**
 * Class Method
 * @package RussellInterpreter
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
abstract class Extension
{
    abstract public function execute(array $arguments, Interpreter $core);
}
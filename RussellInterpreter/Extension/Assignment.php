<?php

namespace RussellInterpreter\Extension;

include_once __DIR__ . '/../Extension.php';

use RussellInterpreter;

/**
 * Class Variable
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Assignment
    extends RussellInterpreter\Extension
{
    /**
     * @param array $arguments
     * @param RussellInterpreter\Interpreter $core
     * @return mixed
     */
    public function calculationArguments(array $arguments, RussellInterpreter\Interpreter $core)
    {
        return array(
            $arguments[0]['name'],
            $core->calculation($arguments[1])
        );
    }

    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
//        $name = trim($arguments[0], '\'"');

        $core->setVariable($arguments[0], $arguments[1]);
    }
}
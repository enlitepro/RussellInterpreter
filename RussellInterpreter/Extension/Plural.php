<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * Class Plural
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Plural
    extends RussellInterpreter\Extension
{
    const FORM_1 = 1;

    const FORM_2 = 2;

    const FORM_5 = 3;

    public function execute(array $arguments, RussellInterpreter\Interpreter $core)
    {
        $number = $this->getNumber($arguments);
        $number = $number % 100;
        $n1 = $number % 10;

        if ($number > 10 && $number < 20) {
            return $arguments[self::FORM_5];
        }

        if ($n1 > 1 && $n1 < 5) {
            return $arguments[self::FORM_2];
        }

        if ($n1 == 1) {
            return $arguments[self::FORM_1];
        }

        return $arguments[self::FORM_5];
    }

    protected function getNumber($arguments)
    {
        $number = $arguments[0];
        $number = abs($number);
        return $number;
    }
}
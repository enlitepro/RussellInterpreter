<?php

namespace RussellInterpreter\Extension;

use RussellInterpreter;

include_once __DIR__ . '/../Extension.php';

/**
 * Class Cycle
 * @package RussellInterpreter\Extension
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Cycle
    extends RussellInterpreter\Extension
{
    const LOOPS_LIMIT = 100000;

    protected $loop = 0;

    /**
     * @var RussellInterpreter\Interpreter
     */
    protected $interpreter = null;

    /**
     * @param \RussellInterpreter\Interpreter $interpreter
     */
    public function setInterpreter($interpreter)
    {
        $this->interpreter = $interpreter;
    }

    /**
     * @return \RussellInterpreter\Interpreter
     */
    public function getInterpreter()
    {
        return $this->interpreter;
    }

    protected function increment()
    {
        $this->loop++;
    }

    protected function reset()
    {
        $this->loop = 0;
    }

    protected function checkLoopsLimit()
    {
        if (self::LOOPS_LIMIT == $this->loop) {
            throw new RussellInterpreter\Exception('Infinite loop');
        }
    }

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
        $this->setInterpreter($core);

        $expr = $arguments[0];
        $statements = array_slice($arguments, 1);

        while ($this->expr($expr)) {
            foreach ($statements as $statement) {
                $core->calculation($statement);
            }
        }

        $this->reset();
    }

    protected function expr($expr)
    {
        $this->checkLoopsLimit();
        $this->increment();
        $result = $this->getInterpreter()->calculation($expr);
        return $result;
    }
}
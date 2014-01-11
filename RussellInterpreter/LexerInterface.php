<?php

namespace RussellInterpreter;

/**
 * Interface LexerInterface
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
interface LexerInterface
{
    /**
     * @param string $code
     * @return ParserTree
     */
    public function code($code);
}
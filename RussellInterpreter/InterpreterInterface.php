<?php

namespace RussellInterpreter;

/**
 * Interface InterpreterInterface
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
interface InterpreterInterface
{
    /**
     * @param array|string $synonyms
     * @param Extension $extension
     */
    public function addExtension($synonyms, Extension $extension);

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setVariable($name, $value);

    /**
     * @param ParserTreeInterface $parserTree
     * @return boolean
     */
    public function execute(ParserTreeInterface $parserTree);

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return array
     */
    public function getVariables();
}
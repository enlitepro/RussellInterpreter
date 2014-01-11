<?php

namespace RussellInterpreter;

include_once 'Exception.php';

/**
 * Russell Interpreter
 *
 * @package RussellInterpreter
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Interpreter
{
    /**
     * @var Extension[]
     */
    protected $extensions = [];

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var array
     */
    protected $tokens = [];

    /**
     * @param array|string $synonyms
     * @param Extension $extension
     */
    public function addExtension($synonyms, Extension $extension)
    {
        if (! is_array($synonyms)) {
            $synonyms = array($synonyms);
        }

        foreach ($synonyms as $synonym) {
            $this->extensions[$synonym] = $extension;
        }
    }

    public function getExtension($name)
    {
        if (! isset($this->extensions[$name])) {
            throw new Exception("Function '{$name}' not found");
        }

        return $this->extensions[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getVariable($name, $default = null)
    {
        return isset($this->variables[$name])
             ? $this->variables[$name] : $default;
    }

    /**
     * @param $array
     */
    public function execute($array)
    {
        $this->tokens = $array['tokens'];
        foreach ($array['program'] as $operation) {
            $this->compil($operation);
        }
    }

    public function compil($operation)
    {
        $operation = $this->tokens[$operation];
        switch ($operation) {
            case Parser::TYPE_FUNCTION:
                $this->excuteFunction($operation);
        }
    }
}
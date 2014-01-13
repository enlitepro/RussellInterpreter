<?php

namespace RussellInterpreter;

include_once 'Exception.php';
include_once 'InterpreterInterface.php';

/**
 * Russell Interpreter
 *
 * @package RussellInterpreter
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Interpreter
    implements InterpreterInterface
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
    protected $errors = [];

    /**
     * @var ParserTree
     */
    protected $parserTree = null;

    /**
     * @param array $params
     */
    function __construct(array $params = array())
    {
        if (isset($params['extensions'])) {
            foreach ($params['extensions'] as $extension) {
                $this->addExtension(
                    $extension['synonyms'],
                    $extension['object']
                );
            }
        }
    }

    /**
     * @param \RussellInterpreter\ParserTreeInterface $parserTree
     */
    public function setParserTree(ParserTreeInterface $parserTree)
    {
        $this->parserTree = $parserTree;
    }

    /**
     * @return \RussellInterpreter\ParserTreeInterface
     */
    public function getParserTree()
    {
        return $this->parserTree;
    }

    /**
     * @param array|string $synonyms
     * @param Extension $extension
     */
    public function addExtension($synonyms, Extension $extension)
    {
        if (! is_array($synonyms)) {
            $synonyms = array($synonyms);
        }

        foreach ($synonyms as $synonym)
        {
            $extension->init($this);
            $this->extensions[$synonym] = $extension;
        }
    }

    public function getExtension($name)
    {
        if (! isset($this->extensions[$name])) {
            throw new \Exception("Function '{$name}' not found");
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
        if (isset($this->variables[$name])) {
            $default = $this->variables[$name];
        }
        return $default;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param array $variables
     */
    public function setVariables($variables)
    {
        $this->variables = $variables;
    }

    /**
     * Clear errors and variables
     */
    public function clear()
    {
        $this->variables = [];
        $this->errors = [];
    }

    /**
     * @param ParserTreeInterface $parserTree
     * @return bool|void
     */
    public function execute(ParserTreeInterface $parserTree)
    {
        $this->setParserTree($parserTree);
        $tree = $this->getParserTree()->getTree();

        $isComplete = true;

        try {
            foreach ($tree as $entity) {
                $this->calculation($entity);
            }
        }
        catch(Exception $e) {
            $this->errors[] = $e->getMessage();
            $isComplete = false;
        }

        return $isComplete;
    }

    public function calculation($entity)
    {
        if (is_string($entity) && $this->getParserTree()->isToken($entity)) {
            $entity = $this->getParserTree()->getEntityByToken($entity);
        }

        if (is_array($entity)) {
            switch ($entity['type']) {
                case ParserTree::TYPE_FUNCTION:
                    return $this->calculationFunction($entity);

                case ParserTree::TYPE_VARIABLE:
                    return $this->getVariable($entity['name']);
            }
        }
        else {
            return $entity;
        }
    }

    /**
     * @param array
     * @return mixed
     */
    public function calculationFunction($function)
    {
        $extensionName = strtolower($function['name']);
        $extension = $this->getExtension($extensionName);
        $arguments = $extension->calculationArguments($function['arguments'], $this);
//        if (! $arguments) {
//            $arguments = $this->calculationArguments($function['arguments']);
//        }
        return $extension->execute($arguments, $this);
    }

    /**
     * @param array $arguments
     * @return array
     */
    public function calculationArguments($arguments)
    {
        $result = [];
        foreach ($arguments as $key => $argument) {
            $result[$key] = $this->calculation($argument);
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
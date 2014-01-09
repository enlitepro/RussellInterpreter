<?php

namespace RussellInterpreter;

include_once 'Interpreter/Exception.php';

/**
 * Russell Interpreter
 *
 * @package RussellInterpreter
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Interpreter
{
    /**
     * @var array
     */
    protected $_variables = array();

    /**
     * @var int
     */
    protected $_nesting = 0;

    /**
     *
     */
    const NESTING_MAX = 100;

    /**
     * @var array
     */
    protected $_functions = array();

    const PREG_PATTERN_FUNCTION = '/([A-Za-z_]+)(\(.*\))/i';
    const PREG_PATTERN_ARGUMENTS = '/(\,.?)?(["\'A-Za-z0-9_]+)(\(.*\))?/';
    const PREG_PATTERN_VARIABLE = '/^[A-Za-z]([A-Za-z0-9]+)?/';

    /**
     * @throws Exception
     * @param string $code
     * @return array
     */
    public function code($code)
    {
        if (empty($code) || !is_string($code)) {
            throw new Exception('Error, it\'s not code');
        }

        $this->_parseFunctions($code);
        return $this->_variables;
    }

    /**
     * @param string $code
     * @return array
     */
    protected function _parseFunctions($code)
    {
        preg_match_all(self::PREG_PATTERN_FUNCTION, $code, $matches);
        $result = array();
        $this->nestingIncrement();
        foreach ($matches[0] as $key => $d) {
            $name = $matches[1][$key];
            if ($name) {
                $arguments = $this->_parseArgument($matches[2][$key]);
                $this->executeFunction($name, $arguments);
            }
        }
        $this->nestingReset();
        return $result;
    }

    /**
     * @param string $name
     * @param string $arguments
     * @return mixed
     */
    protected function _parseFunction($name, $arguments)
    {
        $this->nestingIncrement();
        $this->nestingCheck();
        $arguments = $this->_parseArgument($arguments);
        return $this->executeFunction($name, $arguments);
    }

    /**
     * @param string $arguments
     * @return array
     */
    public function _parseArgument($arguments)
    {
        //delete parentheses
        $lastIndex = strlen($arguments) - 1;
        if ($arguments[0] === '(' && $arguments[$lastIndex] === ')') {
            $arguments = substr($arguments, 1);
            $arguments = substr($arguments, 0, $lastIndex - 1);
        }

        preg_match_all(self::PREG_PATTERN_ARGUMENTS, $arguments, $arguments);

        foreach ($arguments[2] as $index => $argument) {
            if (($arguments[3][$index] == '')) {
                if ($this->isVariable($argument)) {
                    $result[] = $this->getVariable($argument);
                }
                else {
                    $result[] = $argument;
                }
            }
            else {
                $result[] = $this->_parseFunction($argument, $arguments[3][$index]);
            }
        }

        return $result;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setVariable($name, $value)
    {
        $this->_variables[$name] = $value;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getVariable($name, $default = NULL)
    {
        return isset($this->_variables[$name])
             ? $this->_variables[$name]: $default;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function executeFunction($name, $arguments = array())
    {
        return $this->getFunction($name)->execute($arguments, $this);
    }

    /**
     * @param string $name
     * @param Method $object
     */
    public function addFunction($name,  Method $object)
    {
        $this->_functions[$name] = $object;
    }

    public function getFunction($name)
    {
        if(! isset($this->_functions[$name])) {
            throw new Exception("Function '{$name}' not found");
        }
        return $this->_functions[$name];
    }

    public function isVariable($data, $shouldExist = true)
    {
        $isFound = preg_match_all(self::PREG_PATTERN_VARIABLE, $data, $m);
        if ($shouldExist) {
            return $isFound && isset($this->_variables[$data]);
        }
        else {
            return $isFound;
        }
    }

    /**
     * @return int
     */
    public function nestingIncrement()
    {
        return $this->_nesting++;
    }

    public function nestingReset()
    {
        return $this->_nesting = 0;
    }

    public function nestingCheck()
    {
        if (self::NESTING_MAX <= $this->_nesting) {
            throw new Exception('Limit is exceeded');
        }
    }
}
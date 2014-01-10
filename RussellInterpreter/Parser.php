<?php

namespace RussellInterpreter;

class Parser
{
    private $tree = array();

    const TYPE_SCALAR = 'scalar';

    const TYPE_VARIABLE = 'variable';

    const TYPE_FUNCTION = 'function';

    const TYPE_TEXT = 'text';

    const ARGUMENT_DELIMITER = ',';

    //Maximum function nesting level of '100'
    const NESTING_MAX = 20;

    protected $nesting = 0;

    /**
     * @var array
     */
    protected $tokens = [];

    public function reset()
    {
        $this->tokens = [];
    }

    protected function resetNesting()
    {
        $this->nesting = 0;
    }

    protected function checkNesting()
    {
        if (self::NESTING_MAX <= $this->nesting) {
            throw new Exception('Maximum function nesting level of '.self::NESTING_MAX);
        }
    }

    protected function incrementNesting()
    {
        $this->nesting++;
    }

    /**
     * Get text and get token
     *
     * @param string $text
     * @return string
     */
    public function setScalarText($text)
    {
        $token = $this->getToken(md5($text), self::TYPE_TEXT);
        $this->tokens[$token] = $text;
        return $token;
    }

    /**
     * Return text or default value by md5 key
     *
     * @param $token
     * @param mixed $default
     * @return mixed
     */
    public function getScalarText($token, $default = null)
    {
        return isset($this->tokens[$token])
             ? $this->tokens[$token] : $default;
    }

    /**
     * @param string $function @var
     *  "func(arg1, arg2, {#tocken#})"
     * @return string
     */
    public function setFunction($function)
    {
        $token = $this->getToken(md5($function), self::TYPE_FUNCTION);
        $this->tokens[$token] = $this->parseFunction($function);
        return $token;
    }

    public function parseFunction($function)
    {
        if (preg_match_all('/([A-Za-z_][A-Za-z0-9_]*)(\(.*\))/', $function, $matches)) {
            $name = $matches[1][0];
            $args = $this->parseArguments($matches[2][0]);
            return $this->structFunction($name, $args);
        }
    }

    /**
     * @param string $arguments
     * @return array
     */
    public function parseArguments($arguments)
    {
        //delete parentheses
        $lastIndex = strlen($arguments) - 1;
        if ($arguments[0] === '(' && $arguments[$lastIndex] === ')') {
            $arguments = substr($arguments, 1);
            $arguments = substr($arguments, 0, $lastIndex - 1);
        }

        $arguments = explode(self::ARGUMENT_DELIMITER, $arguments);
        $arguments = array_map(function($var){
            return trim($var);
        }, $arguments);

        return $arguments;
    }

    /**
     * @param $key
     * @param mixed $default
     * @return mixed
     */
    public function getFunction($key, $default = null)
    {
        return isset($this->tokens[$key])
             ? $this->tokens[$key] : $default;
    }

    /**
     * Get code with string, changes it to special tag and return
     * @param string $code
     * @return string
     */
    public function parseScalarText($code)
    {
        $code = preg_replace_callback("/'([^']|\n)*'/s", function($text){
            return $this->setScalarText($text[0]);
        }, $code);

        return $code;
    }

    /**
     * @param string $code
     * @return array
     */
    public function code($code)
    {
        $code = $this->parseScalarText($code);
        $code = $this->removeUnnecessarySymbols($code);
        $code = $this->parseFunctions($code);
        $firstLineOfToken = $this->splitTokens($code);

        return array(
            'program' => $firstLineOfToken,
            'tokens' => $this->tokens,
        );
    }

    /**
     * @param string $code
     * @return array
     */
    public function splitTokens($code)
    {
        return preg_split('/ /', $code);
    }

    /**
     * @param string $code
     * @return string mixed
     */
    public function removeUnnecessarySymbols($code)
    {
        $code = preg_replace('/\s+/', ' ', $code);

        return $code;
    }

    /**
     * @param string $code
     * @return string
     */
    public function parseFunctions($code)
    {
        $this->checkNesting();
        $this->incrementNesting();

        if ($res = preg_match_all('/[A-Za-z_]+\([^(^)]*\)/', $code, $matches)) {
            foreach ($matches[0] as $function) {
                $token = $this->setFunction($function);
                $code = str_replace($function, $token, $code);
            }

            $code = $this->parseFunctions($code);
        }

        $this->resetNesting();

        return $code;
    }

    /**
     * @param mixed $value
     * @return array
     */
    protected function structScalar($value)
    {
        return array(
            'type'  => self::TYPE_SCALAR,
            'value' => $value,
        );
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return array
     */
    protected function structVariable($name, $value)
    {
        return array(
            'type'  => self::TYPE_VARIABLE,
            'name'  => $name,
            'value' => $value,
        );
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return array
     */
    protected function structFunction($name, $arguments = array())
    {
        return array(
            'type'      => self::TYPE_FUNCTION,
            'name'      => $name,
            'arguments' => $arguments,
        );
    }

    protected function getToken($key, $type)
    {
        switch ($type) {
            case self::TYPE_FUNCTION:
                return "{#{$key}#}";

            case self::TYPE_TEXT:
                return "{%{$key}%}";

            default:
                throw new Exception('Unknown type for token');
        }
    }
}
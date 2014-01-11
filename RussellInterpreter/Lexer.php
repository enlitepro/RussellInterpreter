<?php

namespace RussellInterpreter;

include_once 'LexerInterface.php';

/**
 * @package RussellInterpreter
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class Lexer
    implements LexerInterface
{
    const ARGUMENT_DELIMITER = ',';

    //Maximum function nesting level of '100'
    const NESTING_MAX = 20;

    protected $nesting = 0;

    /**
     * @var ParserTreeInterface
     */
    protected $parserTree = null;

    /**
     * @var array
     */
    protected $tokens = [];

    function __construct($params = array())
    {
        if (isset($params['parser_tree'])) {
            $this->setParserTree($params['parser_tree']);
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
     * @param $code
     * @return mixed
     */
    public function setFunction($code)
    {
        $function = $this->parseFunction($code);
        $token = $this->getParserTree()->setFunction(
            $code,
            $function['name'],
            $function['arguments']
        );
        return $token;
    }

    public function parseFunction($function)
    {
        if (preg_match_all('/([A-Za-z_][A-Za-z0-9_]*)(\(.*\))/', $function, $matches)) {
            return array(
                'name'      => $matches[1][0],
                'arguments' => $this->parseArguments($matches[2][0])
            );
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
            return $this->getParserTree()->setScalarText($text[0]);
        }, $code);

        return $code;
    }

    /**
     * @param string $code
     * @return ParserTree
     */
    public function code($code)
    {
        $code = $this->parseScalarText($code);
        $code = $this->removeUnnecessarySymbols($code);
        $code = $this->parseFunctions($code);
        $firstLineOfTree = $this->splitTokens($code);

        $this->getParserTree()->setTree($firstLineOfTree);
        return $this->getParserTree();
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

        if (preg_match_all('/[A-Za-z_]+\([^(^)]*\)/', $code, $matches)) {
            foreach ($matches[0] as $function) {
                $token = $this->setFunction($function);
                $code = str_replace($function, $token, $code);
            }

            $code = $this->parseFunctions($code);
        }

        $this->resetNesting();

        return $code;
    }
}
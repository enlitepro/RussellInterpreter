<?php

//use RussellInterpreter;

class LexerTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var RussellInterpreter\Parser
     */
    protected $object = null;

    public function setUp()
    {
        $this->object = new RussellInterpreter\Lexer();
    }

    public function testSetGetScalarText()
    {
//        $text = 'hello';
//        $key = $this->object->setScalarText($text);
//        $this->assertEquals($text, $this->object->getScalarText($key));
    }

    public function testParserString()
    {
//        $this->object->reset();
//
//        $code = <<<EOL
//concatenation('This is text', '!', '')
//    concatenation('"', '
//', '"') variable(str, 'string')
//EOL;
//
//        $code = $this->object->parseScalarText($code);
//        $this->assertAttributeCount(6, 'tokens', $this->object);
//        $this->assertNotEmpty($code);
    }

    public function testParseFunctions()
    {
//        $code = <<<EOL
//functionA(
//  functionAA(1, 2, 3),
//  functionAB(
//    functionABA(4, 5),
//    functionABB(6)
//  )
//)
//functionB()
//functionC(7,89)
//functionD(
//    functionDA(
//        functionDAA(
//            functionDAAA()
//        )
//    )
//)
//EOL;
//
//        $code = $this->object->removeUnnecessarySymbols($code);
//        $code = $this->object->parseFunctions($code);
//        $this->assertNotEmpty($code);
    }

    /**
     * @dataProvider providerParserArguments
     */
    public function testParseArguments($text, $arguments)
    {
//        $result = $this->object->parseArguments($text);
//        foreach ($arguments as $key => $argument) {
//            $this->assertEquals($argument, $result[$key]);
//        }
    }

    public function providerParserArguments()
    {
        return array(
            array(
                '(1, 2, 3)',
                array('1', '2', '3'),
            ),

            array(
                '(4,5,6)',
                array('4', '5', '6'),
            ),

            array(
                '(-1000,{%bar%},{#foo#})',
                array('-1000', '{%bar%}', '{#foo#}'),
            ),

            array(
                '~!@#$%^&*()',
                array('~!@#$%^&*()'),
            ),
        );
    }

    /**
     * @dataProvider providerParseFunction
     */
    public function testParseFunction($function, $name, $args)
    {
//        $struct = $this->object->parseFunction($function);
//        $this->assertEquals($struct['name'], $name);
//        $this->assertEquals($struct['arguments'], $args);
    }

    public function providerParseFunction()
    {
        return array(
            array(
                'function(2, 3, 4)',
                'function',
                array('2', '3', '4'),
            ),

            array(
                'foo( bar , {#hello#} , () )',
                'foo',
                array('bar', '{#hello#}', '()'),
            ),
        );
    }
}
<?php

/**
 * @author Dzyanis Kuzmenka <dzyanis@gmail.com>
 */
class IncrementTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var RussellInterpreter\Extension\Increment
     */
    protected $object = null;

    /**
     * @var RussellInterpreter\Interpreter
     */
    protected $interpeter = null;

    /**
     * @var RussellInterpreter\ParserTree
     */
    protected $parserTree = null;

    public function setUp()
    {
        $this->object = new RussellInterpreter\Extension\Increment();
        $this->interpeter = new RussellInterpreter\Interpreter();
        $this->parserTree = new RussellInterpreter\ParserTree();
    }

    public function testExecuteScalar()
    {
        $value = $this->object->execute(array(10), $this->interpeter);
        $this->assertEquals(11, $value);
    }

    public function testExecuteEmptyValue()
    {
//        $varisble = $this->parserTree->
//        $value = $this->object->execute(array(array('name')), $this->interpeter);
//        $this->assertEquals(11, $value);
//
//        $value = $this->interpeter->getVariable('i', this->interpeter);
    }
}
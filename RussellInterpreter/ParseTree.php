<?php


namespace RussellInterpreter;

include 'ParserTreeInterface.php';

class ParserTree
    implements ParserTreeInterface
{
    /**
     * @var array
     */
    protected $tree = [];

    /**
     * @var array
     */
    protected $entities = [];

    /**
     * @param string $token
     * @return mixed
     */
    public function getEntityByToken($token)
    {
        // pass
    }

    /**
     * @param $token
     * @param mixed $entity
     */
    public function setEntityByToken($token, $entity)
    {
        // pass
    }


}
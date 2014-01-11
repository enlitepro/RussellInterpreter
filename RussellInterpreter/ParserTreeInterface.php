<?php

namespace RussellInterpreter;

interface ParserTreeInterface
{
    /**
     * @param string $token
     * @return mixed
     */
    public function getEntityByToken($token);

    /**
     * @param $token
     * @param mixed $entity
     */
    public function setEntityByToken($token, $entity);
}
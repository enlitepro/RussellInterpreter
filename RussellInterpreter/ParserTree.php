<?php


namespace RussellInterpreter;

include_once 'ParserTreeInterface.php';

class ParserTree
    implements ParserTreeInterface
{
    const TYPE_SCALAR   = 'scalar';

    const TYPE_VARIABLE = 'variable';

    const TYPE_FUNCTION = 'function';

    const TYPE_TEXT     = 'text';

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
        return $this->entities[$token];
    }

    /**
     * @param $token
     * @param mixed $entity
     */
    public function setEntityByToken($token, $entity)
    {
        $this->entities[$token] = $entity;
    }

    /**
     * Get text and get token
     *
     * @param string $text
     * @return string
     */
    public function setScalarText($text)
    {
        $token = $this->getToken($text, self::TYPE_TEXT);
        $this->setEntityByToken($token, $this->structScalar($text));
        return $token;
    }

    public function setFunction($function, $name, $arguments)
    {
        $token = $this->getToken($function, self::TYPE_FUNCTION);
        $this->setEntityByToken(
            $token,
            $this->structFunction($name, $arguments)
        );
        return $token;
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

    public function variable($value)
    {
        if ($this->isToken($value)) {
            return $value;
        }
        elseif (is_numeric($value)) {
            return $value;
        }
        else {
            return $this->structVariable($value);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return array
     */
    protected function structVariable($name, $value = null)
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

    /**
     * @param string $entity
     * @param mixed $type
     * @return string
     * @throws Exception
     */
    protected function getToken($entity, $type)
    {
        $key = md5($entity);

        switch ($type) {
            case self::TYPE_FUNCTION:
                return "{#{$key}#}";

            case self::TYPE_TEXT:
                return "{%{$key}%}";

            default:
                throw new Exception('Unknown type for token');
        }
    }

    public function isToken($token)
    {
        return isset($this->entities[$token]);
    }

    /**
     * @param array $tree
     */
    public function setTree(array $tree)
    {
        $this->tree = $tree;
    }

    public function getTree()
    {
        return $this->tree;
    }
}
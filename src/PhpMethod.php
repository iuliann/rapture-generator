<?php

namespace Rapture\Generator;

use Rapture\Generator\Definition\CommentTrait;
use Rapture\Generator\Definition\CommonTrait;

/**
 * PHP method
 *
 * @package Rapture\Generator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class PhpMethod
{
    use CommonTrait;
    use CommentTrait;

    const KEYWORD_PUBLIC = 'public';

    const KEYWORD_PROTECTED = 'protected';

    const KEYWORD_PRIVATE = 'private';

    protected $name;

    protected $params = [];

    protected $body;

    protected $return = '';

    /**
     * @param string $name Method name
     * @param string $body Method body
     * @param string $visibility Method visibility
     * @param array $params Method parameters
     * @param string $return PHP7 return
     */
    public function __construct($name, $body = '', $visibility = self::KEYWORD_PUBLIC, array $params = [], $return = '')
    {
        $this->name = $name;
        $this->return = $return;
        $this->body = $body;
        $this->setVisibility($visibility);

        foreach ($params as $param) {
            $param = (array)$param + [null, null, null];
            $this->addParam($param[0], $param[1], $param[2]);
        }
    }

    /**
     * Set method name
     *
     * @param string $name Method name
     *
     * @return self
     */
    public function setName($name):PhpMethod
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set method's static mode
     *
     * @param bool $isStatic Static mode
     *
     * @return self
     */
    public function setIsStatic($isStatic = true):PhpMethod
    {
        $this->isStatic = (bool)$isStatic;

        return $this;
    }

    /**
     * Set method body
     *
     * @param string $body Method body
     * @param array  $params Array-key replacements
     *
     * @return self
     */
    public function setBody($body = '', array $params = []):PhpMethod
    {
        $this->body = str_replace(array_keys($params), $params, implode("\n", (array)$body));

        return $this;
    }

    /**
     * Add method param
     *
     * @param string $name Param name
     * @param string $typeHint Param type-hint
     * @param null $default Param default value
     *
     * @return self
     */
    public function addParam($name, $typeHint = '', $default = null):PhpMethod
    {
        $this->params[$name] = [$typeHint, $default];

        return $this;
    }

    /**
     * Get method name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get method body
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get method params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Get return value
     *
     * @return string
     */
    public function getReturn():string
    {
        return $this->return;
    }
}

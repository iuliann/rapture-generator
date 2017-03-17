<?php

namespace Rapture\Generator;

use Rapture\Generator\Definition\CommentTrait;

/**
 * PHP Class generator
 *
 * @package Rapture\Generator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class PhpClass
{
    use CommentTrait;

    const KEYWORD_FINAL = 'final';
    const KEYWORD_ABSTRACT = 'abstract';

    protected $namespace;

    protected $uses = [];

    protected $isFinal = false;

    protected $isAbstract = false;

    protected $isTrait = false;

    protected $name;

    protected $extends;

    protected $interfaces = [];

    protected $traits = [];

    protected $constants = [];

    protected $methods = [];

    protected $properties = [];

    /**
     * @param string $name Class name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Change class name
     *
     * @param string $name Class name
     *
     * @return self
     */
    public function setName($name):PhpClass
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set abstract mode
     *
     * @param bool $isAbstract Abstract mode
     *
     * @return self
     */
    public function setIsAbstract($isAbstract = true):PhpClass
    {
        $this->isAbstract = (bool)$isAbstract;

        return $this;
    }

    /**
     * Set final mode
     *
     * @param bool $isFinal Final mode
     *
     * @return self
     */
    public function setIsFinal($isFinal = true):PhpClass
    {
        $this->isFinal = (bool)$isFinal;

        return $this;
    }

    /**
     * Set parent class
     *
     * @param string $extends Parent class
     *
     * @return self
     */
    public function setExtends($extends):PhpClass
    {
        $this->addUse($extends);

        $this->extends = $this->getClassName($extends);

        return $this;
    }

    /**
     * Mark class as trait
     *
     * @param bool $isTrait Set to true to make class as trait
     *
     * @return self
     */
    public function setIsTrait($isTrait = false):PhpClass
    {
        $this->isTrait = (bool)$isTrait;

        return $this;
    }

    /**
     * Add class constant
     *
     * @param string $name Constant name
     * @param mixed $value Constant value
     *
     * @return self
     */
    public function addConstant($name, $value):PhpClass
    {
        $this->constants[strtoupper($name)] = $value;

        return $this;
    }

    /**
     * Add class interfaces
     *
     * @param string $interface Interface name
     *
     * @return self
     */
    public function addImplements($interface):PhpClass
    {
        $this->addUse($interface);

        $this->interfaces[] = $this->getClassName($interface);

        return $this;
    }

    /**
     * Add class property
     *
     * @param PhpProperty $property Property object
     *
     * @return self
     */
    public function addProperty(PhpProperty $property):PhpClass
    {
        $this->properties[$property->getName()] = $property;

        return $this;
    }

    /**
     * Add class method
     *
     * @param PhpMethod $method Method object
     *
     * @return self
     */
    public function addMethod(PhpMethod $method):PhpClass
    {
        $this->methods[$method->getName()] = $method;

        return $this;
    }

    /**
     * Add use
     *
     * @param string $use Use
     * @param mixed $alias Alias of use
     *
     * @return self
     */
    public function addUse($use, $alias = null):PhpClass
    {
        $use = trim($use, '\\');

        $this->uses[$use] = [$use, $alias];

        return $this;
    }

    /**
     * Add class trait
     *
     * @param string $trait Trait name
     *
     * @return self
     */
    public function addTrait($trait):PhpClass
    {
        $this->addUse($trait);

        $this->traits[] = $this->getClassName($trait);

        return $this;
    }

    /**
     * Set namespace
     *
     * @param string $namespace Namespace
     *
     * @return self
     */
    public function setNamespace($namespace):PhpClass
    {
        $this->namespace = $namespace;

        return $this;
    }

    /*
    * Getters
    */

    /**
     * Check if isFinal
     *
     * @return bool
     */
    public function isFinal()
    {
        return $this->isFinal;
    }

    /**
     * Check if isAbstract
     *
     * @return bool
     */
    public function isAbstract()
    {
        return $this->isAbstract;
    }

    /**
     * Check if isTrait
     *
     * @return bool
     */
    public function isTrait()
    {
        return $this->isTrait;
    }

    /**
     * Get parent class
     *
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * Get class implemented interfaces
     *
     * @return array
     */
    public function getImplements()
    {
        return $this->interfaces;
    }

    /**
     * Get class name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get class namespace
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get class uses
     *
     * @return array
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * Get class traits
     *
     * @return array
     */
    public function getTraits()
    {
        return $this->traits;
    }

    /**
     * Get class constants
     *
     * @return array
     */
    public function getConstants()
    {
        return $this->constants;
    }

    /**
     * Get class properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Get class methods
     *
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * getFullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->getNamespace() . '\\' . $this->getName();
    }

    /*
     * Helpers
     */

    public function getClassName($className = '')
    {
        return substr($className, strrpos($className, '\\') + 1);
    }
}

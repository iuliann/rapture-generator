<?php

namespace Rapture\Generator\Definition;

use Rapture\Generator\PhpMethod;

/**
 * Common methods used by generators
 *
 * @package Rapture\Generator
 * @author Iulian N. <Rapture@iuliann.ro>
 * @license LICENSE MIT
 */
trait CommonTrait
{
    protected $isFinal = false;

    protected $isAbstract = false;

    protected $isStatic = false;

    protected $visibility = PhpMethod::KEYWORD_PUBLIC;

    /**
     * setAbstract
     *
     * @param bool $isAbstract Abstract mode
     *
     * @return self
     */
    public function setIsAbstract($isAbstract = true)
    {
        $this->isAbstract = $isAbstract;

        return $this;
    }

    /**
     * setFinal
     *
     * @param bool $isFinal Final mode
     *
     * @return self
     */
    public function setIsFinal($isFinal = true)
    {
        $this->isFinal = $isFinal;

        return $this;
    }

    /**
     * setStatic
     *
     * @param bool $isStatic Static mode
     *
     * @return self
     */
    public function setIsStatic($isStatic = true)
    {
        $this->isStatic = $isStatic;

        return $this;
    }

    /**
     * setVisibility
     *
     * @param string $visibility Visibility mode
     *
     * @return $this
     */
    public function setVisibility($visibility = PhpMethod::KEYWORD_PUBLIC)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get generator's visibility
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Check if generator is abstract
     *
     * @return bool
     */
    public function isAbstract()
    {
        return $this->isAbstract;
    }

    /**
     * Check if generator is final
     *
     * @return bool
     */
    public function isFinal()
    {
        return $this->isFinal;
    }

    /**
     * Check if generator is static
     *
     * @return bool
     */
    public function isStatic()
    {
        return $this->isStatic;
    }
}

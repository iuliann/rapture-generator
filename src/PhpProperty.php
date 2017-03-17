<?php

namespace Rapture\Generator;

use Rapture\Generator\Definition\CommentTrait;
use Rapture\Generator\Definition\CommonTrait;

/**
 * PHP class property
 *
 * @package Rapture\Generator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class PhpProperty
{
    use CommonTrait;
    use CommentTrait;

    protected $name;

    protected $value;

    /**
     * @param string $name Property name
     * @param null $value Property value
     * @param string $visibility Property visibility
     * @param PhpComment $comment Comment
     */
    public function __construct($name, $value = null, $visibility = PhpMethod::KEYWORD_PUBLIC, PhpComment $comment = null)
    {
        $this->name = $name;
        $this->value = $value === null
            ? ''
            : (is_scalar($value) ? $value : var_export($value, true));
        $this->visibility = $visibility;
        $this->comment = $comment;
    }

    /**
     * Get property name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get property value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}


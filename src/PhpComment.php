<?php

namespace Rapture\Generator;

/**
 * PHP comment
 *
 * @package Rapture\Generator
 * @author Iulian N. <rapture@iuliann.ro>
 * @license LICENSE MIT
 */
class PhpComment
{
    const SINGLE_LINE = 1;
    const MULTI_LINE  = 2;
    const DOC_COMMENT = 3;

    protected $lines = [];

    protected $type;

    /**
     * @param mixed $lines Comment lines
     * @param int $type Comment type
     */
    public function __construct($lines = null, $type = self::DOC_COMMENT)
    {
        $this->lines = isset($lines[0]) ? (array)$lines : [];
        $this->type = $type;
    }

    /**
     * addLine
     *
     * @param string $line Comment line
     *
     * @return self
     */
    public function addLine($line):PhpComment
    {
        $this->lines[] = str_replace("\n", ' ', $line);

        return $this;
    }

    /**
     * addLines
     *
     * @param mixed $lines Array|string
     *
     * @return self
     */
    public function addLines($lines):PhpComment
    {
        if (is_array($lines)) {
            $this->lines = array_merge($this->lines, $lines);
        }

        $this->lines[] = $lines;

        return $this;
    }

    /**
     * Check if comment isEmpty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !(bool)count($this->lines);
    }

    /**
     * Get comment as one line
     *
     * @return mixed
     */
    public function getAsSingleLine()
    {
        return str_replace("\n", ' ', implode(' ', $this->lines));
    }

    /**
     * Get comment lines
     *
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Get comment type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }
}

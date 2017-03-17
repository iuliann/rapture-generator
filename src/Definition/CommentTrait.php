<?php

namespace Rapture\Generator\Definition;

use Rapture\Generator\PhpComment;

/**
 * Comment trait used by generators
 *
 * @package Rapture\Generator
 * @author Iulian N. <Rapture@iuliann.ro>
 * @license LICENSE MIT
 */
trait CommentTrait
{
    protected $comment;

    /**
     * setComment
     *
     * @param PhpComment $comment Comment
     *
     * @return self
     */
    public function setComment(PhpComment $comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * getComment
     *
     * @return PhpComment
     */
    public function getComment():PhpComment
    {
        return $this->comment ?: new PhpComment;
    }
}

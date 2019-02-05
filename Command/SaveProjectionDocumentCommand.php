<?php

declare(strict_types=1);

/*
 * This file is part of the MsgPHP package.
 *
 * (c) Roland Franssen <franssen.roland@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MsgPhp\Domain\Command;

use MsgPhp\Domain\Projection\ProjectionDocument;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class SaveProjectionDocumentCommand
{
    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string|null
     */
    public $id;

    /**
     * @var array
     */
    public $body;

    final public function __construct(ProjectionDocument $document)
    {
        $this->type = $document->getType();
        $this->id = $document->getId();
        $this->body = $document->getBody();
    }
}

<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Projection\Event;

use MsgPhp\Domain\Projection\ProjectionDocument;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class ProjectionDocumentDeleted
{
    public $document;

    public function __construct(ProjectionDocument $document)
    {
        $this->document = $document;
    }
}

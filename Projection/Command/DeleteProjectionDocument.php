<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Projection\Command;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class DeleteProjectionDocument
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $id;

    public function __construct(string $type, string $id)
    {
        $this->type = $type;
        $this->id = $id;
    }
}

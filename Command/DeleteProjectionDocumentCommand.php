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

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class DeleteProjectionDocumentCommand
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $id;

    final public function __construct(string $type, string $id)
    {
        $this->type = $type;
        $this->id = $id;
    }
}

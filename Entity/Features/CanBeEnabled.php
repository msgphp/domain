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

namespace MsgPhp\Domain\Entity\Features;

use MsgPhp\Domain\Entity\Fields\EnabledField;
use MsgPhp\Domain\Event\{DisableEvent, EnableEvent};

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
trait CanBeEnabled
{
    use EnabledField;

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }

    private function handleEnableEvent(EnableEvent $event): bool
    {
        if (!$this->enabled) {
            $this->enable();

            return true;
        }

        return false;
    }

    private function handleDisableEvent(DisableEvent $event): bool
    {
        if ($this->enabled) {
            $this->disable();

            return true;
        }

        return false;
    }
}

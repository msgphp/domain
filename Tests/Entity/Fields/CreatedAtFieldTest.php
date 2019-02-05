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

namespace MsgPhp\Domain\Tests\Entity\Fields;

use MsgPhp\Domain\Entity\Fields\CreatedAtField;
use PHPUnit\Framework\TestCase;

final class CreatedAtFieldTest extends TestCase
{
    public function testField(): void
    {
        $object = $this->getObject($value = new \DateTime());

        self::assertSame($value, $object->getCreatedAt());
    }

    /**
     * @return object
     */
    private function getObject($value)
    {
        return new class($value) {
            use CreatedAtField;

            public function __construct($value)
            {
                $this->createdAt = $value;
            }
        };
    }
}

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

use MsgPhp\Domain\Entity\Fields\LastUpdatedAtField;
use PHPUnit\Framework\TestCase;

final class LastUpdatedAtFieldTest extends TestCase
{
    public function testField(): void
    {
        $object = $this->getObject($value = new \DateTime());

        self::assertSame($value, $object->getLastUpdatedAt());
    }

    /**
     * @return object
     */
    private function getObject($value)
    {
        return new class($value) {
            use LastUpdatedAtField;

            public function __construct($value)
            {
                $this->lastUpdatedAt = $value;
            }
        };
    }
}

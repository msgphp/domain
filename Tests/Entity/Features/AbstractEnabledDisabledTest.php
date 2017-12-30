<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Tests\Entity\Features;

use MsgPhp\Domain\Entity\Features\AbstractEnabledDisabled;
use PHPUnit\Framework\TestCase;

final class AbstractEnabledDisabledTest extends TestCase
{
    /**
     * @dataProvider provideStates
     */
    public function testObject(bool $state): void
    {
        $object = $this->getObject($state);

        $this->assertSame($state, $object->isEnabled());

        if ($state) {
            $object->disable();
        } else {
            $object->enable();
        }

        $this->assertSame(!$state, $object->isEnabled());

        if ($state) {
            $object->enable();
        } else {
            $object->disable();
        }

        $this->assertSame($state, $object->isEnabled());
    }

    public function provideStates(): iterable
    {
        yield [true];
        yield [false];
    }

    private function getObject($value)
    {
        return new class($value) {
            use AbstractEnabledDisabled;

            private static $defaultEnabled;

            public function __construct($value)
            {
                self::$defaultEnabled = $value;
            }

            protected static function isDefaultEnabled(): bool
            {
                return self::$defaultEnabled;
            }
        };
    }
}

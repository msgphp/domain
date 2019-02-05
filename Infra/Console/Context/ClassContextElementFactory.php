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

namespace MsgPhp\Domain\Infra\Console\Context;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ClassContextElementFactory implements ClassContextElementFactoryInterface
{
    /**
     * @inheritdoc
     */
    public function getElement(string $class, string $method, string $argument): ContextElement
    {
        return new ContextElement(ucfirst((string) preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'], ['\\1 \\2', '\\1 \\2'], $argument)));
    }
}

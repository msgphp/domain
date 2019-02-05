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

namespace MsgPhp\Domain\Factory;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface DomainObjectFactoryInterface
{
    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     *
     * @return object
     */
    public function create(string $class, array $context = []);

    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     *
     * @return object
     */
    public function reference(string $class, array $context = []);

    /**
     * @psalm-param class-string $class
     * @psalm-return class-string
     */
    public function getClass(string $class, array $context = []): string;
}

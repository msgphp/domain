<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Factory;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface DomainObjectFactory
{
    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public function create(string $class, array $context = []): object;

    /**
     * @psalm-template T
     * @psalm-param class-string<T> $class
     * @psalm-return T
     */
    public function reference(string $class, array $context = []): object;

    /**
     * @psalm-param class-string $class
     * @psalm-return class-string
     */
    public function getClass(string $class, array $context = []): string;
}

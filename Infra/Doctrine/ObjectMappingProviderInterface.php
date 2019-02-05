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

namespace MsgPhp\Domain\Infra\Doctrine;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
interface ObjectMappingProviderInterface
{
    public const TYPE_EMBEDDED = 'embedded';
    public const TYPE_MANY_TO_MANY = 'manyToMany';
    public const TYPE_MANY_TO_ONE = 'manyToOne';
    public const TYPE_ONE_TO_MANY = 'oneToMany';
    public const TYPE_ONE_TO_ONE = 'oneToOne';

    public static function provideObjectMappings(MappingConfig $config): iterable;
}

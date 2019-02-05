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

namespace MsgPhp\Domain\Infra\Config;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class TreeBuilderHelper
{
    /**
     * @param mixed $treeBuilder
     */
    public static function root(string $name, &$treeBuilder = null): ArrayNodeDefinition
    {
        $treeBuilder = new TreeBuilder($name, 'array', $builder = new NodeBuilder());

        /** @var ArrayNodeDefinition $node */
        $node = method_exists($treeBuilder, 'getRootNode') ? $treeBuilder->getRootNode() : $treeBuilder->root($name, 'array', $builder);

        return $node;
    }
}

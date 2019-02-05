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

use Symfony\Component\Config\Definition\Builder\NodeBuilder as BaseNodeBuilder;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class NodeBuilder extends BaseNodeBuilder
{
    public function __construct()
    {
        parent::__construct();

        $this->setNodeClass(ClassMappingNodeDefinition::NAME, ClassMappingNodeDefinition::class);
    }

    public function classMappingNode(string $name): ClassMappingNodeDefinition
    {
        /** @var ClassMappingNodeDefinition $node */
        $node = $this->node($name, ClassMappingNodeDefinition::NAME);

        return $node;
    }
}

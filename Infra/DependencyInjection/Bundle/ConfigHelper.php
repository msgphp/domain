<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Infra\DependencyInjection\Bundle;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 *
 * @internal
 */
final class ConfigHelper
{
    public static function createClassMappingNode(string $name, array $required = [], \Closure $normalizer = null, NodeBuilder $builder = null): ArrayNodeDefinition
    {
        $node = ($builder ?? new NodeBuilder())->arrayNode($name);

        if ($required) {
            $node->isRequired();

            foreach ($required as $class => $message) {
                if (is_int($class)) {
                    $class = $message;
                    $message = '';
                } else {
                    $message = '. '.$message;
                }
                $node->validate()
                    ->ifTrue(function (array $value) use ($class) {
                        return !isset($value[$class]);
                    })
                    ->thenInvalid(sprintf('Class "%s" must be configured'.$message, $class))
                ->end();
            }
        }

        if ($normalizer) {
            $node->beforeNormalization()->always($normalizer);
        }

        $node
            ->useAttributeAsKey('class')
            ->scalarPrototype()
                ->cannotBeEmpty()
            ->end();

        return $node;
    }

    private function __construct()
    {
    }
}

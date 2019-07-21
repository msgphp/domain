<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Projection;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ProjectionDocumentProvider implements \IteratorAggregate
{
    /** @var iterable<int, callable():object> */
    private $dataProviders;
    /** @var callable(object):array */
    private $transformer;
    /** @var callable(object):string */
    private $typeResolver;

    /**
     * @template T
     *
     * @param iterable<int, callable():T> $dataProviders
     * @param callable(T): array          $transformer
     * @param callable(T): string         $typeResolver
     */
    public function __construct(iterable $dataProviders, callable $transformer, callable $typeResolver)
    {
        $this->dataProviders = $dataProviders;
        $this->transformer = $transformer;
        $this->typeResolver = $typeResolver;
    }

    /**
     * @return \Traversable<string, array>
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->dataProviders as $dataProvider) {
            foreach ($dataProvider() as $object) {
                yield ($this->typeResolver)($object) => ($this->transformer)($object);
            }
        }
    }
}

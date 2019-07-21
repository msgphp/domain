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

    /**
     * @template T
     *
     * @param iterable<int, callable():T> $dataProviders
     * @param callable(T): array          $transformer
     */
    public function __construct(iterable $dataProviders, callable $transformer)
    {
        $this->dataProviders = $dataProviders;
        $this->transformer = $transformer;
    }

    /**
     * @return \Traversable<object, array>
     */
    public function getIterator(): \Traversable
    {
        foreach ($this->dataProviders as $dataProvider) {
            foreach ($dataProvider() as $object) {
                yield $object => ($this->transformer)($object);
            }
        }
    }
}

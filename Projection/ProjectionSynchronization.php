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

namespace MsgPhp\Domain\Projection;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ProjectionSynchronization
{
    /**
     * @var ProjectionTypeRegistryInterface
     */
    private $typeRegistry;

    /**
     * @var ProjectionRepositoryInterface
     */
    private $repository;

    /**
     * @var iterable|ProjectionDocument[]
     */
    private $documentProvider;

    /**
     * @param iterable|ProjectionDocument[] $documentProvider
     */
    public function __construct(ProjectionTypeRegistryInterface $typeRegistry, ProjectionRepositoryInterface $repository, iterable $documentProvider)
    {
        $this->typeRegistry = $typeRegistry;
        $this->repository = $repository;
        $this->documentProvider = $documentProvider;
    }

    /**
     * @return ProjectionDocument[]
     */
    public function synchronize(): iterable
    {
        foreach ($this->typeRegistry->all() as $type) {
            $this->repository->clear($type);
        }

        foreach ($this->documentProvider as $document) {
            try {
                $document->status = ProjectionDocument::STATUS_SYNCHRONIZED;

                $this->repository->save($document);
            } catch (\Throwable $e) {
                $document->status = ProjectionDocument::STATUS_FAILED_SAVING;
                $document->error = $e;
            }

            yield $document;
        }
    }
}

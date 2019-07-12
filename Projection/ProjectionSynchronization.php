<?php

declare(strict_types=1);

namespace MsgPhp\Domain\Projection;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class ProjectionSynchronization
{
    private $typeRegistry;
    private $repository;
    /** @var iterable<int, ProjectionDocument> */
    private $documentProvider;

    /**
     * @param iterable<int, ProjectionDocument> $documentProvider
     */
    public function __construct(ProjectionTypeRegistry $typeRegistry, ProjectionRepository $repository, iterable $documentProvider)
    {
        $this->typeRegistry = $typeRegistry;
        $this->repository = $repository;
        $this->documentProvider = $documentProvider;
    }

    /**
     * @return iterable<int, ProjectionDocument>
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

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

namespace MsgPhp\Domain\Command\Handler;

use MsgPhp\Domain\Command\DeleteProjectionDocumentCommand;
use MsgPhp\Domain\Event\ProjectionDocumentDeletedEvent;
use MsgPhp\Domain\Factory\DomainObjectFactoryInterface;
use MsgPhp\Domain\Message\{DomainMessageBusInterface, MessageDispatchingTrait};
use MsgPhp\Domain\Projection\ProjectionRepositoryInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class DeleteProjectionDocumentHandler
{
    use MessageDispatchingTrait;

    /**
     * @var ProjectionRepositoryInterface
     */
    private $repository;

    public function __construct(DomainObjectFactoryInterface $factory, DomainMessageBusInterface $bus, ProjectionRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->bus = $bus;
        $this->repository = $repository;
    }

    public function __invoke(DeleteProjectionDocumentCommand $command): void
    {
        $document = $document = $this->repository->find($command->type, $command->id);
        if (null === $document) {
            return;
        }

        $type = $document->getType();
        if (null === $type) {
            throw new \LogicException('Document must have a type.');
        }

        $id = $document->getId();
        if (null === $id) {
            throw new \LogicException('Document must have an ID.');
        }

        $this->repository->delete($type, $id);
        $this->dispatch(ProjectionDocumentDeletedEvent::class, compact('document'));
    }
}

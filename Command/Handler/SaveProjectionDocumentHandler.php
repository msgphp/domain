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

use MsgPhp\Domain\Command\SaveProjectionDocumentCommand;
use MsgPhp\Domain\Event\ProjectionDocumentSavedEvent;
use MsgPhp\Domain\Factory\DomainObjectFactoryInterface;
use MsgPhp\Domain\Message\{DomainMessageBusInterface, MessageDispatchingTrait};
use MsgPhp\Domain\Projection\{ProjectionDocument, ProjectionRepositoryInterface};

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class SaveProjectionDocumentHandler
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

    public function __invoke(SaveProjectionDocumentCommand $command): void
    {
        $document = new ProjectionDocument($command->type, $command->id, $command->body);

        $this->repository->save($document);
        $this->dispatch(ProjectionDocumentSavedEvent::class, compact('document'));
    }
}

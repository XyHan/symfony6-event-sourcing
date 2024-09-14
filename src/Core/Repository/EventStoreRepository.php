<?php

declare(strict_types=1);

namespace Core\Repository;

use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactory;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Repository\AggregateNotFoundException;
use Security\Domain\Repository\EventStoreRepositoryInterface;

class EventStoreRepository implements EventStoreRepositoryInterface
{
    private AggregateFactory $aggregateFactory;

    public function __construct(
        private EventStore $eventStore,
        private EventBus $eventBus,
        private string $aggregateClass
    ) {
        $this->aggregateFactory = new PublicConstructorAggregateFactory();
    }

    public function load(string $id): AggregateRoot
    {
        try {
            $domainEventStream = $this->eventStore->load($id);

            return $this->aggregateFactory->create($this->aggregateClass, $domainEventStream);
        } catch (EventStreamNotFoundException $e) {
            throw AggregateNotFoundException::create($id, $e);
        }
    }

    public function save(AggregateRoot $aggregate): void
    {
        $domainEventStream = $aggregate->getUncommittedEvents();
        $this->eventStore->append($aggregate->getAggregateRootId(), $domainEventStream);
        $this->eventBus->publish($domainEventStream);
    }
}

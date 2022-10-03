<?php

declare(strict_types=1);

namespace Spiral\Queue\Event;

final class JobProcessing
{
    public function __construct(
        public readonly string $name,
        public readonly string $driver,
        public readonly string $queue,
        public readonly string $id,
        public readonly array $payload,
        public readonly array $context = []
    ) {
    }
}

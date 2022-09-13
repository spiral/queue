<?php

declare(strict_types=1);

namespace Spiral\Queue;

use Spiral\Queue\Job\ObjectJob;

trait QueueTrait
{
    public function pushObject(object $job, ?OptionsInterface $options = null): string
    {
        return $this->push(ObjectJob::class, ['object' => $job], $options);
    }
}

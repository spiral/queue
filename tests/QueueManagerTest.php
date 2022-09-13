<?php

declare(strict_types=1);

namespace Spiral\Tests\Queue;

use Mockery as m;
use Spiral\Core\Container;
use Spiral\Core\CoreInterface;
use Spiral\Queue\Config\QueueConfig;
use Spiral\Queue\Failed\FailedJobHandlerInterface;
use Spiral\Queue\HandlerRegistryInterface;
use Spiral\Queue\QueueManager;
use Spiral\Queue\Driver\SyncDriver;

final class QueueManagerTest extends TestCase
{
    protected function setUp(): void
    {
        $config = new QueueConfig([
            'default' => 'sync',
            'aliases' => [
                'user-data' => 'sync',
            ],
            'connections' => [
                'sync' => [
                    'driver' => 'sync',
                ]
            ],
            'driverAliases' => [
                'sync' => SyncDriver::class,
            ],
        ]);

        $container = new Container();
        $container->bind(CoreInterface::class, m::mock(CoreInterface::class));

        parent::setUp();

        $this->manager = new QueueManager($config, $container);
    }

    public function testGetsDefaultConnection(): void
    {
        $this->assertInstanceOf(
            SyncDriver::class,
            $this->manager->getConnection()
        );
    }

    public function testGetsConnectionByNameWithDriverAlias(): void
    {
        $this->assertInstanceOf(
            SyncDriver::class,
            $this->manager->getConnection('sync')
        );
    }

    public function testGetsPipelineByAlias(): void
    {
        $this->assertInstanceOf(
            SyncDriver::class,
            $queue = $this->manager->getConnection('user-data')
        );

        $this->assertSame($queue, $this->manager->getConnection('sync'));
    }
}

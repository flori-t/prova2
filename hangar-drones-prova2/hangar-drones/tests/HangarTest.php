<?php

declare(strict_types=1);

namespace Tests;

use App\{Drone, Hangar};
use PHPUnit\Framework\TestCase;

final class HangarTest extends TestCase
{

    public function testCount()
    {
        $hangar = new Hangar(19);


        self::assertSame(19, $hangar->capacity());
        self::assertSame(0, $hangar->insideCount());
        self::assertSame(0, $hangar->dockedCount());
        self::assertSame(0, $hangar->maintenanceCount());
        self::assertSame(0, $hangar->inFlightCount());
        self::assertSame(0, $hangar->retiredCount());
        self::assertSame(true, $hangar->hasFreeSlot());
    }

    public function testAddDrone()
    {
        $hangar = new Hangar(4);

        $drone1 = new Drone("JB1", 2, Drone::STATUS_DOCKED);
        $drone2 = new Drone("JB2", 22, Drone::STATUS_MAINTENANCE);

        $hangar->addDrone($drone1);
        $hangar->addDrone($drone2);

        self::assertSame(4, $hangar->capacity());
        self::assertSame(1, $hangar->dockedCount());
        self::assertSame(1, $hangar->maintenanceCount());
    }

}
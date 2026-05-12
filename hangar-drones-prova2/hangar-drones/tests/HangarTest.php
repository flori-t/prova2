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

}
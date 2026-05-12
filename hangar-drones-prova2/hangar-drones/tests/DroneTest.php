<?php

declare(strict_types=1);

namespace Tests;

use App\{Drone, Hangar};
use PHPUnit\Framework\TestCase;

final class DroneTest extends TestCase
{
    public function testId()
    {
        $drone = new Drone("JB", 20, Drone::STATUS_DOCKED);
        self::assertSame('JB', $drone->id());
    }

    public function testflightMinutes()
    {
        $drone = new Drone("JB", 2, Drone::STATUS_DOCKED);
        self::assertSame(2, $drone->flightMinutes());
    }

    public function testStatus()
    {
        $drone1 = new Drone("JB1", 2, Drone::STATUS_DOCKED);
        $drone2 = new Drone("JB2", 2, Drone::STATUS_IN_FLIGHT);
        $drone3 = new Drone("JB3", 2, Drone::STATUS_MAINTENANCE);
        $drone4 = new Drone("JB4", 2, Drone::STATUS_RETIRED);

        self::assertSame(Drone::STATUS_DOCKED, $drone1->status());
        self::assertSame(Drone::STATUS_IN_FLIGHT, $drone2->status());
        self::assertSame(Drone::STATUS_MAINTENANCE, $drone3->status());
        self::assertSame(Drone::STATUS_RETIRED, $drone4->status());
    }

    public function testtakeOff()
    {
        $drone = new Drone("JB", 2, Drone::STATUS_DOCKED);

        $drone->takeOff($drone);

        self::assertSame(Drone::STATUS_IN_FLIGHT, $drone->status());
    }

    public function testmarkDocked()
    {
        $drone = new Drone("JB", 2, Drone::STATUS_IN_FLIGHT);

        $drone->markDocked($drone);

        self::assertSame(Drone::STATUS_DOCKED, $drone->status());
    }

    public function testsendToMaintenance()
    {
        $drone = new Drone("JB", 2, Drone::STATUS_DOCKED);

        $drone->sendToMaintenance($drone);

        self::assertSame(Drone::STATUS_MAINTENANCE, $drone->status());
    }

    public function testreturnFromMaintenance()
    {
        $drone = new Drone("JB", 2, Drone::STATUS_MAINTENANCE);

        $drone->returnFromMaintenance($drone);

        self::assertSame(Drone::STATUS_DOCKED, $drone->status());
    }

    public function retire()
    {
        $drone = new Drone("JB", 2, Drone::STATUS_MAINTENANCE);

        $drone->retire($drone);

        self::assertSame(Drone::STATUS_RETIRED, $drone->status());
    }

    public function testaddFlightMinutes()
    {
        $drone = new Drone("JB", 2, Drone::STATUS_IN_FLIGHT);

        $drone->addFlightMinutes(25);

        self::assertSame(27, $drone->flightMinutes());

        $drone->addFlightMinutes(25);

        self::assertSame(52, $drone->flightMinutes());
    }
}

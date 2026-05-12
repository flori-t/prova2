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
}
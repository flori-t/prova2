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

    public function testlaunchDrone()
    {
        $hangar = new Hangar(4);

        $drone = new Drone("JB1", 2, Drone::STATUS_DOCKED);

        $hangar->addDrone($drone);
        $hangar->launchDrone($drone);


        self::assertSame(Drone::STATUS_IN_FLIGHT, $drone->status());
    }

    public function testlandDrone()
    {
        $hangar = new Hangar(4);
        $drone = new Drone("JB1", 2, Drone::STATUS_DOCKED);

        $hangar->addDrone($drone);
        $hangar->launchDrone($drone);
        $hangar->landDrone($drone, 20);


        self::assertSame(22, $drone->flightMinutes());
        self::assertSame(Drone::STATUS_MAINTENANCE, $drone->status());
        self::assertSame(1, $hangar->maintenanceCount());
    }

    public function testsendToMaintenance()
    {
        $hangar = new Hangar(4);
        $drone = new Drone("JB", 2, Drone::STATUS_DOCKED);

        $hangar->addDrone($drone);
        $hangar->sendToMaintenance("   JB  ");


        self::assertSame(Drone::STATUS_MAINTENANCE, $drone->status());
    }

    public function testreleaseFromMaintenance()
    {
        $hangar = new Hangar(4);
        $drone = new Drone("JB", 2, Drone::STATUS_MAINTENANCE);

        $hangar->addDrone($drone);
        $hangar->releaseFromMaintenance("  JB   ");


        self::assertSame(Drone::STATUS_DOCKED, $drone->status());
    }

    public function testretire()
    {
        $hangar = new Hangar(4);
        $drone = new Drone("JB", 2, Drone::STATUS_MAINTENANCE);

        $hangar->addDrone($drone);
        $hangar->retireDrone("JB");

        self::assertSame(1, $hangar->retiredCount());
    }

    public function testIDS()
    {
        $hangar = new Hangar(10);
        $drone = new Drone("JB", 2, Drone::STATUS_DOCKED);
        $drone2 = new Drone("JB2", 22, Drone::STATUS_DOCKED);
        $drone3 = new Drone("JB3", 23, Drone::STATUS_MAINTENANCE);
        $drone4 = new Drone("JB4", 24, Drone::STATUS_DOCKED);
        $drone5 = new Drone("JB5", 2, Drone::STATUS_MAINTENANCE);


        $hangar->addDrone($drone);
        $hangar->addDrone($drone2);
        $hangar->addDrone($drone3);
        $hangar->addDrone($drone4);
        $hangar->addDrone($drone5);


        $hangar->retireDrone("JB5");

        $hangar->launchDrone();

        self::assertSame(["JB2", "JB4"], $hangar->dockedDroneIds());
        self::assertSame(["JB3"], $hangar->maintenanceDroneIds());
        self::assertSame(["JB"], $hangar->inFlightDroneIds());
        self::assertSame(["JB5"], $hangar->retiredDroneIds());

    }

}
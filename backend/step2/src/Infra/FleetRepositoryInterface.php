<?php

namespace Fulll\Infra;

use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;

interface FleetRepositoryInterface
{
    /**
     * Gets a fleet by its identifier.
     *
     * @param int $fleetId The identifier of the fleet.
     *
     * @return Fleet|null The fleet, or null if not found.
     */
    public function getById(int $fleetId): ?Fleet;

    /**
     * Gets a fleet by its user identifier.
     *
     * @param int $userId The user identifier of the fleet.
     *
     * @return Fleet|null The fleet, or null if not found.
     */
    public function getByUserId(int $userId): ?Fleet;

    /**
     * Saves a fleet.
     *
     * @param Fleet $fleet The fleet to be saved.
     * 
     * @return Fleet|null The fleet
     */
    public function save(Fleet $fleet): ?Fleet;

    /**
     * Add a vehicle to a fleet.
     *
     * @param Fleet   $fleet   The fleet.
     * @param Vehicle $vehicle The vehicle to be added.
     * 
     * @return Fleet|null The fleet
     */
    public function addVehicle(Fleet $fleet, Vehicle $vehicle): ?Fleet;
}

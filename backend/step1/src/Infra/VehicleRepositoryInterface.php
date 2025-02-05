<?php

namespace Fulll\Infra;

use Fulll\Domain\Vehicle;

interface VehicleRepositoryInterface
{
    /**
     * Gets a vehicle by its plate number.
     *
     * @param string $plateNumber The plate number of the vehicle.
     *
     * @return Vehicle|null The vehicle, or null if not found.
     */
    public function getByPlateNumber(string $plateNumber): ?Vehicle;

    /**
     * Saves a vehicle.
     *
     * @param Vehicle $vehicle The vehicle to be saved.
     * 
     * @return Vehicle The vehicle
     */
    public function save(Vehicle $vehicle): Vehicle;
}

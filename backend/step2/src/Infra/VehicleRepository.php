<?php

namespace Fulll\Infra;

use Fulll\Domain\Vehicle;

class VehicleRepository implements VehicleRepositoryInterface
{
    private array $_vehicles = [];

    /**
     * Gets a vehicle by its plate number.
     *
     * @param string $plateNumber The plate number of the vehicle.
     *
     * @return Vehicle|null The vehicle, or null if not found.
     */
    public function getByPlateNumber(string $plateNumber): ?Vehicle
    {
        return $this->_vehicles[$plateNumber] ?? null;
    }

    /**
     * Saves a vehicle.
     *
     * @param Vehicle $vehicle The vehicle to be saved.
     * 
     * @return Vehicle
     */
    public function save(Vehicle $vehicle): Vehicle
    {
        $this->_vehicles[$vehicle->getPlateNumber()] = $vehicle;

        return $vehicle;
    }
}

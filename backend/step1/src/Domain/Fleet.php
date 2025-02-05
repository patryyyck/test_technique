<?php

namespace Fulll\Domain;

use Exception;

class Fleet
{
    private array $_vehicles = [];
    private int $_id;

    /**
     * Initializes a new instance of the Fleet class.
     *
     * @param int $_user_id The user identifier of the fleet.
     */
    public function __construct(private int $_user_id)
    {
    }

    /**
     * Gets the identifier of the fleet.
     *
     * @return int The fleet identifier.
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * Sets the unique identifier of the fleet.
     *
     * @param int $id The ID.
     * 
     * @return void
     */
    public function setId(int $id): void
    {
        $this->_id = $id;
    }

    /**
     * Gets the user identifier of the fleet.
     *
     * @return int The fleet identifier.
     */
    public function getUserId(): int
    {
        return $this->_user_id;
    }

    /**
     * Adds a vehicle to the fleet.
     *
     * @param Vehicle $vehicle The vehicle to be added.
     * 
     * @return void
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        if ($this->hasVehicle($vehicle)) {
            throw new Exception('Vehicle already registered');
        }

        $this->_vehicles[$vehicle->getPlateNumber()] = $vehicle;
    }

    /**
     * Gets the list of vehicles in the fleet.
     *
     * @return array The list of vehicles.
     */
    public function getVehicles(): array
    {
        return $this->_vehicles;
    }

    /**
     * Verifies if the fleet has a specific vehicle.
     *
     * @param Vehicle $vehicle The vehicle to be verified.
     * 
     * @return boolean
     */
    public function hasVehicle(Vehicle $vehicle): bool
    {
        return isset($this->_vehicles[$vehicle->getPlateNumber()]);
    }
}

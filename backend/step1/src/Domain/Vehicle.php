<?php

namespace Fulll\Domain;

use Exception;

class Vehicle
{
    private int $_id;

    /**
     * Initializes a new instance of the Vehicle class.
     *
     * @param string        $_plateNumber The plate number of the vehicle.
     * @param Location|null $_location    The plate number of the vehicle.
     */
    public function __construct(
        private string $_plateNumber,
        private ?Location $_location = null
    ) {
    }

    /**
     * Gets the unique identifier of the vehicle.
     *
     * @return int The unique identifier.
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * Sets the unique identifier of the vehicle.
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
     * Gets the plate number of the vehicle.
     *
     * @return string The plate number.
     */
    public function getPlateNumber(): string
    {
        return $this->_plateNumber;
    }
    
    /**
     * Sets the plate number of the vehicle.
     *
     * @param string $plateNumber The plate number.
     * 
     * @return void
     */
    public function setPlateNumber(string $plateNumber): void
    {
        $this->_plateNumber = $plateNumber;
    }
    
    /**
     * Gets the location of the vehicle.
     *
     * @return Location|null The location of the vehicle, or null if not localized.
     */
    public function getLocation(): ?Location
    {
        return $this->_location;
    }

    /**
     * Localizes the vehicle to a specific location.
     *
     * @param Location $location The location to which the vehicle is localized.
     * 
     * @return void
     */
    public function localize(Location $location): void
    {
        $previousLocation = $this->getLocation();
        if ($previousLocation === $location) {
            throw new Exception(
                'Can\'t localize my vehicle to the same location two times in a row'
            );
        }

        $this->_location = $location;
    }
}

<?php

namespace Fulll\App\Command;

class RegisterVehicleCommand
{
    /**
     * Constructs a new RegisterVehicleCommand instance.
     *
     * @param int    $_fleetId     The ID of the fleet.
     * @param string $_plateNumber The plate number of the vehicle.
     */
    public function __construct(private int $_fleetId, private string $_plateNumber)
    {
    }

    /**
     * Gets the fleet ID associated with the command.
     *
     * @return int The fleet ID.
     */
    public function getFleetId(): int
    {
        return $this->_fleetId;
    }

    /**
     * Gets the vehicle plate number associated with the command.
     *
     * @return string The vehicle plate number.
     */
    public function getPlateNumber(): string
    {
        return $this->_plateNumber;
    }
}
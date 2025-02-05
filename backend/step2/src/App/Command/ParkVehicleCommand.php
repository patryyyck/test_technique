<?php

namespace Fulll\App\Command;

class ParkVehicleCommand
{
    /**
     * Constructs a new LocalizeVehicleCommand instance.
     *
     * @param int    $_fleetId     The fleet ID.
     * @param string $_plateNumber The vehicle plate number.
     * @param float  $_lat         The latitude coordinate.
     * @param float  $_lng         The longitude coordinate.
     * @param ?float $_alt         The altitude coordinate.
     */
    public function __construct(
        private int $_fleetId,
        private string $_plateNumber,
        private float $_lat,
        private float $_lng,
        private ?float $_alt
    ) {
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
    public function getVehiclePlateNumber(): string
    {
        return $this->_plateNumber;
    }

    /**
     * Gets the latitude coordinate associated with the command.
     *
     * @return float The latitude coordinate.
     */
    public function getLat(): float
    {
        return $this->_lat;
    }

    /**
     * Gets the longitude coordinate associated with the command.
     *
     * @return float The longitude coordinate.
     */
    public function getLng(): float
    {
        return $this->_lng;
    }

    /**
     * Gets the altitude coordinate associated with the command.
     *
     * @return ?float The altitude coordinate.
     */
    public function getAlt(): ?float
    {
        return $this->_alt;
    }
}

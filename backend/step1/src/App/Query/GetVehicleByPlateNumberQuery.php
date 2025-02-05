<?php

namespace Fulll\App\Query;

class GetVehicleByPlateNumberQuery
{
    /**
     * Constructs a new GetVehicleByPlaneNumberQuery instance.
     *
     * @param string $_plateNumber The plate number.
     */
    public function __construct(private string $_plateNumber)
    {
    }

    /**
     * Gets the plate number associated with the query.
     *
     * @return string The plate number.
     */
    public function getPlateNumber(): string
    {
        return $this->_plateNumber;
    }
}
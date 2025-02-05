<?php

namespace Fulll\App\Query;

class GetFleetQuery
{
    /**
     * Constructs a new GetFleetQuery instance.
     *
     * @param int $_fleetId The ID of the fleet.
     */
    public function __construct(private int $_fleetId)
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
}
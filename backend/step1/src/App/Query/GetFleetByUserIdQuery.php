<?php

namespace Fulll\App\Query;

class GetFleetByUserIdQuery
{
    /**
     * Constructs a new GetFleetByUserIdQuery instance.
     *
     * @param int $_userId The ID of the fleet.
     */
    public function __construct(private int $_userId)
    {
    }

    /**
     * Gets the fleet ID associated with the command.
     *
     * @return int The fleet ID.
     */
    public function getUserId(): int
    {
        return $this->_userId;
    }
}
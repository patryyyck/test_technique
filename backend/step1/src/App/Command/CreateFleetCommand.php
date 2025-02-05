<?php

namespace Fulll\App\Command;

class CreateFleetCommand
{
    /**
     * Constructs a new CreateFleetCommand instance.
     *
     * @param int $_userId The ID of the user.
     */
    public function __construct(private int $_userId)
    {
    }

    /**
     * Gets the user ID associated with the command.
     *
     * @return int The user ID.
     */
    public function getUserId(): int
    {
        return $this->_userId;
    }
}
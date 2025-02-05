<?php

namespace Fulll\App\Command;

use Exception;
use Fulll\Domain\Fleet;
use Fulll\Infra\FleetRepositoryInterface;

class CreateFleetHandler
{
    /**
     * Constructs a new CreateFleetHandler instance.
     *
     * @param FleetRepositoryInterface $_fleetRepository The repository for fleets.
     */
    public function __construct(private FleetRepositoryInterface $_fleetRepository)
    {
    }

    /**
     * Handles the CreateFleetCommand to create a fleet.
     *
     * @param CreateFleetCommand $command The create fleet command.
     * 
     * @return Fleet
     */
    public function handle(CreateFleetCommand $command): Fleet
    {
        $fleet = new Fleet($command->getUserId());
        $this->_fleetRepository->save($fleet);

        return $fleet;
    }
}
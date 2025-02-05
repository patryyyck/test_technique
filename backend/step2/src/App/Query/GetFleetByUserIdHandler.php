<?php

namespace Fulll\App\Query;

use Exception;
use Fulll\Domain\Fleet;
use Fulll\Infra\FleetRepositoryInterface;

class GetFleetByUserIdHandler
{
    /**
     * Constructs a new RegisterVehicleHandler instance.
     *
     * @param FleetRepositoryInterface $_fleetRepository The repository for fleets.
     */
    public function __construct(private FleetRepositoryInterface $_fleetRepository)
    {
    }

    /**
     * Handles the GetFleetByUserIdtQuery to get a fleet.
     *
     * @param GetFleetByUserIdQuery $query The GetFleetByUserId query.
     * 
     * @return Fleet|null The fleet if found
     */
    public function handle(GetFleetByUserIdQuery $query): ?Fleet
    {
        $userId = $query->getUserId();

        $fleet = $this->_fleetRepository->getByUserId($userId);
        if ($fleet === null) {
            throw new Exception('Fleet not found.');
        }

        return $fleet;
    }
}
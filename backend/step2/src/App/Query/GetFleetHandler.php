<?php

namespace Fulll\App\Query;

use Exception;
use Fulll\Domain\Fleet;
use Fulll\Infra\FleetRepository;
use Fulll\Infra\FleetRepositoryInterface;
use Fulll\Infra\VehicleRepository;
use Fulll\Infra\VehicleRepositoryInterface;

class GetFleetHandler
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
     * Handles the GetFleetQuery to get a fleet.
     *
     * @param GetFleetQuery $query The GetFleet query.
     * 
     * @return Fleet The fleet.
     */
    public function handle(GetFleetQuery $query): ?Fleet
    {
        $fleetId = $query->getFleetId();

        $fleet = $this->_fleetRepository->getById($fleetId);
        if ($fleet === null) {
            throw new Exception('Fleet not found.');
        }

        return $fleet;
    }
}
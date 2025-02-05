<?php

namespace Fulll\App\Query;

use Exception;
use Fulll\Domain\Vehicle;
use Fulll\Infra\VehicleRepositoryInterface;

class GetVehicleByPlateNumberHandler
{
    /**
     * Constructs a new RegisterVehicleHandler instance.
     *
     * @param VehicleRepositoryInterface $_vehicleRepository The vehicle repository.
     */
    public function __construct(
        private VehicleRepositoryInterface $_vehicleRepository
    ) {
    }

    /**
     * Handles the GetFleetByUserIdtQuery to get a fleet.
     *
     * @param GetVehicleByPlateNumberQuery $query The GetFleetByUserId query.
     * 
     * @return Vehicle|null Vehicle if found
     */
    public function handle(GetVehicleByPlateNumberQuery $query): ?Vehicle
    {
        $plateNumber = $query->getPlateNumber();

        $vehicle = $this->_vehicleRepository->getByPlateNumber($plateNumber);
        if ($vehicle === null) {
            throw new Exception('Vehicle not found.');
        }

        return $vehicle;
    }
}

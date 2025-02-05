<?php

namespace Fulll\App\Command;

use Exception;
use Fulll\Infra\FleetRepository;
use Fulll\Infra\FleetRepositoryInterface;
use Fulll\Infra\VehicleRepository;
use Fulll\Infra\VehicleRepositoryInterface;

class RegisterVehicleHandler
{
    /**
     * Constructs a new RegisterVehicleHandler instance.
     *
     * @param FleetRepository   $_fleetRepository   The repository for fleets.
     * @param VehicleRepository $_vehicleRepository The repository for vehicles.
     */
    public function __construct(
        private FleetRepositoryInterface $_fleetRepository,
        private VehicleRepositoryInterface $_vehicleRepository
    ) {
    }

    /**
     * Handles the RegisterVehicleCommand to register a vehicle into a fleet.
     *
     * @param RegisterVehicleCommand $command The registration command.
     *
     * @throws \RuntimeException If the vehicle is already registered.
     * 
     * @return void
     */
    public function handle(RegisterVehicleCommand $command): void
    {
        $fleetId = $command->getFleetId();
        $plateNumber = $command->getPlateNumber();

        $fleet = $this->_fleetRepository->getById($fleetId);
        if ($fleet === null) {
            throw new Exception('Fleet not found.');
        }

        $vehicle = $this->_vehicleRepository->getByPlateNumber($plateNumber);
        if ($vehicle === null) {
            throw new Exception('Vehicle not found.');
        }

        $this->_fleetRepository->addVehicle($fleet, $vehicle);
    }

    public function handle2(RegisterVehicleCommand $command): void
    {
        $fleetId = $command->getFleetId();
        $plateNumber = $command->getPlateNumber();

        $fleet = $this->_fleetRepository->getById($fleetId);
        if ($fleet === null) {
            throw new Exception('Fleet not found.');
        }

        $vehicle = $this->_vehicleRepository->getByPlateNumber($plateNumber);
        if ($vehicle === null) {
            throw new Exception('Vehicle not found.');
        }

        $this->_fleetRepository->addVehicle($fleet, $vehicle);
    }
}

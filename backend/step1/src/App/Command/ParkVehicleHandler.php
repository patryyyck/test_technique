<?php

namespace Fulll\App\Command;

use Exception;
use Fulll\Domain\Location;
use Fulll\Infra\FleetRepositoryInterface;
use Fulll\Infra\VehicleRepositoryInterface;

class ParkVehicleHandler
{
    /**
     * Constructs a new LocalizeVehicleHandler instance.
     *
     * @param FleetRepositoryInterface   $_fleetRepository   The fleet repository.
     * @param VehicleRepositoryInterface $_vehicleRepository The vehicle repository.
     */
    public function __construct(
        private FleetRepositoryInterface $_fleetRepository,
        private VehicleRepositoryInterface $_vehicleRepository
    ) {
    }

    /**
     * Handles the LocalizeVehicleCommand to localize a vehicle.
     *
     * @param ParkVehicleCommand $command The localization command.
     *
     * @throws Exception If the fleet or vehicle is not found.
     * 
     * @return void
     */
    public function handle(ParkVehicleCommand $command): void
    {
        $fleetId = $command->getFleetId();
        $plateNumber = $command->getVehiclePlateNumber();

        $lat = $command->getLat();
        $lng = $command->getLng();
        $alt = $command->getAlt();

        $fleet = $this->_fleetRepository->getById($fleetId);
        if ($fleet === null) {
            throw new Exception('Fleet not found.');
        }

        $vehicle = $this->_vehicleRepository->getByPlateNumber($plateNumber);
        if ($vehicle === null) {
            throw new Exception('Vehicle not found.');
        }

        //        if (!$fleet->hasVehicle($vehicle)) {
        //            throw new Exception('Vehicle is not part of the fleet.');
        //        }

        $currentLocation = $vehicle->getLocation();
        if ($currentLocation !== null
            && $currentLocation->getLat() === $lat
            && $currentLocation->getLng() === $lng
            && $currentLocation->getAlt() === $alt
        ) {
            throw new \RuntimeException(
                'Vehicle is already parked at this location.'
            );
        }

        $location = new Location($lat, $lng, $alt);
        $vehicle->localize($location);

        $this->_vehicleRepository->save($vehicle);
    }
}

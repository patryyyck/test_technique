<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\CreateFleetHandler;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\ParkVehicleHandler;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\App\Command\RegisterVehicleHandler;
use Fulll\App\Query\GetFleetByUserIdHandler;
use Fulll\App\Query\GetFleetByUserIdQuery;
use Fulll\App\Query\GetVehicleByPlateNumberHandler;
use Fulll\App\Query\GetVehicleByPlateNumberQuery;
use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;
use Fulll\Infra\FleetRepository;
use Fulll\Infra\FleetRepositoryInterface;
use Fulll\Infra\VehicleRepository;
use Fulll\Infra\VehicleRepositoryInterface;

class FeatureContext implements Context
{
    private $_vehicleAlreadyRegisteged = false;
    private $_aLocation;
    private $_parkedAtSameLocationException = false;

    private FleetRepositoryInterface $_fleetRepository;
    private VehicleRepositoryInterface $_vehicleRepository;

    public function __construct()
    {
        $this->_fleetRepository = new FleetRepository();
        $this->_vehicleRepository = new VehicleRepository();
    }

    /**
     * @Given my fleet
     */
    public function _myFleet()
    {
        $command = new CreateFleetCommand(1);
        $_createFleetHandle = new CreateFleetHandler($this->_fleetRepository);
        $_createFleetHandle->handle($command);
    }

    /**
     * @Given a vehicle
     */
    public function _aVehicle()
    {
        $this->_vehicleRepository->save(new Vehicle('ABC-1111'));
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->iRegisterThisVehicleIntoMyFleet();
    }

    /**
     * @Given a location
     */
    public function _aLocation()
    {
        $this->_aLocation = new Location(100, 100, 100);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $query = new GetFleetByUserIdQuery(1);
        $getFleetByUserQuery = new GetFleetByUserIdHandler($this->_fleetRepository);
        $fleet = $getFleetByUserQuery->handle($query);

        $query = new GetVehicleByPlateNumberQuery('ABC-1111');
        $getVehicleByPlateNumberQuery = new GetVehicleByPlateNumberHandler($this->_vehicleRepository);
        $vehicle = $getVehicleByPlateNumberQuery->handle($query);

        $command = new ParkVehicleCommand($fleet->getId(), $vehicle->getPlateNumber(), $this->_aLocation->getLat(), $this->_aLocation->getLng(), $this->_aLocation->getAlt());
        $parkVehicleHandler = new ParkVehicleHandler($this->_fleetRepository, $this->_vehicleRepository);
        $parkVehicleHandler->handle($command);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        $query = new GetVehicleByPlateNumberQuery('ABC-1111');
        $getVehicleByPlateNumberQuery = new GetVehicleByPlateNumberHandler($this->_vehicleRepository);
        $vehicle = $getVehicleByPlateNumberQuery->handle($query);

        $location = $vehicle->getLocation();

        if ($this->_aLocation->getLat() !== $location->getLat() && $this->_aLocation->getLng() !== $location->getLng() && $this->_aLocation->getAlt() !== $location->getAlt()) {
            throw new Exception("The parked location should match the used location.");
        }
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->iParkMyVehicleAtThisLocation();
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        try {
            $this->iParkMyVehicleAtThisLocation();
        } catch (Exception $exception) {
            $this->_parkedAtSameLocationException = true;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        if (!$this->_parkedAtSameLocationException) {
            throw new Exception("Park a vehicle at the same location should throw an exception.");
        }
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $query = new GetFleetByUserIdQuery(1);
        $getFleetByUserQuery = new GetFleetByUserIdHandler($this->_fleetRepository);
        $fleet = $getFleetByUserQuery->handle($query);

        $query = new GetVehicleByPlateNumberQuery('ABC-1111');
        $getVehicleByPlateNumberQuery = new GetVehicleByPlateNumberHandler($this->_vehicleRepository);
        $vehicle = $getVehicleByPlateNumberQuery->handle($query);

        $command = new RegisterVehicleCommand($fleet->getId(), $vehicle->getPlateNumber());
        $registerVehicleHandler = new RegisterVehicleHandler($this->_fleetRepository, $this->_vehicleRepository);
        $registerVehicleHandler->handle($command);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        $query = new GetFleetByUserIdQuery(1);
        $getFleetByUserQuery = new GetFleetByUserIdHandler($this->_fleetRepository);
        $fleet = $getFleetByUserQuery->handle($query);

        $query = new GetVehicleByPlateNumberQuery('ABC-1111');
        $getVehicleByPlateNumberQuery = new GetVehicleByPlateNumberHandler($this->_vehicleRepository);
        $vehicle = $getVehicleByPlateNumberQuery->handle($query);

        if (!$fleet->hasVehicle($vehicle)) {
            throw new Exception("A vehicle should be registered into the fleet");
        }
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        try {
            $this->iRegisterThisVehicleIntoMyFleet();
        } catch (Exception $exception) {
            $this->_vehicleAlreadyRegisteged = true;
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        if (!$this->_vehicleAlreadyRegisteged) {
            throw new Exception("Register an already registered vehicle should throw an exception.");
        }
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        //        $this->_anotherFleet = new Fleet(2);
        $command = new CreateFleetCommand(2);
        $_createFleetHandle = new CreateFleetHandler($this->_fleetRepository);
        $_createFleetHandle->handle($command);
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $query = new GetFleetByUserIdQuery(2);
        $getFleetByUserQuery = new GetFleetByUserIdHandler($this->_fleetRepository);
        $fleet = $getFleetByUserQuery->handle($query);

        $query = new GetVehicleByPlateNumberQuery('ABC-1111');
        $getVehicleByPlateNumberQuery = new GetVehicleByPlateNumberHandler($this->_vehicleRepository);
        $vehicle = $getVehicleByPlateNumberQuery->handle($query);

        $command = new RegisterVehicleCommand($fleet->getId(), $vehicle->getPlateNumber());
        $registerVehicleHandler = new RegisterVehicleHandler($this->_fleetRepository, $this->_vehicleRepository);
        $registerVehicleHandler->handle($command);
    }
}

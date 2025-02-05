<?php

namespace Fulll\Infra;

use Exception;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;

class FleetRepository implements FleetRepositoryInterface
{
    private array $_fleets = [];

    /**
     * Gets a fleet by its identifier.
     *
     * @param int $fleetId The identifier of the fleet.
     *
     * @return Fleet|null The fleet, or null if not found.
     */
    public function getById(int $fleetId): ?Fleet
    {
        return $this->_fleets[$fleetId] ?? null;
    }

    /**
     * Gets a fleet by its user identifier.
     *
     * @param int $userId The user identifier of the fleet.
     *
     * @return Fleet|null The fleet, or null if not found.
     */
    public function getByUserId(int $userId): ?Fleet
    {
        foreach ($this->_fleets as $fleet) {
            if ($fleet->getUserId() === $userId) {
                return $fleet;
            }
        }

        return null;
    }

    /**
     * Saves a fleet.
     *
     * @param Fleet $fleet The fleet to be saved.
     * 
     * @return Fleet|null
     */
    public function save(Fleet $fleet): ?Fleet
    {
        if ($this->getByUserId($fleet->getUserId())) {
            throw new Exception('This user already have a fleet');
        }

        $fleet->setId(count($this->_fleets));
        $this->_fleets[$fleet->getId()] = $fleet;

        return $fleet;
    }

    /**
     * Add a vehicle to a fleet.
     *
     * @param Fleet   $fleet   The fleet.
     * @param Vehicle $vehicle The vehicle to be added.
     * 
     * @return Fleet|null The fleet
     */
    public function addVehicle(Fleet $fleet, Vehicle $vehicle): ?Fleet
    {
        $fleet->addVehicle($vehicle);
        return $fleet;
    }
}

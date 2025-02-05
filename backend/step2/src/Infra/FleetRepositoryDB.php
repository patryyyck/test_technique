<?php

namespace Fulll\Infra;

use Exception;
use Fulll\Domain\Fleet;
use Fulll\Domain\Vehicle;
use PDO;

class FleetRepositoryDB implements FleetRepositoryInterface
{
    /**
     * Initializes a new instance of VehicleRepositoryDB class.
     *
     * @param PDO $pdo PDO.
     */
    public function __construct(private \PDO $pdo)
    {
    }

    /**
     * Gets a fleet by its identifier.
     *
     * @param int $fleetId The identifier of the fleet.
     *
     * @return Fleet|null The fleet, or null if not found.
     */
    public function getById(int $fleetId): ?Fleet
    {
        $select = "SELECT * FROM fleets WHERE id = ?";
        $stmt = $this->pdo->prepare($select);
         
        $stmt->execute(array($fleetId));
        
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        $fleet = $results?new Fleet($results['user_id']):null;

        if ($fleet) {
            $fleet->setId($results['id']);
            $select = "SELECT v.* FROM fleets_vehicles f, vehicles v
                       WHERE f.vehicle_id = v.id AND f.fleet_id = ?";
            $stmt = $this->pdo->prepare($select);
             
            $stmt->execute(array($fleetId));
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                $vehicle = new Vehicle($result['plate_number']);
                $vehicle->setId($result['id']);
                $fleet->addVehicle($vehicle);
            }
        }

        return $fleet;
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
        $select = "SELECT * FROM fleets WHERE user_id = ?";
        $stmt = $this->pdo->prepare($select);
         
        $stmt->execute(array($userId));
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$results) {
            return null;
        }

        $fleet = $results?new Fleet($results['user_id']):null;

        if ($fleet) {
            $fleet->setId($results['id']);
            $select = "SELECT v.* FROM fleets_vehicles f, vehicles v
                       WHERE f.vehicle_id = v.id AND f.fleet_id = ?";
            $stmt = $this->pdo->prepare($select);
             
            $stmt->execute(array($fleet->getId()));
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                $vehicle = new Vehicle($result['plate_number']);
                $vehicle->setId($result['id']);
                $fleet->addVehicle($vehicle);
            }
        }

        return $fleet;
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
        $user_id = $fleet->getUserId();

        if ($this->getByUserId($user_id)) {
            throw new Exception("A fleet with this user ID already exists");
        }

        $insert = "INSERT INTO fleets (user_id) VALUES (:user_id) RETURNING *";
        $stmt = $this->pdo->prepare($insert);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Impossible to create fleet");
        }

        $rows = $stmt->fetch();
        $fleet->setId((int) $rows['id']);

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

        $vehicle_id = $vehicle->getId();
        $fleet_id = $fleet->getId();

        $delete = "DELETE FROM fleets_vehicles WHERE vehicle_id = :vehicle_id";
        $stmt = $this->pdo->prepare($delete);
        $stmt->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
        $stmt->execute();

        $insert = "INSERT INTO fleets_vehicles (fleet_id, vehicle_id)
                   VALUES (:fleet_id, :vehicle_id)";
        $stmt = $this->pdo->prepare($insert);
        $stmt->bindParam(':fleet_id', $fleet_id, PDO::PARAM_INT);
        $stmt->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
        $stmt->execute();
    
        return $fleet;
    }
}

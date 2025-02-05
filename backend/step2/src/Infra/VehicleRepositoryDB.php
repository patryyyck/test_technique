<?php

namespace Fulll\Infra;

use Exception;
use Fulll\Domain\Location;
use Fulll\Domain\Vehicle;
use PDO;

class VehicleRepositoryDB implements VehicleRepositoryInterface
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
     * Gets a vehicle by its plate number.
     *
     * @param string $plateNumber The plate number of the vehicle.
     *
     * @return Vehicle|null The vehicle, or null if not found.
     */
    public function getByPlateNumber(string $plateNumber): ?Vehicle
    {
        $select = "SELECT * FROM vehicles WHERE plate_number = :plate_number";
        $stmt = $this->pdo->prepare($select);
        $stmt->bindParam(':plate_number', $plateNumber, PDO::PARAM_STR);

        $stmt->execute();

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$results) {
            return null;
        }

        $vehicle = new Vehicle($results['plate_number']);

        $vehicle->setId((int) $results['id']);
        if ($results['lat']) {
            $location = new Location(
                $results['lat'],
                $results['lng'],
                $results['alt']
            );
            $vehicle->localize($location);
        }

        return $vehicle;
    }

    /**
     * Saves a vehicle.
     *
     * @param Vehicle $vehicle The vehicle to be saved.
     * 
     * @return Vehicle
     */
    public function save(Vehicle $vehicle): Vehicle
    {
        $plateNumber = $vehicle->getPlateNumber();
        $lat = $vehicle->getLocation() ? $vehicle->getLocation()->getLat() : null;
        $lng = $vehicle->getLocation() ? $vehicle->getLocation()->getLng() : null;
        $alt = $vehicle->getLocation() ? $vehicle->getLocation()->getAlt() : null;

        if ($v = $this->getByPlateNumber($plateNumber)) {
            $update = "UPDATE vehicles SET lat = :lat, lng = :lng, alt = :alt
                       WHERE plate_number = :plate_number RETURNING *";
            $stmt = $this->pdo->prepare($update);
            $stmt->bindParam(':plate_number', $plateNumber, PDO::PARAM_STR);
            $stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
            $stmt->bindParam(':lng', $lng, PDO::PARAM_STR);
            $stmt->bindParam(':alt', $alt, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                throw new Exception("Impossible to update vehicle");
            }

            return $v;
        }

        $insert = "INSERT INTO vehicles (plate_number, lat, lng, alt)
                   VALUES (:plate_number, :lat, :lng, :alt) RETURNING *";
        $stmt = $this->pdo->prepare($insert);
        $stmt->bindParam(':plate_number', $plateNumber, PDO::PARAM_STR);
        $stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
        $stmt->bindParam(':lng', $lng, PDO::PARAM_STR);
        $stmt->bindParam(':alt', $alt, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Impossible to create vehicle");
        }

        $rows = $stmt->fetch();

        $vehicle->setId((int) $rows['id']);

        return $vehicle;
    }
}

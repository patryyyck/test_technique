<?php

declare(strict_types=1);

namespace Fulll\UI;

use Exception;
use Fulll\App\Command\CreateFleetCommand;
use Fulll\App\Command\CreateFleetHandler;
use Fulll\App\Command\ParkVehicleCommand;
use Fulll\App\Command\ParkVehicleHandler;
use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\App\Command\RegisterVehicleHandler;
use Fulll\Infra\FleetRepositoryDB;
use Fulll\Infra\VehicleRepositoryDB;
use PDO;

final class Cli
{
    /**
     * Initializes a new instance of the Cli class.
     *
     * @param PDO $pdo PDO.
     */
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Show help command
     *
     * @return void
     */
    private function _printHelp(): void
    {
        echo "Commands:" . PHP_EOL;
        echo "   create <userId>" . PHP_EOL;
        echo "   register-vehicle <fleetId> <vehiclePlateNumber>" . PHP_EOL;
        echo "   localize-vehicle <fleetId> <vehiclePlateNumber> \
                    lat lng [alt]" . PHP_EOL;
    }

    /**
     * Handles the cli command
     * 
     * @param string[] $argv Arguments with the script name
     * 
     * @return bool
     */
    public function handle(array $argv): bool
    {
        if (count($argv) < 3) {
            $this->_printHelp();
            return false;
        }

        try {
            switch ($argv[1]) {
            case 'create':
                $command = new CreateFleetCommand(intval($argv[2]));
                $handler = new CreateFleetHandler(
                    new FleetRepositoryDB($this->pdo)
                );
                $fleet = $handler->handle($command);
                
                echo "Fleet ID: " . $fleet->getId() . PHP_EOL;

                return true;
            case 'register-vehicle':
                $command = new RegisterVehicleCommand(intval($argv[2]), $argv[3]);
                $handler = new RegisterVehicleHandler(
                    new FleetRepositoryDB($this->pdo),
                    new VehicleRepositoryDB($this->pdo)
                );
                $handler->handle($command);

                echo "Done!" . PHP_EOL;

                return true;
            case 'localize-vehicle':
                $command = new ParkVehicleCommand(
                    intval($argv[2]),
                    $argv[3],
                    floatval($argv[4]),
                    floatval($argv[5]),
                    isset($argv[6]) ? floatval($argv[6]) : null
                );
                $handler = new ParkVehicleHandler(
                    new FleetRepositoryDB($this->pdo),
                    new VehicleRepositoryDB($this->pdo)
                );
                $handler->handle($command);

                echo "Done!" . PHP_EOL;

                return true;
            default:
                $this->_printHelp();
                return false;
            }
        } catch (Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
            return false;
        }
    }
}

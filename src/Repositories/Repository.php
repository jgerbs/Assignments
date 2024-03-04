<?php

namespace src\Repositories;

require_once __DIR__ . '/../../vendor/autoload.php'; // needed for Composer dependencies

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Repository
{
	protected PDO $pdo;
	private string $hostname;
	private string $username;
	private string $databaseName;
	private string $databasePassword;
	private string $charset;

    public function __construct()
    {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); // Adjust the path accordingly
        $dotenv->load();

        $this->hostname = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USER'];
        $this->databaseName = $_ENV['DB_NAME'];
        $this->databasePassword = $_ENV['DB_PASS'];
        $this->charset = 'utf8mb4';

        $dsn = "mysql:host=$this->hostname;dbname=$this->databaseName;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->databasePassword, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}


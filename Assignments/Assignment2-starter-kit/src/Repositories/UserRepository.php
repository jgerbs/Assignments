<?php

namespace src\Repositories;

use src\Models\User;

class UserRepository extends Repository
{
    
    public function getUserById(string $id): User|false {
        $sqlStatement = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $found = $sqlStatement->execute([$id]);
        if ($found) {
                return new User($sqlStatement->fetch());
        }
        return false;
    }

	/**
     * Check if a user is authenticated.
     *
     * @return User|null
     */
    public function getAuthenticatedUser(): User|null
    {
        $userId = $_SESSION['user_id'] ?? null;
    
        if ($userId === null) {
            return null;
        }
    
        $userRepository = new self();
    
        return $userRepository->getUserById($userId);
    }

    /**
     * @param string $email
     * @return User|false
     */
    public function getUserByEmail(string $email): User|false
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        $row = $stmt->fetch();

        return $row ? $this->mapToUser($row) : false;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $passwordDigest
     * @return User|false
     */
    public function saveUser(string $name, string $email, string $passwordDigest): User|false
    {
        $query = "INSERT INTO users (name, email, password_digest) VALUES (?, ?, ?)";
        $params = [$name, $email, $passwordDigest];

        try {
            $this->pdo->prepare($query)->execute($params);
            $userId = $this->pdo->lastInsertId();
            return $this->getUserById($userId);
        } catch (\PDOException $e) {
            // Log the error or handle it as appropriate for your application
            error_log("Save User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string|null $profilePicture
     * @return bool
     */
    public function updateUser(int $id, string $name, ?string $profilePicture = null): bool
    {
        $query = "UPDATE users SET name = ?, profile_picture = ? WHERE id = ?";
        $params = [$name, $profilePicture, $id];

        try {
            return $this->pdo->prepare($query)->execute($params);
        } catch (\PDOException $e) {
            // Log the error or handle it as appropriate for your application
            error_log("Update User Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user name by user ID.
     *
     * @param int $userId
     * @return string
     */
    public function getUserName(int $userId): string
    {
        $user = $this->getUserById($userId);
        return $user ? $user->name : 'Unknown Author';
    }

    /**
     * Map database row to User model.
     *
     * @param array $row
     * @return User
     */
    private function mapToUser(array $row): User
    {
        // Implement the logic to map the database row to a User model
        // Create a User instance and set its properties based on the database row
        $user = new User();
        $user->id = $row['id'];
		$user->name = $row['name'];
		$user->email = $row['email'];
		$user->password_digest = $row['password_digest'];

        return $user;
    }
}

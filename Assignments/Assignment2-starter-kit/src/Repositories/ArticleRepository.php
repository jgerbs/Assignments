<?php

namespace src\Repositories;

use src\Models\Article;
use src\Models\User;
use PDO;
use PDOException;

class ArticleRepository extends Repository
{
    /**
     * @return Article[]
     */
    public function getAllArticles(): array
    {
        try {
            $query = "SELECT * FROM articles";
            $stmt = $this->pdo->query($query);
    
            if (!$stmt) {
                throw new PDOException("Query failed");
            }
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
            $articles = [];
    
            while ($row = $stmt->fetch()) {
                $articles[] = $this->mapToArticle($row);
            }
    
            return $articles;
        } catch (PDOException $e) {
            error_log("Error in getAllArticles: " . $e->getMessage());
            return [];
        }
    }
    
	

    /**
     * @param string $title
     * @param string $url
     * @param int $authorId
     * @return Article|false
     */
    public function saveArticle(string $title, string $url, string $time, int $authorId): Article|false
    {
        $query = "INSERT INTO articles (title, url, created_at, updated_at, author_id) VALUES (?, ?, ?, NULL, ?)";
        $params = [$title, $url, $time, $authorId];

        try {
            $this->pdo->prepare($query)->execute($params);
            $articleId = $this->pdo->lastInsertId();
            return $this->getArticleById($articleId);
        } catch (\PDOException $e) {
            // Log the error or handle it as appropriate for your application
            error_log("Save Article Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param int $id
     * @return Article|false
     */
    public function getArticleById(int $id): Article|false
    {
        $query = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? $this->mapToArticle($row) : false;
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $url
     * @return bool
     */
    public function updateArticle(int $id, string $title, string $url): bool
    {
        $query = "UPDATE articles SET title = ?, url = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $params = [$title, $url, $id];

        var_dump($params); exit;
        try {
            return $this->pdo->prepare($query)->execute($params);
        } catch (\PDOException $e) {
            // Log the error or handle it as appropriate for your application
            error_log("Update Article Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteArticleById(int $id): bool
    {
        $query = "DELETE FROM articles WHERE id = ?";
        $params = [$id];

        try {
            return $this->pdo->prepare($query)->execute($params);
        } catch (\PDOException $e) {
            // Log the error or handle it as appropriate for your application
            error_log("Delete Article Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $articleId
     * @return User|false
     */
    public function getArticleAuthor(string $articleId): User|false
    {
        $query = "SELECT users.id, users.name, users.email, users.password_digest, users.profile_picture FROM users INNER JOIN articles a ON users.id = a.author_id WHERE a.id = ?;";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$articleId]);
        $row = $stmt->fetch();

        return $row ? $this->mapToUser($row) : false;
    }

    /**
     * Map database row to Article model.
     *
     * @param array $row
     * @return Article
     */
    private function mapToArticle(array $row): Article
    {
        // Implement the logic to map the database row to an Article model
        // Create an Article instance and set its properties based on the database row
        $article = new Article();
        $article->id = $row['id'];
        $article->title = $row['title'];
        $article->url = $row['url'];
        $article->author_id = $row['author_id'];

        $userRepository = new UserRepository();
        $author = $userRepository->getUserById($article->author_id);
        $article->author_name = $author ? $author->name : 'Unknown Author';

        return $article;
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
        $user->title = $row['title'];
        $user->url = $row['url'];
        $user->author_id = $row['author_id'];
        return $user;
    }
}

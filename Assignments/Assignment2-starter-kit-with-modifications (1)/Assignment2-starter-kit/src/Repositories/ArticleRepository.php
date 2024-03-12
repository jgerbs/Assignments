<?php

namespace src\Repositories;

use src\Models\Article;
use src\Models\User;
use PDO;
use PDOException;

class ArticleRepository extends Repository
{
    /**
     * Gets all the articles from the database
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
     * saves a new article into the database
     * @param string $title
     * @param string $url
     * @param int $authorId
     * @return Article|false
     */
    public function saveArticle(string $title, string $url, int $authorId): Article|false
    {
        $query = "INSERT INTO articles (title, url, created_at, updated_at, author_id) VALUES (?, ?, CURRENT_TIMESTAMP, NULL, ?)";
        $params = [$title, $url, $authorId];

        try {
            $this->pdo->prepare($query)->execute($params);
            $articleId = $this->pdo->lastInsertId();
            return $this->getArticleById($articleId);
        } catch (\PDOException $e) {
            // Log the error
            error_log("Save Article Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * retrieves article object from database using ID
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
     * updates the article with the correct ID in the database
     * @param int $id
     * @param string $title
     * @param string $url
     * @return bool
     */
    public function updateArticle(int $id, string $title, string $url): bool
    {
        $query = "UPDATE articles SET title = ?, url = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $params = [$title, $url, $id];

        try {
            return $this->pdo->prepare($query)->execute($params);
        } catch (\PDOException $e) {
            // Log the error
            error_log("Update Article Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes the article from the database with the matching ID
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
            // Log the error 
            error_log("Delete Article Error: " . $e->getMessage());
            return false;
        }
    }


    /**
     * Map database row to Article model.
     * @param array $row
     * @return Article
     */
    private function mapToArticle(array $row): Article
    {
        $article = new Article();
        $article->id = $row['id'];
        $article->title = $row['title'];
        $article->url = $row['url'];
        $article->author_id = $row['author_id'];
        $article->created_at = $row['created_at'];
        $article->updated_at = $row['updated_at'];

        $userRepository = new UserRepository();
        $author = $userRepository->getUserById($article->author_id);
        $article->author_name = $author ? $author->name : 'Unknown Author';

        return $article;
    }


}

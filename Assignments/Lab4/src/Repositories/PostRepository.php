<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/Post.php';

use src\Models\Post as Post;

class PostRepository extends Repository
{

	/**
	 * @return Post[]
	 */
	public function getAllPosts(): array
	{
		$sqlStatement = $this->pdo->query("SELECT * FROM posts;");
		$rows = $sqlStatement->fetchAll();

		$posts = [];
		foreach ($rows as $row) {
			$posts[] = new Post($row);
		}

		return $posts;
	}

	/**
	 * @param string $title
	 * @param string $body
	 * @return Post|false
	 *
	 * This is horrible! Let's exploit the vulnerability and drop the database.
	 *
	 * Do not do SQL injection attacks on software that you don't own.
	 */
	public function savePost(string $title, string $body): Post|false
	{
		$createdAt = date('Y-m-d H:i:s');
		$sqlStatement = $this->pdo->prepare("INSERT INTO posts (created_at, updated_at, body, title) VALUES (?, NULL, ?, ?);");
		$result = $sqlStatement->execute([$createdAt, $body, $title]);
	
		if ($result) {
			$id = $this->pdo->lastInsertId();
			$sqlStatement = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
			$sqlStatement->execute([$id]);
			return new Post($sqlStatement->fetch());
		}
	
		return false;
	}
	

	/**
	 * @param int $id
	 * @return Post|false Post object if it was found, false otherwise
	 */
	public function getPostById(int $id): Post|false
	{
		$sqlStatement = $this->pdo->prepare('SELECT * FROM posts WHERE id=?');
		$result = $sqlStatement->execute([$id]);
		if ($result) {
			$resultSet = $sqlStatement->fetch();
			return new Post($resultSet);
		}
		return false;
	}

	/**
	 * @param int $id
	 * @param string $title
	 * @param string $body
	 * @return bool true on success, false otherwise
	 */
	public function updatePost(int $id, string $title, string $body): bool
	{
		$updatedAt = date('Y-m-d H:i:s');
		$sqlStatement = $this->pdo->prepare("UPDATE posts SET title = ?, body = ?, updated_at = ? WHERE id = ?");
		$result = $sqlStatement->execute([$title, $body, $updatedAt, $id]);
	
		return $result;
	}
	

	/**
	 * @param int $id
	 * @return bool true on success, false otherwise
	 */
public function deletePostById(int $id): bool
{
    $sqlStatement = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
    $result = $sqlStatement->execute([$id]);

    return $result;
}

}

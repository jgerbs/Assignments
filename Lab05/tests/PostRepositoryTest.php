<?php

require_once __DIR__ . '/../src/Repositories/PostRepository.php';
require_once __DIR__ . '/../src/Models/Post.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use src\Models\Post;
use src\Repositories\PostRepository;
use Dotenv\Dotenv;

class PostRepositoryTest extends TestCase
{
	private PostRepository $postRepository;

	public function __construct(?string $name = null, array $data = [], $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}

	/**
	 * Runs before each test
	 */
	protected function setUp(): void
    {
        parent::setUp();

        // Load environment variables from .env file
		$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); 
        $dotenv->load();

        $this->postRepository = new PostRepository();

        // Use environment variables for database credentials
        $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'];
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        // Use test_schema.sql for setting up the test database
        $commands = file_get_contents(__DIR__ . '/../database/test_schema.sql', true);
        $pdo->exec($commands);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Use environment variables for database credentials
        $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'];
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        $commands = file_get_contents(__DIR__ . '/../database/test_schema.sql', true);
        $pdo->exec($commands);
    }

	public function testPostCreation()
	{
		$post = (new PostRepository)->savePost('test', 'body');
		$this->assertEquals('test', $post->title);
		$this->assertEquals('body', $post->body);
	}

	public function testGetAllPosts()
	{
		$posts = $this->postRepository->getAllPosts();
	
		// Check if the result is an array
		$this->assertIsArray($posts);
		// Check if each item in the array is an instance of the Post class
		foreach ($posts as $post) {
			$this->assertInstanceOf(Post::class, $post);
		}
	}	

	public function testGetPostById()
	{
		// Assuming there is an existing post with ID 1 in the database
		$postId = 2;
		$post = $this->postRepository->getPostById($postId);
	
		// Check if the result is an instance of the Post class
		$this->assertInstanceOf(Post::class, $post);
	
		// Ensure the post has the expected ID
		$this->assertEquals($postId, $post->id);
	}
	

	public function testSavePost()
	{
		// Assuming the savePost method creates a new post in the database
		$title = 'New Post';
		$body = 'This is a new post.';
	
		$newPost = $this->postRepository->savePost($title, $body);
	
		// Check if the returned post has the correct title and body
		$this->assertInstanceOf(Post::class, $newPost);
		$this->assertEquals($title, $newPost->title);
		$this->assertEquals($body, $newPost->body);
	}
	

    public function testUpdatePost()
    {
        // Assuming there is an existing post with ID 1 in the database
        $postId = 2;
        $newTitle = 'Updated Title';
        $newBody = 'This is the updated body.';

        $updateSuccess = $this->postRepository->updatePost($postId, $newTitle, $newBody);

        // Check if the update was successful
        $this->assertTrue($updateSuccess);

        // Check if the post has been updated
        $updatedPost = $this->postRepository->getPostById($postId);
        $this->assertEquals($newTitle, $updatedPost->title);
        $this->assertEquals($newBody, $updatedPost->body);
    }

    public function testDeletePostById()
    {
        // Assuming there is an existing post with ID 1 in the database
        $postId = 3;

        $deleteSuccess = $this->postRepository->deletePostById($postId);

        // Check if the deletion was successful
        $this->assertTrue($deleteSuccess);

        // Check if the post has been deleted
        $deletedPost = $this->postRepository->getPostById($postId);
        $this->assertFalse($deletedPost); // Assuming getPostById returns false for non-existent posts
    }
}

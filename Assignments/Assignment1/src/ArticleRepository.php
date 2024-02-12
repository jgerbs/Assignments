<?php
require_once 'src/Models/Article.php';
class ArticleRepository
{

	private string $filename;

	public function __construct(string $theFilename)
	{
		$this->filename = $theFilename;
	}

	/**
	 * @return Article[]
	 */
	public function getAllArticles(): array
	{
		if (!file_exists($this->filename)) {
			return [];
		}
		$fileContents = file_get_contents($this->filename);
		if (!$fileContents) {
			return [];
		}
		$decodedArticles = json_decode($fileContents, true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			return [];
		}
		$articles = [];
		foreach ($decodedArticles as $decodedArticle) {
			$articleId = time();
			$articles[] = (new Article($articleId))->fill($decodedArticle);
		}
		return $articles;
	}

	    /**
     * @param int $id
     * @return Article|null
     */
    public function getArticleById(int $id): ?Article
    {
        $articles = $this->getAllArticles();

        foreach ($articles as $article) {
            if ($article->getId() === $id) {
                return $article;
            }
        }

        return null;
    }

    /**
     * @param int $id
     */
    public function deleteArticleById(int $id): void
    {
        $articles = $this->getAllArticles();

        foreach ($articles as $key => $article) {
            if ($article->getId() === $id) {
                unset($articles[$key]);
                file_put_contents($this->filename, json_encode(array_values($articles), JSON_PRETTY_PRINT));
                return;
            }
        }
    }

    /**
     * @param Article $article
     */
    public function saveArticle(Article $article): void {
		$articles = $this->getAllArticles();
		$articles[] = $article;
		file_put_contents($this->filename, json_encode($articles, JSON_PRETTY_PRINT));
	}

    /**
     * @param int $id
     * @param Article $updatedArticle
     */
    public function updateArticle(int $id, string $updatedTitle, string $updatedUrl): void
    {
        $articles = $this->getAllArticles();
    
        foreach ($articles as $key => $article) {
            if ($article->getId() === $id) {
                // Update the article with new title and URL
                $articles[$key]->setTitle($updatedTitle);
                $articles[$key]->setUrl($updatedUrl);
                $this->deleteArticleById($id);
                $this->saveArticle($article);
                return;
            }
        }
    }

}
<?php

namespace src\Controllers;

use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository; 
use core\Request;
use PDOException;


class ArticleController extends Controller
{
    /**
     * Display the page showing the articles.
     * @return void
     */
    public function renderIndexPage(): void
    {
        $articleRepository = new ArticleRepository();
        $userRepository = new UserRepository();
        $articles = $articleRepository->getAllArticles();

        foreach ($articles as $article) {
            $user = $userRepository->getUserById($article->author_id);
            $article->author_name = $user ? $user->name : 'Unknown Author';
        }

        $this->render('index', ['articles' => $articles]);
    }

    /**
     * Display the about page.
     * @return void
     */
    public function about(): void
    {
        $this->render('about');
    }

    /**
     * Show the form for creating a new article.
     * @return void
     */
    public function create(): void
    {
        $this->render('new_article');
    }

        /**
     * Process the storing of a new article.
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $title = $request->input('title');
        $url = $request->input('url');
        $id = $_SESSION['user_id'];


        try {
            $articleRepository = new ArticleRepository();
            $result = $articleRepository->saveArticle($title, $url, $id);

                header('Location: /');
                exit(); 
            } catch (PDOException $e) {
                $this->render('register', ['error' => $e->getMessage()]);
            }
    }


/**
 * Process the editing of an article.
 * @param Request $request
 * @return void
 */
public function update(Request $request): void
{

    $articleId = (int) $request->input('id');
    $title = $request->input('title');
    $url = $request->input('url');

    try {
        $articleRepository = new ArticleRepository();
        $result = $articleRepository->updateArticle($articleId, $title, $url);

                header('Location: /');
    } catch (PDOException $e) {
        $this->render('register', ['error' => $e->getMessage()]);
    }
}


    /**
     * Process the deleting of an article.
     * @param Request $request
     * @return void
     */
    public function delete(Request $request): void
    {
        $articleId = $request->input('id');

        $articleRepository = new ArticleRepository();
        $result = $articleRepository->deleteArticleById($articleId);

        if ($result) {
            $this->redirect('/');
        } else {
            $this->render('error', ['message' => 'Failed to delete article']);
        }
    }

    /**
     * Show the form for editing an article.
     * @param Request $request
     * @return void
     */
    public function edit(Request $request): void
    {
        $articleRepository = new ArticleRepository();
        $articleId = (int)$request->input('id');
        $article = $articleRepository->getArticleById($articleId);
    
        if ($article) {
            $this->render('update_article', ['article' => $article]);
        } else {
            $this->render('error', ['message' => 'Article not found']);
        }
    }
    }



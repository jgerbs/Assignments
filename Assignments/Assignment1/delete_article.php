<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $articleId = $_GET['id'];

    if (!empty($articleId)) {
        $articleRepository = new ArticleRepository('articles.json');
        $articleRepository->deleteArticleById($articleId);
       
        header('Location: index.php');
        exit();
    }

    header('Location: index.php');
    exit();
}
?>

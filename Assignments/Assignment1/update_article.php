<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

$articleRepository = new ArticleRepository('articles.json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $articleId = $_GET['id'];
    $existingArticle = $articleRepository->getArticleById($articleId);

    if ($existingArticle) {
        $articleTitle = $existingArticle->getTitle();
        $articleUrl = $existingArticle->getUrl();
    } else {
        header('Location: index.php');
        exit();
    }
}
// Check if the form has been submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = $_POST['article_id'] ?? '';
    $updatedTitle = $_POST['title'] ?? $articleTitle;
    $updatedUrl = $_POST['url'] ?? $articleId;


    $articleRepository->updateArticle($articleId, $updatedTitle, $updatedUrl);

    // Redirect back to index.php
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
        <head>
        <?php require_once 'layout/header.php'; ?>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f2f2f2;
                margin: 0;
                padding: 0;
            }

            #navbar {
                background-color: #333;
                overflow: hidden;
            }

            #navbar a {
                float: left;
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            #navbar a:hover {
                background-color: #ddd;
                color: black;
            }

            #page-content {
                margin: 20px auto;
                max-width: 800px;
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .new-article-form {
                margin: 20px auto;
                max-width: 400px;
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .new-article-form h2 {
                color: #333;
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            .new-article-form label {
                color: #666;
                margin: 0;
            }

            .new-article-form input,
            .new-article-form button {
                margin-top: 10px;
            }

            .new-article-form .action-button {
                padding: 8px;
                border: none;
                cursor: pointer;
                border-radius: 4px;
                margin-top: 10px;
            }

            .new-article-form .action-button.edit {
                background-color: #4caf50;
                color: white;
            }
        </style>
    </head>
        <body>
            <div id="navbar">
                <a href="index.php">COMP 3015 News</a>
                <a href="new_article.php">New Article</a>
            </div>

            <div id="page-content" class="mx-auto">
                <h2 id="page-title" class="text-xl text-center font-semibold text-indigo-700 mb-6">Edit Article</h2>
                <form action="update_article.php" method="post" class="new-article-form">
                    <input type="hidden" name="article_id" value="<?= $existingArticle->getId(); ?>">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 p-2 border rounded-md w-full" value="<?= $existingArticle->getTitle(); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                        <input type="url" name="url" id="url" class="mt-1 p-2 border rounded-md w-full" value="<?= $existingArticle->getUrl(); ?>" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-indigo-700 text-white rounded-md hover:bg-indigo-600 action-button edit">Update Article</button>
                    </div>
                </form>
            </div>
        </body>
        </html>
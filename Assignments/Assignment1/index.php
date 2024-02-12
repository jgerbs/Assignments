<?php
require_once 'src/ArticleRepository.php';

$articleRepository = new ArticleRepository('articles.json');
$articles = $articleRepository->getAllArticles();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'layout/header.php' ?>
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

        .article-card {
            position: relative;
            margin-bottom: 20px;
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }

        .article-card h3 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .article-actions {
            position: absolute;
            bottom: 0;
            right: 0;
            margin: 15px; 
            padding: 10px;
        }
        .action-button {
            padding: 8px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        .action-button.edit {
            background-color: #4caf50;
            color: white;
        }

        .action-button.delete {
            background-color: #ff0000;
            color: white;
        }

        .article-card p {
            color: #666;
            margin: 0;
        }
    </style>
</head>

<body>

    <div id="navbar">
        <a href="index.php">COMP 3015 News</a>
        <a href="new_article.php">New Article</a>
    </div>

    <div id="page-content" class="mx-auto">
        <h2 id="page-title" class="text-xl text-center font-semibold text-indigo-700 mb-6">Articles</h2>

        <div class="flex flex-wrap justify-center">

            <?php foreach ($articles as $article) : ?>
                <div class="article-card">
                    <h3 class="text-lg font-semibold text-indigo-700"><?= $article->getTitle(); ?></h3>
                    <p><a href="<?= $article->getUrl(); ?>" target="_blank"><?= $article->getUrl(); ?></a></p>
                    <div class="article-actions">
                        <a href="update_article.php?id=<?= $article->getId(); ?>" class="action-button edit">Edit</a>
                        <a href="delete_article.php?id=<?= $article->getId(); ?>" class="action-button delete">Delete</a>
                    </div>                
            </div>

            <?php endforeach; ?>

        </div>
    </div>

</body>

</html>


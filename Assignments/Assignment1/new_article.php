<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if title and url are set
    if (isset($_POST['title'], $_POST['url'])) {
		$id = time();
        $title = $_POST['title'];
        $url = $_POST['url'];

        // Check if title and url are not empty
        if (!empty($title) && !empty($url)) {
            $articleRepository = new ArticleRepository('articles.json');
            $newArticle = new Article($id, $title, $url);
            $articleRepository->saveArticle($newArticle);
        }
    }
    
    header('Location: index.php');
    exit();
}
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

        .article-card,
        .new-article-form {
            margin-bottom: 20px;
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }

        .article-card h3,
        .new-article-form h2 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .article-card p,
        .new-article-form label {
            color: #666;
            margin: 0;
        }

        .new-article-form input,
        .new-article-form button {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div id="navbar">
		<a href="index.php">COMP 3015 News</a>
        <a href="new_article.php">New Article</a>
    </div>

    <div id="page-content" class="mx-auto">
        <h2 id="page-title" class="text-xl text-center font-semibold text-indigo-700 mb-6">New Article</h2>

        <div class="flex min-h-full items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-xl space-y-8 new-article-form">
                <form action="new_article.php" method="post">
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 p-2 border rounded-md w-full" required>
                    </div>
                    <div class="mb-4">
                        <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                        <input type="url" name="url" id="url" class="mt-1 p-2 border rounded-md w-full" required>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-indigo-700 text-white rounded-md hover:bg-indigo-600">Submit Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>


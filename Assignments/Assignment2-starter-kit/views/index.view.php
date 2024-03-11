<?php
require_once 'header.php'
?>
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

<body>

    <?php require_once 'nav.php' ?>


    <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

        <h1 class="text-xl text-center font-semibold text-indigo-500 mt-10 mb-10 title">Articles</h1>

        <h6 class="text-center"><?= count($articles) === 0 ? "No articles yet :(" : ""; ?></span>

            <div class="sm:rounded-md">
                <ul role="list" class="mb-20">
                <div class="flex flex-wrap justify-center">
                    <?php foreach ($articles as $article) : ?>
                        <div class="article-card">
                            <h3 class="text-lg font-semibold text-indigo-700"><?= $article->title; ?></h3>
                            <p><a href="<?= $article->url; ?>" target="_blank"><?= $article->url; ?></a></p>
                            <p class="text-gray-600 mb-4">Author ID: <?= $article->author_id; ?></p>
                            <p class="text-gray-600 mb-4">Article ID: <?= $article->id; ?></p>
                            <p class="text-gray-600 mb-4">Created At: <?= $article->createdAtFmt() ?></p>
                            <p class="text-gray-600 mb-4">Updated At: <?= $article->updated_at ? $article->updated_at->format('Y-m-d H:i:s') : 'Not updated'; ?></p>

                            <div class="article-actions">
                                <?php
                                $userId = $_SESSION['user_id'];
                                if ($article->author_id === $userId) : ?>
                                    <a href="/articles/edit?id=<?= $article->id; ?>" class="action-button edit">Edit</a>
                                    <a href="/articles/delete?id=<?= $article->id; ?>" class="action-button delete">Delete</a>
                                <?php endif; ?>    
                            </div>  
                            <br>
                            <br>
                        </div>                    
                    <?php endforeach; ?>
                </div>

                </ul>
                
            </div>

    </div>

</body>
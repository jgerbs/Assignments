<?php
require_once 'header.php';
use src\Repositories\UserRepository;
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
        max-width: 95%;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .article-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .article-card {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: space-between;
        margin: 10px;
        padding: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        width: 97%;
    }



    .article-actions {
        margin-top: 10px;
    }

    .action-button {
        padding: 8px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        margin-right: 10px;
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
    #link {
        font-weight: bold;
        color: blue;
    }
</style>


<body>

    <?php require_once 'nav.php' ?>


    <div class="mx-auto max-w-4xl sm:px-6 lg:px-8" id="page-content">

        <h1 class="text-xl text-center font-semibold text-indigo-500 mt-10 mb-10 title" id="page-title">Articles</h1>

        <h6 class="text-center"><?= count($articles) === 0 ? "No articles yet :(" : ""; ?></span>

            <div class="flex flex-wrap justify-center">
                <ul role="list" class="article-card">
                    <?php foreach ($articles as $article) : ?>
                        <div class="article-card">

                            <p><a href="<?= $article->url; ?>" target="_blank" id= "link"><?= $article->title; ?></a></p>
                            <?php           
                                $userRepository = new UserRepository();
                                $user = $userRepository->getUserById($article->author_id);
                            ?>                            
                            <p class="text-gray-600 mb-4">Created On <?= $article->createdAtFmt(); ?></p>

                            <?php if ($article->updated_at) : ?>
                                <p class="text-gray-600 mb-4">Updated On <?= $article->updatedAtFmt(); ?></p>
                            <?php endif; ?>
                            <div class="flex items-center">
                            <br>
                            <br>
                                <img src="<?= htmlspecialchars($user->profile_picture, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Photo" class="w-8 h-8 object-cover rounded-full">
                                <p class="text-gray-600 mb-4">&nbsp;Posted By <?= $user->name; ?></p>
                            </div>


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
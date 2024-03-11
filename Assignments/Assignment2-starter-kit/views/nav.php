<?php
use src\Repositories\UserRepository;

// Create an instance of UserRepository
$userRepository = new UserRepository();

// Check if there is an authenticated user
$authenticatedUser = $userRepository->getAuthenticatedUser();

?>

<div class="navbar bg-indigo-500 text-primary-content">
    <div class="flex-1">
        <a class="btn btn-ghost normal-case text-xl" href="/">COMP 3015 News</a>
    </div>
    <li class="flex-none">
        <ul class="menu menu-horizontal px-1">
        <?php $authorId = $_SESSION['user_id'] ?? null; ?>
            <?php if ($authenticatedUser): ?>
                <!-- Show the new article and logout buttons if the user is authenticated -->
                <li><a href="/settings?id=<?= $authorId; ?>" class="btn btn-ghost">Welcome</a></li>
                <li><a href="/articles/create" class="btn btn-ghost">New Article</a></li>
                <form action="/logout" method="POST">
                    <button type="submit" class="btn btn-ghost">Logout</button>
                </form>
            <?php else: ?>
                <!-- Show the login and registration buttons for guest users -->
                <li><a href="/login" class="btn btn-ghost">Login</a></li>
                <li><a href="/register" class="btn btn-ghost">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

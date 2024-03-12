<?php
use src\Repositories\UserRepository;

$userRepository = new UserRepository();
$authenticatedUser = $userRepository->getAuthenticatedUser();

?>
 <?php $authorId = $_SESSION['user_id'] ?? null; ?>

<div class="navbar bg-indigo-500 text-primary-content">
    <div class="flex-1">
        <a class="btn btn-ghost normal-case text-xl" href="/">COMP 3015 News</a>
        <?php if ($authenticatedUser): ?>
            <li><a href="/articles/create" class="btn btn-ghost">New Article</a></li>
        <?php endif; ?>

    </div>
    <li class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <?php if ($authenticatedUser): ?>
                <a href="/settings?id=<?= $authorId; ?>" class="btn btn-ghost"><img src="<?= htmlspecialchars($authenticatedUser->profile_picture, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Photo" class="w-8 h-8 object-cover rounded-full"></a></li>
                <li><a href="/settings?id=<?= $authorId; ?>" class="btn btn-ghost">Welcome, <?= $authenticatedUser->name;?> </a></li>
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

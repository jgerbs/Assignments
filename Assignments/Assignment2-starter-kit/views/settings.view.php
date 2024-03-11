<?php require_once 'header.php'; ?>

<body>

    <?php require_once 'nav.php'; ?>

    <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 mt-10">
        <form class="space-y-8" action="/settings/update" method="post" enctype="multipart/form-data">
            <!-- Display user information for modification -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email ?? '', ENT_QUOTES, 'UTF-8'); ?>" disabled class="input input-bordered w-full max-w-xs">
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->name ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="input input-bordered w-full max-w-xs">
            </div>

            <div>
                <label for="profilePhoto" class="block text-sm font-medium text-gray-700">Profile Photo</label>
                <input type="file" id="profilePhoto" name="profilePhoto" accept="image/*" class="input input-bordered w-full max-w-xs">
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
            </div>

        </form>
    </div>

</body>


<?php require_once 'header.php'; ?>

<body>

    <?php require_once 'nav.php'; ?>

    <div class="grid grid-cols-12 mt-20">

        <form class="space-y-6 col-start-4 col-span-6" action="/articles/store" method="POST">
            <div>
                <label for="title" class="text-gray-600">Title</label>
                <input type="text" id="title" name="title" class="input input-bordered" required>
            </div>

            <div>
                <label for="url" class="text-gray-600">URL</label>
                <input type="text" id="url" name="url" class="input input-bordered" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">Create Article</button>
            </div>
        </form>

    </div>

</body>

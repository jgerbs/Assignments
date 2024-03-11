<?php require_once 'header.php'; ?>

<body>

	<?php require_once 'nav.php'; ?>

    <div class="grid grid-cols-12 mt-20">

		<form action="/articles/update" method="post">

			<input type="hidden" name="article_id" value="<?= htmlspecialchars($article->id ?? '', ENT_QUOTES, 'UTF-8'); ?>">
			<div>
				<label for="title" class="block text-sm font-medium text-gray-700">Title</label>
				<div class="mt-1">
					<input type="text" name="title" id="title" class="input input-bordered" value="<?= htmlspecialchars($article->title ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
				</div>
			</div>
			<div>
				<label for="url" class="block text-sm font-medium text-gray-700">URL</label>
				<div class="mt-1">
					<input type="text" name="url" id="url" class="input input-bordered" value="<?= htmlspecialchars($article->url ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
				</div>
			</div>
			<div class="flex justify-end">
				<button type="submit" class="btn btn-primary">Update Article</button>
			</div>
		</form>


	</div>

</body>

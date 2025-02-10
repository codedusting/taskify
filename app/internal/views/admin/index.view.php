<?php require(basePath("internal/views/components/meta.view.php")); ?>
<main class="flex-1 bg-gray-50 flex items-start justify-start gap-4">
    <?php require(basePath("internal/views/admin/components/sidebar.view.php")); ?>
    <section class="w-4/5 p-4 flex flex-col gap-4">
        <h1 class="text-2xl font-bold"><?= $heading ?></h1>
        <section class="container mt-4 mx-auto flex flex-col items-start justify-start gap-2">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded">
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php else: ?>
                <?php if (empty($tasks)): ?>
                    <p>No Tasks</p>
                <?php endif; ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="flex flex-col sm:flex-row items-center justify-between w-full border border-solid border-[#ddd] p-2 rounded">
                        <div class="flex items-center justify-start gap-4 w-full mb-4 sm:mb-0 mr-4">
                            <img src="<?= $task["thumbnailUrl"] ?>" alt="<?= $task["title"] ?> Thumbnail" width="64"
                                 height="64" class="border border-solid border-gray-900 rounded object-cover">
                            <div class="flex flex-col items-start justify-start gap-1">
                                <p class="text-base font-bold"><?= $task["count"] ?>. <?= $task["title"] ?></p>
                                <p class="text-gray-600 text-sm"><?= $task["description"] ?></p>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center justify-end">
                            <form action="/admin/task/delete">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="bg-red-700 text-white p-2 rounded">Delete</button>
                            </form>
                            <a href="/admin/task/edit" class="bg-gray-900 text-white p-2 rounded">Edit</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </section>

</main>

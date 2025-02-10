<?php require(basePath("internal/views/components/meta.view.php")); ?>
<main class="flex-1 bg-gray-50 flex items-start justify-start gap-4">
    <?php require(basePath("internal/views/admin/components/sidebar.view.php")); ?>
    <section class="w-4/5 p-4 flex flex-col gap-8">
        <h1 class="text-2xl font-bold"><?= $heading ?></h1>
        <form action="/admin/task" method="post" enctype="multipart/form-data"
              class="flex flex-col gap-4 max-w-screen-sm w-1/2">
            <div class="flex flex-col gap-2">
                <label for="title" class="font-semibold">Title <span class="text-red-700">*</span></label>
                <input type="text" name="title" id="title" class="rounded" placeholder="Enter task title"
                       value="<?= $data["title"] ?? null ?>">
                <span class="text-sm text-red-700"><?= $errors["title"] ?? "" ?></span>
            </div>
            <div class="flex flex-col gap-2">
                <label for="description" class="font-semibold">Description <span class="text-red-700">*</span></label>
                <input type="text" name="description" id="description" class="rounded"
                       placeholder="Enter task description"
                       value="<?= $data["description"] ?? null ?>">
                <span class="text-sm text-red-700"><?= $errors["description"] ?? "" ?></span>
            </div>
            <div class="flex flex-col gap-2">
                <label for="thumbnail" class="font-semibold">Thumbnail <span class="text-red-700">*</span></label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="rounded"
                       placeholder="Upload task thumbnail"
                       value="<?= $data["thumbnail"] ?? null ?>">
                <span class="text-sm text-red-700"><?= $errors["thumbnail"] ?? "" ?></span>
            </div>
            <div class="flex gap-2">
                <button type="reset" class="bg-red-900 text-white p-3 mt-6 rounded mt-6">Cancel</button>
                <button type="submit" class="bg-gray-900 text-white p-3 mt-6 rounded mt-6">Submit</button>
                <?php if (!empty($errors) && !empty($errors["error"])): ?>
                    <span class="text-sm bg-red-100 rounded text-red-700 mt-6 p-3 capitalize"><?= htmlspecialchars($errors["error"]) ?></span>
                <?php endif; ?>
            </div>
        </form>
    </section>
</main>

<?php require(basePath("internal/views/components/meta.view.php")); ?>
<?php require(basePath("internal/views/components/header.view.php")); ?>
<main class="flex-1 bg-gray-50">
    <section class="px-4 bg-white text-black border-b border-solid border-b-gray-200 py-4">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold"><?= $heading ?></h1>
        </div>
    </section>
    <section class="container mt-4 px-4 mx-auto px-4 flex flex-col items-start justify-start gap-2">
        <?php if (isset($errorMessage)): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded">
                <p><?= htmlspecialchars($errorMessage) ?></p>
            </div>
        <?php else: ?>
            <?php if (empty($tasks)): ?>
                <p>No Tasks</p>
            <?php endif; ?>
            <?php foreach ($tasks as $task): ?>
                <div class="flex flex-col sm:flex-row items-center justify-between w-full border border-solid border-[#ddd] p-4 rounded">
                    <div class="flex items-center justify-start gap-4 w-full mb-4 sm:mb-0 mr-4">
                        <img src="<?= $task["thumbnailUrl"] ?>" alt="<?= $task["title"] ?> Thumbnail" width="64"
                             height="64" class="border border-solid border-gray-900 rounded object-cover">
                        <div class="flex flex-col items-start justify-start gap-1 w-full">
                            <p class="text-base font-bold"><?= $task["count"] ?>. <?= $task["title"] ?></p>
                            <p class="text-gray-600 text-sm"><?= $task["description"] ?></p>
                        </div>
                    </div>
                    <div class="flex justify-end items-start w-fit sm:items-center gap-4">
                        <form action="/task/upvote" method="post">
                            <button type="submit"
                                    class="flex items-center justify-center gap-1 bg-green-700 text-white rounded-full p-2  min-w-[72px]">
                                <span class="sr-only">Upvote</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="size-6">
                                    <path d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z"/>
                                </svg>
                                <span><?= $task["upvote"] ?></span>
                            </button>
                        </form>
                        <form action="/task/downvote" method="post">
                            <button type="submit"
                                    class="flex items-center justify-center gap-1 bg-red-700 text-white rounded-full p-2 min-w-[72px]">
                                <span class="sr-only">Down vote</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="size-6">
                                    <path d="M15.73 5.5h1.035A7.465 7.465 0 0 1 18 9.625a7.465 7.465 0 0 1-1.235 4.125h-.148c-.806 0-1.534.446-2.031 1.08a9.04 9.04 0 0 1-2.861 2.4c-.723.384-1.35.956-1.653 1.715a4.499 4.499 0 0 0-.322 1.672v.633A.75.75 0 0 1 9 22a2.25 2.25 0 0 1-2.25-2.25c0-1.152.26-2.243.723-3.218.266-.558-.107-1.282-.725-1.282H3.622c-1.026 0-1.945-.694-2.054-1.715A12.137 12.137 0 0 1 1.5 12.25c0-2.848.992-5.464 2.649-7.521C4.537 4.247 5.136 4 5.754 4H9.77a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23ZM21.669 14.023c.536-1.362.831-2.845.831-4.398 0-1.22-.182-2.398-.52-3.507-.26-.85-1.084-1.368-1.973-1.368H19.1c-.445 0-.72.498-.523.898.591 1.2.924 2.55.924 3.977a8.958 8.958 0 0 1-1.302 4.666c-.245.403.028.959.5.959h1.053c.832 0 1.612-.453 1.918-1.227Z"/>
                                </svg>
                                <span><?= $task["downvote"] ?></span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>
<?php require(basePath("internal/views/components/footer.view.php")); ?>

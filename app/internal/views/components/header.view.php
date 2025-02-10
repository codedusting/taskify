<?php
require basePath("libs/imagekit.php");
$logo = $imagekit->url([
    "path" => "/php-notes-app/notes.png",
    "transformation" => [
        [
            "height" => 128,
            "width" => 128
        ]
    ]
]);
$_SESSION["user"]["name"] = "Code Dusting";
?>
<header class="py-4 bg-gray-900 text-white border-b border-solid border-b-gray-700">
    <div class="container px-4 flex items-center justify-between mx-auto">
        <div class="flex items-center justify-start">
            <div class="flex gap-1 items-center justify-start">
                <img src="<?= $logo ?>" alt="Site Logo" class="text-transparent w-8 h-8">
                <a href="/" class="font-bold text-xl">Taskify</a>
            </div>
        </div>
        <ul class="flex items-center justify-end gap-2">
            <?php if (($_SESSION["user"] ?? false)): ?>
                <li>
                    <a href="/account"
                       class="border border-solid rounded border-white bg-gray-900 px-4 py-3 hover:bg-gray-950">
                        <?= $_SESSION["user"]["name"] ?>
                    </a>
                </li>
                <li>
                    <form action="/logout" method="post" class="m-0">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit"
                                class="border border-solid flex items-center rounded border-white bg-gray-900 px-4 py-3 hover:bg-gray-950">
                            Logout
                        </button>
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</header>

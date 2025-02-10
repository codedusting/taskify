<?php

use Core\Validator;

?>
<aside class="w-1/5 bg-gray-900 h-full text-white flex flex-col justify-between">
    <nav class="w-full">
        <ul class="w-full">
            <li class="w-full">
                <a href="/admin"
                   class="<?= Validator::urlIs("/admin") ? "bg-gray-950 text-white" : "text-white/60" ?> inline-block w-full p-4">Show
                    Task</a>
            </li>
            <li>
                <a href="/admin/task/create"
                   class="<?= Validator::urlIs("/admin/task/create") ? "bg-gray-950 text-white" : "text-white/60" ?> inline-block w-full p-4">Create
                    Task</a>
            </li>
        </ul>
    </nav>
    <form action="" method="post" class="p-4">
        <button type="submit"
                class="p-3 rounded bg-white text-black w-full border border-solid border-black hover:bg-gray-900 hover:text-white hover:border-white">
            Logout
        </button>
    </form>
</aside>
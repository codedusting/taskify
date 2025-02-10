<?php

use Core\App;
use Core\Database;
use Internal\Forms\TaskForm;

try {
    $form = new TaskForm(App::resolve(Database::class));
    $form->fetchAllTasks($_SESSION["user"]["id"]);

    view("index.view.php", [
        "heading" => "Tasks",
        "tasks" => $form->tasks,
        "error" => null
    ]);
} catch (Exception $e) {
    error_log("Error instantiating Task Form: ".$e->getMessage());
    view("index.view.php", [
        "heading" => "Tasks",
        "tasks" => [],
        "error" => $e->getMessage()
    ]);
}
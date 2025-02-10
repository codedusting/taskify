<?php

$data = $_SESSION["_persist"]["data"] ?? [];
$errors = $_SESSION["_flash"]["errors"] ?? [];

unsetPartialSessions();

view("admin/task/create.view.php", [
    "heading" => "Create Task",
    "errors" => $errors,
    "data" => $data
]);
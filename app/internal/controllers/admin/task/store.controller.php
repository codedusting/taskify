<?php

use Core\App;
use Core\Database;
use Internal\Forms\TaskForm;

$title = htmlspecialchars(trim($_POST["title"]));
$description = htmlspecialchars(trim($_POST["description"]));

/*
 * 1. validate the user is admin
 * 2. validate the incoming variables
 * 3. validate the incoming file
 * 4. if 1, 2, 3 => insert the data
 * 5. if 4 => redirect to the admin
 * 6. if not 4 => error
 * 7. if not 3 => error
 * 8. if not 2 => error
 * 9. if not 1 => error
 * 10. if errors => show errors in create view
 */

try {
    $form = new TaskForm(App::resolve(Database::class));

    $_SESSION["user"]["id"] = 1;
    if ($form->validateUser()) {
        $userId = $_SESSION["user"]["id"];
        if ($form->validateFormTaskEntries($title, $description)) {
            if ($form->validateFormFiles("thumbnail")) {
                if ($form->uploadFile()) {
                    if ($form->insertTaskEntries()) {
                        redirect("/admin");
                    }
                }
                goto errors;
            }
            goto errors;
        }
        goto errors;
    }

    errors:
    $_SESSION["_persist"]["data"] = [
        "title" => $title,
        "description" => $description
    ];
    $_SESSION["_flash"]["errors"] = $form->getTaskErrors();

    redirect("/admin/task/create");
} catch (Exception $e) {
    error_log("Error instantiating Task Form: ".$e->getMessage());

    $_SESSION["_persist"]["data"] = [
        "title" => $title,
        "description" => $description
    ];
    $_SESSION["_flash"]["errors"] = [
        "error" => $e->getMessage()
    ];
    redirect("/admin/task/create");
}
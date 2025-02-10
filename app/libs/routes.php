<?php

global $router;

// Public Route
$router->get("/", "index.controller.php");

// Protected routes: Only Admin can visit these routes
$router->get("/admin", "admin/index.controller.php"); // get all tasks
$router->get("/admin/task/create", "admin/task/create.controller.php"); // show the create task form
$router->post("/admin/task", "admin/task/store.controller.php"); // add new task
// show single task

// delete a task
// update a task
// show edit form
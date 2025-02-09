<?php

view("index.php", [
    "heading" => "Tasks",
    "tasks" => [
        [
            "id" => 1,
            "title" => "Title 1",
            "description" => "Lorem Ispum Ergo Sum what is it even to begin with?",
            "upvote" => 10,
            "downvote" => 20
        ],
        [
            "id" => 2,
            "title" => "Title 2",
            "description" => "Lorem Ispum Ergo Sum what is it even to begin with?",
            "upvote" => 20,
            "downvote" => 10
        ],
        [
            "id" => 3,
            "title" => "Title 3",
            "description" => "Lorem Ispum Ergo Sum what is it even to begin with?",
            "upvote" => 13,
            "downvote" => 0
        ]
    ]
]);
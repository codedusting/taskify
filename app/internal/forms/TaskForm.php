<?php

namespace Internal\Forms;

use Core\Database;
use Core\FileUploader;
use Core\Validator;

class TaskForm
{
    public array $tasks = [] {
        get {
            return $this->tasks;
        }
    }
    protected Database $db;
    protected array $errors = [];
    protected array $file = [];
    protected array $fileErrors = [
        "UPLOAD_ERR_OK" => "There is no error, the file uploaded with success",
        "UPLOAD_ERR_INI_SIZE" => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        "UPLOAD_ERR_FORM_SIZE" => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
        "UPLOAD_ERR_PARTIAL" => "The uploaded file was only partially uploaded.",
        "UPLOAD_ERR_NO_FILE" => "No file was uploaded.",
        "UPLOAD_ERR_NO_TMP_DIR" => "Missing a temporary folder.",
        "UPLOAD_ERR_CANT_WRITE" => "Cannot write to target directory. Please fix CHMOD.",
        "UPLOAD_ERR_EXTENSION" => "A PHP extension stopped the file upload."
    ];
    protected mixed $title = null;
    protected mixed $description = null;
    protected mixed $thumbnailUrl = null;
    protected mixed $thumbnailPath = null;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function validateUser(): bool
    {
        return Validator::array($_SESSION) && Validator::array($_SESSION["user"]) && Validator::string($_SESSION["user"]["id"],
                1, 1);
    }

    public function getTaskErrors(): array
    {
        return $this->errors;
    }

    public function validateFormTaskEntries(string $title, string $description): bool
    {
        if (!Validator::string($title, 1, 255)) {
            $this->errors["title"] = "Title is missing!";
        }
        if (!Validator::string($description, 1, 255)) {
            $this->errors["description"] = "Description is missing!";
        }
        if (empty($this->errors)) {
            $this->title = $title;
            $this->description = $description;
            return true;
        }
        return false;
    }

    public function validateFormFiles(string $fileName): bool
    {
        if (empty($_FILES) || empty($_FILES[$fileName]) || $_FILES[$fileName]["size"] === 0) {
            $this->errors[$fileName] = ucfirst($fileName)." is missing!";
            return false;
        }
        if (!!$_FILES[$fileName]["error"]) {
            $this->errors[$fileName] = $this->fileErrors[$_FILES[$fileName]["error"]] ?? "Unknown error occurred.";
            return false;
        }
        if (is_uploaded_file($_FILES[$fileName]["tmp_name"])) {
            $mime_type = mime_content_type($_FILES[$fileName]['tmp_name']);

            $allowedMimeTypes = ["image/png", "image/jpg", "image/jpeg", "image/webp", "image/avif"];
            if (!in_array($mime_type, $allowedMimeTypes)) {
                $this->errors[$fileName] = ucfirst($fileName)." is not an image!";
                return false;
            }
        }
        $this->file = $_FILES;
        return true;
    }

    public function uploadFile(): bool
    {
        global $imagekit;
        require basePath("libs/imagekit.php");
        $fileUploader = new FileUploader($imagekit);
        $thumbnail = $fileUploader->uploadFile($this->file, "/php-notes-app", "thumbnail");

        if ($thumbnail && Validator::string($thumbnail["url"], 1, 255)) {
            $this->thumbnailUrl = $thumbnail["url"];
            $this->thumbnailPath = $thumbnail["filePath"];
            return true;
        }
        $this->errors["thumbnail"] = FileUploader::class->getFileUploadErrors();
        return false;
    }

    public function insertTaskEntries(): Database|array|null
    {
        return $this->db->query("INSERT INTO tasks (title, description, thumbnail_url, thumbnail_path, user_id, public_id) VALUES (:title, :description, :thumbnail_url, :thumbnail_path, :userId, :publicId)")->execute([
            ":title" => $this->title, ":description" => $this->description, ":thumbnail_url" => $this->thumbnailUrl,
            ":thumbnail_path" => $this->thumbnailPath,
            ":userId" => $_SESSION["user"]["id"]
        ]);
    }

    public function fetchAllTasks(string $id): bool
    {
        global $imagekit;
        require(basePath("libs/imagekit.php"));
        $stmt = $this->db->query('SELECT tasks.public_id as "publicId", title, description, thumbnail_path, upvote, downvote, tasks.created_at FROM tasks JOIN users ON tasks.user_id = users.id WHERE users.id=:id')->execute([":id" => $id]);

        if ($stmt) {
            $tasks = $stmt->fetchAll();
            if (!Validator::array($tasks)) {
                return false;
            }
            $count = 1;
            $_tasks = [];
            foreach ($tasks as $task) {
                $imageUrl = $imagekit->url([
                    "path" => $task["thumbnail_path"],
                    "transformation" => [
                        [
                            "height" => "128",
                            "width" => "128"
                        ]
                    ]
                ]);
                $_tasks[] = [
                    "count" => $count++,
                    "publicId" => $task["publicId"],
                    "title" => $task["title"],
                    "description" => $task["description"],
                    "thumbnailUrl" => $imageUrl,
                    "upvote" => $task["upvote"],
                    "downvote" => $task["downvote"],
                    "createdAt" => $task["created_at"]
                ];
            }
            $this->tasks = $_tasks;
            return true;
        }
        return false;
    }

}
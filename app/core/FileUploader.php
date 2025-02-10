<?php

namespace Core;

class FileUploader
{
    protected $imagekit;
    protected array $errors = [];

    public function __construct($imagekit)
    {
        $this->imagekit = $imagekit;
    }

    public function uploadFile(array $file, string $folder, string $formName): ?array
    {
        $upload = $this->imagekit->uploadFile([
            "file" => base64_encode(file_get_contents($file[$formName]["tmp_name"])),
            "fileName" => $this->formatFileName($file[$formName]["name"]),
            "folder" => $folder,
            "isPrivate" => false
        ]);
        if (!empty($upload->error)) {
            $this->errors[$formName] = "File upload to imagekit failed!";
            return null;
        }

        return [
            "filePath" => $upload->result->filePath,
            "url" => $upload->result->url
        ];
    }

    private function formatFileName(string $name): string
    {
        $nameWithoutExtension = pathinfo($name, PATHINFO_FILENAME);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $nameWithUnderscore = str_replace(["-", "_", " "], "_", $nameWithoutExtension);
        return $nameWithUnderscore;
    }

    public function getFileUploadErrors(): array
    {
        return $this->errors;
    }
}
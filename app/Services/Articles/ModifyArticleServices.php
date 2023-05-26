<?php declare(strict_types=1);

namespace NewsSite\Services\Articles;

use NewsSite\Models\Database;

class ModifyArticleServices
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function create(string $title, string $body): void
    {
        $this->database->create($title, $body);
    }

    public function delete(int $id): void
    {
        $this->database->delete($id);
    }

    public function update(int $id, string $title, string $body): void
    {
        $this->database->update($id, $title, $body);
    }
}

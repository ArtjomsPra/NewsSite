<?php declare(strict_types=1);

namespace NewsSite\Services\Articles;

use NewsSite\Repositories\Article\PdoArticleRepository;

class ModifyArticleServices
{
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(PdoArticleRepository $database)
    {
        $this->pdoArticleRepository = $database;
    }

    public function create(string $title, string $body): void
    {
        $this->pdoArticleRepository->create($title, $body);
    }

    public function delete(int $id): void
    {
        $this->pdoArticleRepository->delete($id);
    }

    public function update(int $id, string $title, string $body): void
    {
        $this->pdoArticleRepository->update($id, $title, $body);
    }
}

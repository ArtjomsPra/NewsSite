<?php declare(strict_types=1);

namespace NewsSite\Services\Articles;

use NewsSite\Repositories\Article\ArticleRepository;
use NewsSite\Repositories\Author\AuthorRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        AuthorRepository $authorRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->authorRepository = $authorRepository;
    }

    public function execute(): array
    {
        $articles = $this->articleRepository->fetchAll();

        foreach ($articles as $article) {
            $user = $this->authorRepository->fetchSingleUser($article->getUserId());
            $article->setUser($user);
        }

        return $articles;
    }
}
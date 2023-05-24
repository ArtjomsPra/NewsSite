<?php declare(strict_types=1);

namespace NewsSite\Services\Articles;

use NewsSite\Repositories\Article\ArticleRepository;
use NewsSite\Repositories\Article\JsonPlaceholderArticleRepository;
use NewsSite\Repositories\Author\AuthorRepository;
use NewsSite\Repositories\Author\JsonPlaceholderAuthorRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->authorRepository = new JsonPlaceholderAuthorRepository();
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
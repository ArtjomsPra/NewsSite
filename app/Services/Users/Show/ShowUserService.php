<?php declare(strict_types=1);

namespace NewsSite\Services\Users\Show;

use NewsSite\Repositories\Article\ArticleRepository;
use NewsSite\Repositories\Author\AuthorRepository;
use NewsSite\Models\Post;


class ShowUserService
{
   private ArticleRepository $articleRepository;
   private AuthorRepository $authorRepository;

    public function __construct
    (
        AuthorRepository $authorRepository,
        ArticleRepository $articleRepository
    )
    {
        $this->authorRepository = $authorRepository;
        $this->articleRepository = $articleRepository;
    }

    public function execute(ShowUserServiceRequest $request): ShowUserServiceResponse
    {
        $authorId = $request->getAuthorId();

        $author = $this->authorRepository->fetchSingleUser($authorId);

        $articles = $this->articleRepository->fetchAllByAuthorId($authorId);

        foreach ($articles as $article) {
            /** @var Post $article */
            $articleAuthor = $this->authorRepository->fetchSingleUser($author->getId());
            $article->setUser($articleAuthor);
        }

        return new ShowUserServiceResponse($author, $articles);
    }
}
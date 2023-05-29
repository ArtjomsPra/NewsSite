<?php declare(strict_types=1);

namespace NewsSite\Services\Articles\Show;

use NewsSite\Repositories\Article\ArticleRepository;
use NewsSite\Repositories\Author\AuthorRepository;
use NewsSite\Repositories\Comment\CommentRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        AuthorRepository $authorRepository,
        CommentRepository $commentRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->authorRepository = $authorRepository;
        $this->commentRepository = $commentRepository;
    }

    public function execute(ShowArticleServiceRequest $request): ShowArticleServiceResponse
    {
        $articleId = $request->getArticleId();

        $article = $this->articleRepository->fetchSinglePost($articleId);

        $user = $this->authorRepository->fetchSingleUser($article->getUserId());

        $article->setUser($user);

        $comments = $this->commentRepository->fetchCommentsByArticleId($articleId);

        return new ShowArticleServiceResponse($article, $comments);
    }
}
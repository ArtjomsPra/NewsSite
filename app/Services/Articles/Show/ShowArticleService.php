<?php declare(strict_types=1);

namespace NewsSite\Services\Articles\Show;

use NewsSite\Repositories\Article\ArticleRepository;
use NewsSite\Repositories\Article\JsonPlaceholderArticleRepository;
use NewsSite\Repositories\Author\AuthorRepository;
use NewsSite\Repositories\Author\JsonPlaceholderAuthorRepository;
use NewsSite\Repositories\Comment\CommentRepository;
use NewsSite\Repositories\Comment\JsonPlaceholderCommentRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    private AuthorRepository $authorRepository;
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->authorRepository = new JsonPlaceholderAuthorRepository();
        $this->commentRepository = new JsonPlaceholderCommentRepository();
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
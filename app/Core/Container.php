<?php declare(strict_types=1);

namespace NewsSite\Core;

use DI\ContainerBuilder;
use NewsSite\Repositories\Article\ArticleRepository;
use NewsSite\Repositories\Article\PdoArticleRepository;
use NewsSite\Repositories\Comment\CommentRepository;
use NewsSite\Repositories\Comment\JsonPlaceholderCommentRepository;
use NewsSite\Repositories\Author\AuthorRepository;
use NewsSite\Repositories\Author\JsonPlaceholderAuthorRepository;

class Container
{
    protected object $container;

    public function __construct()
    {
       $builder = new ContainerBuilder();
       $builder->addDefinitions([
           AuthorRepository::class => new JsonPlaceholderAuthorRepository(),
           ArticleRepository::class => new PdoArticleRepository(),
           CommentRepository::class => new JsonPlaceholderCommentRepository()
       ]);

       $this->container = $builder->build();

    }

    public function getContainer(): object
    {
        return $this->container;
    }

}
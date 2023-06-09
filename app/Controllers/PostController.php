<?php declare(strict_types=1);

namespace NewsSite\Controllers;

use NewsSite\Core\View;
use NewsSite\Services\Articles\ModifyArticleServices;
use NewsSite\Services\Articles\IndexArticleService;
use NewsSite\Services\Articles\Show\ShowArticleServiceRequest;
use NewsSite\Services\Articles\Show\ShowArticleService;
use NewsSite\Models\Post;
use NewsSite\Models\User;

class PostController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;
    private ModifyArticleServices $modifyArticleServices;

    public function __construct(
        IndexArticleService   $indexArticleService,
        ShowArticleService    $showArticleService,
        ModifyArticleServices $modifyArticleServices
    )
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
        $this->modifyArticleServices = $modifyArticleServices;

    }

    public function index(): View
    {
        $articles = $this->indexArticleService->execute();

        return new View('articles', [
            'articles' => $articles
        ]);
    }

    public function show(): View
    {
        $articleId = (int)$_GET['articleId'];
        $response = $this->showArticleService->execute(new ShowArticleServiceRequest($articleId));

        return new View('article', [
            'article' => $response->getPost(),
            'comments' => $response->getComments()
        ]);
    }


    public function create(): View
    {
        $name = $_POST['name'];
        $title = $_POST['title'];
        $body = $_POST['body'];

        $this->modifyArticleServices->create($title, $body);

        $response = $this->indexArticleService->execute();
        /** @var Post $post */
        $post = end($response);
        $user = new User($post->getUserId(), $name);
        $post->setUser($user);

        return new View('create', [
            'article' => $post
        ]);
    }

    public function update(): View
    {
        $id = (int)$_POST['id'];
        $title = $_POST['title'];
        $body = $_POST['body'];

        $this->modifyArticleServices->update($id, $title, $body);

        $response = $this->showArticleService->execute(new ShowArticleServiceRequest($id));

        return new View('update', [
            'article' => $response->getPost()
        ]);
    }

    public function delete(): View
    {
        $articleId = (int)$_POST['articleId'];

        $this->modifyArticleServices->delete($articleId);

        return $this->index();
    }

    public function createForm(): View
    {
        return new View('createForm', []);
    }

    public function updateForm(): View
    {
        $articleId = (int)$_GET['articleId'];
        $response = $this->showArticleService->execute(new ShowArticleServiceRequest($articleId));

        return new View('updateForm', [
            'article' => $response->getPost()
        ]);
    }
}
<?php declare(strict_types=1);

use NewsSite\Controllers\PostController;
use NewsSite\Controllers\UserController;

return [
    ['GET', '/articles', [PostController::class, 'index']],
    ['GET', '/article', [PostController::class, 'show']],
    ['GET', '/authors', [UserController::class, 'index']],
    ['GET', '/author', [UserController::class, 'show']],
    ['GET', '/articles/create', [PostController::class, 'createForm']],
    ['GET', '/article/update', [PostController::class, 'updateForm']],
    ['POST', '/article/create', [PostController::class, 'create']],
    ['POST', '/article/update', [PostController::class, 'update']],
    ['POST', '/articles', [PostController::class, 'delete']]
];
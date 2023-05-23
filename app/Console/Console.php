<?php declare(strict_types=1);

namespace NewsSite;

use NewsSite\Console\ConsoleMakeRequest;
use NewsSite\Console\ConsoleArticleResponse;
use NewsSite\Console\ConsoleUserResponse;

require_once __DIR__ . '/../../vendor/autoload.php';

echo "Please select command you want to use: ";

echo "1 - For all posts" . PHP_EOL;
echo "2 - For all users" . PHP_EOL;
echo "3 - For post by id(1-100)" . PHP_EOL;
echo "4 - For user by id(1-10)" . PHP_EOL;
echo "5 - Exit" . PHP_EOL;

$validOptions = [1, 2, 3, 4, 5];
$num = null;

while (!in_array($num, $validOptions)) {
    $num = (int)readline("Enter here: ");

    if (!in_array($num, $validOptions)) {
        echo "Invalid input. Please enter a valid option (1-5)." . PHP_EOL;
    }
}

switch ($num) {
    case 1:
        $consoleRequest = new ConsoleMakeRequest();
        $articles = $consoleRequest->allPosts();

        foreach ($articles as $article) {
            (new ConsoleArticleResponse($article))->getArticleContent();
        }
        break;
    case 2:
        $consoleRequest = new ConsoleMakeRequest();
        $users = $consoleRequest->allUsers();
        foreach ($users as $user) {
            (new ConsoleUserResponse($user))->getUserContent();
        }
        break;
    case 3:
        $postId = (int)readline("Enter the article ID: ");
        $consoleRequest = new ConsoleMakeRequest();
        $article = $consoleRequest->postById($postId);

        if ($article !== null) {
            (new ConsoleArticleResponse($article))->getArticleContent();
        } else {
            echo "Article not found." . PHP_EOL;
        }
        break;
    case 4:
        $userId = (int)readline("Enter the user ID: ");
        $consoleRequest = new ConsoleMakeRequest();
        $user = $consoleRequest->userById($userId);

        if ($user !== null) {
            (new ConsoleUserResponse($user))->getUserContent();
        } else {
            echo "User not found." . PHP_EOL;
        }
        break;
    case 5:
        echo "Thank you for using console commands! Bye!";
        exit;
}

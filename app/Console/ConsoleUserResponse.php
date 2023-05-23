<?php declare(strict_types=1);

namespace NewsSite\Console;

use NewsSite\Models\User;


class ConsoleUserResponse
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserContent(): void
    {
        echo '**************************************************' . PHP_EOL;
        echo "User id: {$this->user->getId()}" . PHP_EOL;
        echo "Name of user: {$this->user->getName()}" . PHP_EOL;
        echo "Username: {$this->user->getUsername()}." . PHP_EOL;
        echo "Email: {$this->user->getEmail()}." . PHP_EOL;
        echo "City: {$this->user->getCity()}." . PHP_EOL;
        echo "Company: {$this->user->getCompany()}." . PHP_EOL;
        echo PHP_EOL;
    }
}
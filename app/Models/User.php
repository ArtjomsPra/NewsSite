<?php declare(strict_types=1);

namespace NewsSite\Models;

class User
{

    private int $id;
    private string $name;
    private ?string $username;
    private ?string $email;
    private ?string $city;
    private ?string $company;

    public function __construct(
        int    $id,
        string $name,
        string $username = null,
        string $email = null,
        string $city = null,
        string $company = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->city = $city;
        $this->company = $company;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCompany(): string
    {
        return $this->company;
    }
}
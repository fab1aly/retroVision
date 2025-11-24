<?php

namespace app\models;

use flight\Engine;
use PDO;

class User
{
    protected ?PDO $db = null;

    public int $id;
    public ?string $username;
    public ?string $email;
    public ?string $password;
    public ?string $date_creat;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchAll()
    {
        return $this->db->query("SELECT * FROM Users")->fetchAll(PDO::FETCH_CLASS, self::class, [$this->db]);
    }

    public function findByEmail(string $email): ?self
    {
        $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class, [$this->db]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $username, string $email, string $password): void
    {
        $stmt = $this->db->prepare("INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}

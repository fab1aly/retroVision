<?php

class User
{
    private int $id;
    private ?string $username;
    private ?string $email;
    private ?string $password;
    private ?string $date_creat;
    private string $CSRFToken;



    public function __construct(
        ?string $username = null,
        ?string $email = null,
        ?string $password = null
    )
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(int $id, string $username): void
    {
        $usersManager = new UsersManager; // recup de la fonction
        $usersManager->setNewUsername($id, $username);

        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(int $id, string $email): void
    {
        $usersManager = new UsersManager; // recup de la fonction
        $usersManager->setNewEmail($id, $email);

        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(int $id, string $password): void
    {
        $usersManager = new UsersManager; // recup de la fonction
        $usersManager->setNewPassword($id, $password);
    }

    public function persist(): void // save in bd
    {
        $usersManager = new UsersManager; // recup de la fonction
        $usersManager->addUser($this);
    }

    public function generateCSRFToken(): void
    {
        //  Génération du jeton CSRF.
        $this->CSRFToken = bin2hex(random_bytes(64));
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function logInSession(): void
    {
        //  Démarrage de la session.
        // session_start();
        if (isset($_SESSION) === false)
        {
            session_start();
        }
        //  Régénération de l'identifiant de session (en supprimant la session précédente).
        session_regenerate_id(true);
        //  Suppression du mot de passe des informations à persister dans la session.
        unset($this->password);
        //  Génération du jeton CSRF.
        $this->generateCSRFToken();

        //  Persistance de l'utilisateur dans la session.
        $_SESSION['user'] = $this;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
    }
}

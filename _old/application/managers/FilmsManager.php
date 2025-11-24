<?php

// namespace Controllers/Managers;

// use \Core\Manager;

class FilmsManager extends Manager
{
    public function addFilm(User $user): void
    {

        //  Définition de la requête.
        $query = 'INSERT INTO `Films`( `username`,`email`, `password`) 
                VALUES(:username, :email, :password)';

        //  Préparation de la requête.
        $sth = self::$dbh->prepare($query);

        //  Association des différentes valeurs à leur paramètre.
        $sth->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $sth->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $sth->bindValue(':password', password_hash($user->getPassword(), PASSWORD_DEFAULT), PDO::PARAM_STR);

        //  Exécution de la requête.
        $sth->execute();
    }

    public function getAllFilms(): array
    {
        $query = "SELECT slug, imdbID, json_short, json_full, date_creat FROM Films";

        $sth = self::$dbh->prepare($query);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function getFilmDataByImdbID(string $imdbID)
    {
        $query = "SELECT * FROM Films WHERE film_imdbID = :imdbID";

        $sth = self::$dbh->prepare($query);
        $sth->bindValue(':imdbID', $imdbID);

        $sth->execute();

        return $sth->fetch();
    }

    ///////////////////////////////////////////////////////////////////////////////////

    public function getListsByUserId(int $user_id)
    {

        $query = "SELECT * FROM Lists WHERE user_id = :user_id ORDER BY id ASC";

        $sth = self::$dbh->prepare($query);
        $sth->bindValue(':user_id', $user_id);

        $sth->execute();

        return $sth->fetchAll();
    }

    public function saveList(int $user_id, string $name, string $listpoint, string $uniqid): void
    {
        $query = "INSERT INTO Lists (uniq_id, user_id, name, listpoint)
                                VALUES (:uniqid, :user_id, :name,:listpoint)";

        $sth = self::$dbh->prepare($query);
        $sth->bindValue(':uniqid', $uniqid);
        $sth->bindValue(':user_id', $user_id);
        $sth->bindValue(':name', $name);
        $sth->bindValue(':listpoint', $listpoint);

        $sth->execute();
    }

    public function removeList(int $user_id,  $uniqid): void
    {

        $query = "DELETE FROM Lists WHERE (user_id = :user_id AND uniq_id = :uniqid)";

        $sth = self::$dbh->prepare($query);
        $sth->bindValue(':user_id', $user_id);
        $sth->bindValue(':uniqid', $uniqid);
        $sth->execute();
    }
}

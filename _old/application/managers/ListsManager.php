<?php
    
    // namespace Controllers/Managers;
    
    // use \Core\Manager;
    
    class ListsManager extends Manager
    {
        public function getList (string $uniqid) 
        {
            
            $query = "SELECT * FROM Lists WHERE uniq_id = :uniqid";
            
            $sth = self::$dbh->prepare($query);
            $sth->bindValue(':uniqid', $uniqid);
            
            $sth->execute();
            
            return $sth->fetch();
        }

        public function getListsByUserId (int $user_id) 
        {
            
            $query = "SELECT * FROM Lists WHERE user_id = :user_id ORDER BY id ASC";
            
            $sth = self::$dbh->prepare($query);
            $sth->bindValue(':user_id', $user_id);
            
            $sth->execute();
            
            return $sth->fetchAll();
        }

        public function saveList (int $user_id, string $name, string $listpoint, string $uniqid) : void
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

        public function removeList (int $user_id,  $uniqid) : void
        {
            
            $query = "DELETE FROM Lists WHERE (user_id = :user_id AND uniq_id = :uniqid)";
            
            $sth = self::$dbh->prepare($query);
            $sth->bindValue(':user_id', $user_id);
            $sth->bindValue(':uniqid', $uniqid);
            $sth->execute();
        }

    }
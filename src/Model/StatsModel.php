<?php

namespace App\Model;

use Doctrine\ORM\EntityManagerInterface;

class StatsModel
{
    private $_entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->_entityManager = $entityManager;
    }

    public function getLongestDive()
    {
        $query = "SELECT total_time, user.username FROM `dive` INNER JOIN user ON user.id = dive.owner_id WHERE total_time = ( SELECT MAX(total_time) FROM dive )";

        $connexion = $this->_entityManager->getConnection();

        $statement = $connexion->prepare($query);

        $result = $statement->executeQuery();

        $longest_dive = $result->fetchAssociative();

        return $longest_dive;
    }

    public function getDeepestDive()
    {
        $query = "SELECT max_depth, user.username FROM `dive` INNER JOIN user ON user.id = dive.owner_id WHERE max_depth = ( SELECT MAX(max_depth) FROM dive )";

        $connexion = $this->_entityManager->getConnection();

        $statement = $connexion->prepare($query);

        $result = $statement->executeQuery();

        $longest_dive = $result->fetchAssociative();

        return $longest_dive;
    }

    public function getFirstSubscribedUser()
    {
        $query = "SELECT username, subscribed_at FROM `user` WHERE subscribed_at = ( SELECT MIN(subscribed_at) FROM user )";

        $connexion = $this->_entityManager->getConnection();

        $statement = $connexion->prepare($query);

        $result = $statement->executeQuery();

        $longest_dive = $result->fetchAssociative();

        return $longest_dive;
    }

    public function getLastSubscribedUser()
    {
        $query = "SELECT username, subscribed_at FROM `user` WHERE subscribed_at = ( SELECT MAX(subscribed_at) FROM user )";

        $connexion = $this->_entityManager->getConnection();

        $statement = $connexion->prepare($query);

        $result = $statement->executeQuery();

        $longest_dive = $result->fetchAssociative();

        return $longest_dive;
    }

    public function getMostActiveDiver()
    {
        $query = "SELECT username, COUNT(dive.id) AS dive_count FROM `user` JOIN dive ON user.id = dive.owner_id GROUP BY user.username ORDER BY dive_count DESC LIMIT 1";

        $connexion = $this->_entityManager->getConnection();

        $statement = $connexion->prepare($query);

        $result = $statement->executeQuery();

        $longest_dive = $result->fetchAssociative();

        return $longest_dive;
    }

    public function getTotalDives()
    {
        $query = "SELECT id FROM `dive`";

        $connexion = $this->_entityManager->getConnection();

        $statement = $connexion->executeStatement($query, ['id' => ''], ['id' => \PDO::PARAM_STR]);

        return $statement;
    }

    public function getTotalUsers()
    {
        $query = "SELECT id FROM `user`";

        $connexion = $this->_entityManager->getConnection();

        $statement = $connexion->executeStatement($query, ['id' => ''], ['id' => \PDO::PARAM_STR]);

        return $statement;
    }
}

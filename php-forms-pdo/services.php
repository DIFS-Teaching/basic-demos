<?php

/**
 * This class represents the part of data layer related to people.
 * It simply implements the basic operations using PDO.
 */
class PeopleService
{
    private $pdo;
    private $lastError;
    
    function __construct()
    {
        $this->pdo = $this->connect_db();
        $this->lastError = NULL;
    }

    function connect_db()
    {
        $dsn = 'mysql:host=localhost;dbname=people;charset=utf8mb4';
        $username = 'demo';
        $password = 'demo';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // the default since PHP 8.0
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
    }

    function getErrorMessage()
    {
        if ($this->lastError === NULL)
            return '';
        else
            return $this->lastError;
    }
    
    function getPeople()
    {
        $stmt = $this->pdo->query('SELECT id, name, surname FROM users LIMIT 100');
        return $stmt;
    }
    
    function getPerson($id)
    {
        $stmt = $this->pdo->prepare('SELECT id, name, surname FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    function addPerson($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (name, surname) VALUES (:name, :surname)');
        try
        {
            $stmt->execute($data);
            $newid = $this->pdo->lastInsertId();
            $data['id'] = $newid;
            return $data;
        }
        catch (PDOException $e)
        {
            error_log($e->getMessage()); // details go to the server log, not to the user
            $this->lastError = 'Database operation failed.';
            return FALSE;
        }
    }
    
    function updatePerson($data)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET name = :name, surname = :surname WHERE id = :id');
        try
        {
            $stmt->execute($data);
            return TRUE;
        }
        catch (PDOException $e)
        {
            error_log($e->getMessage()); // details go to the server log, not to the user
            $this->lastError = 'Database operation failed.';
            return FALSE;
        }
    }
    
    function deletePerson($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        try
        {
            $stmt->execute([$id]);
            return TRUE;
        }
        catch (PDOException $e)
        {
            error_log($e->getMessage()); // details go to the server log, not to the user
            $this->lastError = 'Database operation failed.';
            return FALSE;
        }
    }

}

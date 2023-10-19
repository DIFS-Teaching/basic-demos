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
        $dsn = 'mysql:host=localhost;dbname=people';
        $username = 'demo';
        $password = 'demo';
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $pdo = new PDO($dsn, $username, $password, $options);
        return $pdo;
    }

    function getErrorMessage()
    {
        if ($this->lastError === NULL)
            return '';
        else
            return $this->lastError[2]; //the message
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
        if ($stmt->execute($data))
        {
            $newid = $this->pdo->lastInsertId();
            $data['id'] = $newid;
            return $data;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }
    
    function updatePerson($data)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET name = :name, surname = :surname WHERE id = :id');
        if ($stmt->execute($data))
        {
            return TRUE;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }
    
    function deletePerson($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        if ($stmt->execute([$id]))
        {
            return TRUE;
        }
        else
        {
            $this->lastError = $stmt->errorInfo();
            return FALSE;
        }
    }

}

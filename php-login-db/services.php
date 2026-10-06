<?php

/**
 * This class represents the part of data layer related to user identities.
 * It simply implements the basic identity management using PDO.
 */
class AccountService
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
    
    function addAccount($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO accounts (login, password, name) VALUES (?, ?, ?)');
        $login = $data['login'];
        $name = $data['name'];
        $pwd = password_hash($data['password'], PASSWORD_DEFAULT);
        try
        {
            $stmt->execute([$login, $pwd, $name]);
            $newid = $this->pdo->lastInsertId();
            $data['id'] = $newid;
            return $data;
        }
        catch (PDOException $e)
        {
            error_log($e->getMessage()); // details go to the server log, not to the user
            if ($e->getCode() == 23000) // integrity constraint violation
                $this->lastError = 'This login is already taken.';
            else
                $this->lastError = 'Database operation failed.';
            return FALSE;
        }
    }
    
    function getAccount($login)
    {
        $stmt = $this->pdo->prepare('SELECT id, login, name, password FROM accounts WHERE login = ?');
        $stmt->execute([$login]);
        return $stmt->fetch();
    }
    
    function isValidAccount($login, $password)
    {
        $data = $this->getAccount($login);
        if ($data === FALSE) // no such account
            return FALSE;
        return password_verify($password, $data['password']);
    }

}

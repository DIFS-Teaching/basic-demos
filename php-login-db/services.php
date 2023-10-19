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
    
    function addAccount($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO accounts (login, password) VALUES (?, ?)');
        $login = $data['login'];
        $pwd = password_hash($data['password'], PASSWORD_DEFAULT);
        if ($stmt->execute([$login, $pwd]))
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
    
    function getAccount($login)
    {
        $stmt = $this->pdo->prepare('SELECT id, login, password FROM accounts WHERE login = ?');
        $stmt->execute([$login]);
        return $stmt->fetch();
    }
    
    function isValidAccount($login, $password)
    {
        $data = $this->getAccount($login);
        return password_verify($password, $data['password']);
    }

}

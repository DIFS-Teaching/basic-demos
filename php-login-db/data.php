<?php

/**
 * DATA LAYER
 *
 * Database connection and SQL access to the `accounts` table.
 * This is the only part of the application that works with PDO and SQL.
 * It contains no application rules and does not handle errors:
 * PDOException is passed to the business layer.
 */

/**
 * Creates a new database connection.
 */
function db_connect()
{
    $dsn = 'mysql:host=localhost;dbname=people;charset=utf8mb4';
    $username = 'demo';
    $password = 'demo';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // the default since PHP 8.0
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    return new PDO($dsn, $username, $password, $options);
}

/**
 * Stores and retrieves user accounts (rows of the `accounts` table).
 */
class AccountRepository
{
    private $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function findByLogin($login)
    {
        $stmt = $this->pdo->prepare('SELECT id, login, name, password FROM accounts WHERE login = ?');
        $stmt->execute([$login]);
        return $stmt->fetch();
    }

    function insert($login, $passwordHash, $name)
    {
        $stmt = $this->pdo->prepare('INSERT INTO accounts (login, password, name) VALUES (?, ?, ?)');
        $stmt->execute([$login, $passwordHash, $name]);
        return (int) $this->pdo->lastInsertId();
    }

    function updatePasswordHash($id, $passwordHash)
    {
        $stmt = $this->pdo->prepare('UPDATE accounts SET password = ? WHERE id = ?');
        $stmt->execute([$passwordHash, $id]);
    }
}

<?php

/**
 * DATA LAYER
 *
 * Database connection and SQL access to the `users` table.
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
 * Stores and retrieves people (rows of the `users` table).
 */
class PeopleRepository
{
    private $pdo;

    function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    function findAll($limit)
    {
        $stmt = $this->pdo->prepare('SELECT id, name, surname FROM users LIMIT ?');
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function findById($id)
    {
        $stmt = $this->pdo->prepare('SELECT id, name, surname FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    function insert($name, $surname)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (name, surname) VALUES (?, ?)');
        $stmt->execute([$name, $surname]);
        return (int) $this->pdo->lastInsertId();
    }

    function update($id, $name, $surname)
    {
        $stmt = $this->pdo->prepare('UPDATE users SET name = ?, surname = ? WHERE id = ?');
        $stmt->execute([$name, $surname, $id]);
    }

    function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
    }
}

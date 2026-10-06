<?php

/**
 * BUSINESS LAYER
 *
 * User account management used by the presentation layer (the pages).
 * Implements the application rules (data validation, password hashing
 * and verification) and uses the data layer (AccountRepository) for storing
 * the accounts. It never uses SQL directly.
 */

require_once "data.php";

class AccountService
{
    const MIN_PASSWORD_LENGTH = 8;

    private $accounts; // AccountRepository from the data layer
    private $lastError;

    function __construct()
    {
        $this->accounts = new AccountRepository(db_connect());
        $this->lastError = NULL;
    }

    function getErrorMessage()
    {
        if ($this->lastError === NULL)
            return '';
        else
            return $this->lastError;
    }

    /**
     * Creates a new account. Returns the account data (without the password)
     * or FALSE on error.
     */
    function addAccount($data)
    {
        $login = trim($data['login'] ?? '');
        $name = trim($data['name'] ?? '');
        $password = $data['password'] ?? '';
        if ($login === '' || $name === '')
        {
            $this->lastError = 'Login and name are required.';
            return FALSE;
        }
        if (strlen($password) < self::MIN_PASSWORD_LENGTH)
        {
            $this->lastError = 'The password must have at least ' . self::MIN_PASSWORD_LENGTH . ' characters.';
            return FALSE;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        try
        {
            $id = $this->accounts->insert($login, $hash, $name);
            return ['id' => $id, 'login' => $login, 'name' => $name];
        }
        catch (PDOException $e)
        {
            error_log($e->getMessage()); // details go to the server log, not to the user
            if ($e->getCode() == 23000) // integrity constraint violation (unique login)
                $this->lastError = 'This login is already taken.';
            else
                $this->lastError = 'Database operation failed.';
            return FALSE;
        }
    }

    /**
     * Checks the login and password. When the password hash was created with
     * older algorithm or parameters, it is recomputed and stored.
     */
    function isValidAccount($login, $password)
    {
        $account = $this->accounts->findByLogin($login);
        if ($account === FALSE) // no such account
            return FALSE;
        if (!password_verify($password, $account['password']))
            return FALSE;

        if (password_needs_rehash($account['password'], PASSWORD_DEFAULT))
        {
            try
            {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $this->accounts->updatePasswordHash($account['id'], $hash);
            }
            catch (PDOException $e)
            {
                error_log($e->getMessage()); // not critical, the old hash is still valid
            }
        }
        return TRUE;
    }

    /**
     * Returns the account data for the presentation layer.
     * The password hash is not included, the pages do not need it.
     */
    function getAccount($login)
    {
        $account = $this->accounts->findByLogin($login);
        if ($account === FALSE)
            return FALSE;
        unset($account['password']);
        return $account;
    }
}

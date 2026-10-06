<?php

/**
 * BUSINESS LAYER
 *
 * Operations on people used by the presentation layer (the pages).
 * Checks the application rules (data validation) and uses the data layer
 * (PeopleRepository) for storing the data. It never uses SQL directly.
 */

require_once "data.php";

class PeopleService
{
    const MAX_LENGTH = 64; // corresponds to the column size in the database

    private $people; // PeopleRepository from the data layer
    private $lastError;

    function __construct()
    {
        $this->people = new PeopleRepository(db_connect());
        $this->lastError = NULL;
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
        return $this->people->findAll(100);
    }

    function getPerson($id)
    {
        return $this->people->findById($id);
    }

    function addPerson($data)
    {
        $person = $this->validate($data);
        if ($person === FALSE)
            return FALSE;
        try
        {
            $person['id'] = $this->people->insert($person['name'], $person['surname']);
            return $person;
        }
        catch (PDOException $e)
        {
            return $this->databaseError($e);
        }
    }

    function updatePerson($data)
    {
        $person = $this->validate($data);
        if ($person === FALSE)
            return FALSE;
        try
        {
            $this->people->update($data['id'], $person['name'], $person['surname']);
            return TRUE;
        }
        catch (PDOException $e)
        {
            return $this->databaseError($e);
        }
    }

    function deletePerson($id)
    {
        try
        {
            $this->people->delete($id);
            return TRUE;
        }
        catch (PDOException $e)
        {
            return $this->databaseError($e);
        }
    }

    /**
     * Application rules for a person: name and surname are required
     * and they must not be longer than MAX_LENGTH characters.
     * Returns the normalized data or FALSE when the data is not valid.
     */
    private function validate($data)
    {
        $name = trim($data['name'] ?? '');
        $surname = trim($data['surname'] ?? '');
        if ($name === '' || $surname === '')
        {
            $this->lastError = 'Name and surname are required.';
            return FALSE;
        }
        if (self::length($name) > self::MAX_LENGTH || self::length($surname) > self::MAX_LENGTH)
        {
            $this->lastError = 'Name and surname may have at most ' . self::MAX_LENGTH . ' characters.';
            return FALSE;
        }
        return ['name' => $name, 'surname' => $surname];
    }

    /**
     * Returns the number of characters (not bytes) of an UTF-8 string.
     * (mb_strlen() would do the same but it requires the mbstring extension.)
     */
    private static function length($s)
    {
        return preg_match_all('/./su', $s);
    }

    private function databaseError($e)
    {
        error_log($e->getMessage()); // details go to the server log, not to the user
        $this->lastError = 'Database operation failed.';
        return FALSE;
    }
}

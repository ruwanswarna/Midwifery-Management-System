<?php

declare(strict_types=1);

final class Database
{   // shared database connection - matters when using transactions - multiple repositories
    // Every repository receives the same connection
    private static ?PDO $connection = null;

    // Returns the shared PDO connection
    public function connection(): PDO
    {
        if (self::$connection === null) {
            self::$connection = $this->createConnection();
        }
        return self::$connection;
    }

    // create and configure PDO connection
    private function createConnection(): PDO
    {
        $config = require ROOT_PATH . '/config/database.php';

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset']
        );

        self::$connection = new PDO(
            $dsn,
            $config['username'],
            $config['password']
        );
        // throw exceptions for errors
        self::$connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
        // fetch results as associative arrays
        self::$connection->setAttribute(
            PDO::ATTR_DEFAULT_FETCH_MODE,
            PDO::FETCH_ASSOC
        );
        // disable emulated prepared statements - use native prepared statements
        self::$connection->setAttribute(
            PDO::ATTR_EMULATE_PREPARES,
            false
        );
        // Preserve numeric values where supported.
        self::$connection->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);

        return self::$connection;
    }

    //get the current PDO connection
    public static function getDBConnection(): ?PDO
    {
        return self::$connection;
    }

    // Starts a new database transaction
    public function beginTransaction(): bool
    {
        // check if transaction is already started
        if ($this->inTransaction()) {
            return false;
        }
        return self::$connection->beginTransaction();
    }


    // Commits the current database transaction
    public function commit(): bool
    {
        if ($this->inTransaction()) {
            return false;
        }
        return self::$connection->commit();
    }

    // Rolls back the current database transaction
    public function rollback(): bool
    {
        if (!$this->inTransaction()) {
            return false;
        }
        return self::$connection->rollBack();
    }

    // in transaction
    public function inTransaction(): bool
    {
        return self::$connection !== null
            && self::$connection->inTransaction();
    }

    // Closes the database connection
    public function close(): void
    {
        // rollback partial transactions before closing
        if ($this->inTransaction()) {
            $this->rollBack();
        }
        self::$connection = null;
    }

    // change a PDO connectionattribute
    public function setAttribute(int $attribute, mixed $value): bool
    {
        return self::$connection->setAttribute($attribute, $value);
    }

    // read a PDO connectionattribute
    public function getAttribute(int $attribute): mixed
    {
        return self::$connection->getAttribute($attribute);
    }
}

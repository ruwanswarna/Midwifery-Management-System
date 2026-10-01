<?php
declare(strict_types=1);
abstract class Repository
{
    protected PDO $db;
    // get database connection
    public function __construct()
    {
        $this->db = (new Database())->connection();
    }
    //Prepare and execute any SQL statement
    protected function query(
        string $sql,
        array $params = []
    ): PDOStatement {
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        return $statement;
    }
    // Fetch one row or return null
    protected function findOne(
        string $sql,
        array $params = []
    ): ?array {
        $row = $this->query($sql, $params)->fetch();
        return $row ?: null;
    }
    // Fetch multiple rows
    protected function findAll(
        string $sql,
        array $params = []
    ): array {
        return $this
            ->query($sql, $params)
            ->fetchAll();
    }
    // execute any SQL statement
    protected function execute(
        string $sql,
        array $params = []
    ): int {
        return $this
            ->query($sql, $params)
            ->rowCount();
    }

    // Return the ID of the last inserted row
    protected function lastInsertId(): int
    {
        return (int) $this->db->lastInsertId();
    }

    // return first column from first row
    protected function findScalar(
        string $sql,
        array $params = []
    ): mixed {

        return $this
            ->query($sql, $params)
            ->fetchColumn() ?? null;
        // intended for queries that naturally return a single value
    }

    // return first column from matching rows
    protected function fetcolumnValues(
        string $sql,
        array $params = []
    ): array {

        return $this
            ->query($sql, $params)
            ->fetchALL(PDO::FETCH_COLUMN, 0);
    }

    // Check whether a record exists
    protected function exists(
        string $sql,
        array $params = []
    ): bool {
        return $this
            ->query($sql, $params)
            ->fetchColumn() !== false;
    }


    // Return a record count
    protected function count(
        string $sql,
        array $params = []
    ): int {

        return (int) ($this
            ->query($sql, $params)
            ->fetchColumn() ?? 0);
    }


    ///NOTE Transaction methods also included in the repository class for convenience

    protected function beginTransaction(): bool
    {
        return $this->db->beginTransaction();
    }

    protected function commit(): bool
    {
        return $this->db->commit();
    }

    protected function rollBack(): bool
    {
        return $this->db->rollBack();
    }

    protected function inTransaction(): bool
    {
        return $this->db->inTransaction();
    }
}

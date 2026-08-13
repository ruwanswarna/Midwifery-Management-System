<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database.php';

abstract class CsvSeeder
{
    protected PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    abstract public function run(): void;

    protected function seed(string $table, string $csvFile): void
    {
        if (!file_exists($csvFile)) {
            throw new Exception("CSV file not found: {$csvFile}");
        }

        $handle = fopen($csvFile, 'r');

        if ($handle === false) {
            throw new Exception("Unable to open {$csvFile}");
        }

        $columns = fgetcsv($handle);

        if ($columns === false) {
            fclose($handle);
            return;
        }

        $columns = array_map(
            static fn(string $column): string => trim($column, " \t\n\r\0\x0B\xEF\xBB\xBF"),
            $columns
        );

        foreach ($columns as $column) {
            if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $column)) {
                fclose($handle);
                throw new RuntimeException("Invalid CSV column name: {$column}");
            }
        }

        $placeholders = implode(',', array_fill(0, count($columns), '?'));

        $quotedColumns = implode(
            ',',
            array_map(fn($c) => "`{$c}`", $columns)
        );

        $sql = "INSERT INTO `{$table}` ({$quotedColumns})
                VALUES ({$placeholders})";

        $statement = $this->db->prepare($sql);

        $count = 0;

        $this->db->beginTransaction();

        try {

            $line = 1;
            while (($row = fgetcsv($handle)) !== false) {
                $line++;

                $isBlank = count(array_filter(
                    $row,
                    static fn($value): bool => trim((string) $value) !== ''
                )) === 0;

                // Some source files were assembled in batches and contain
                // blank separator lines and repeated header rows.
                if ($isBlank || $row === $columns) {
                    continue;
                }

                foreach ($row as &$value) {

                    if ($value === '') {
                        $value = null;
                    } elseif (preg_match(
                        '/^(?<month>\d{1,2})\/(?<day>\d{1,2})\/(?<year>\d{4})$/',
                        $value,
                        $date
                    )) {
                        $value = sprintf(
                            '%04d-%02d-%02d',
                            (int) $date['year'],
                            (int) $date['month'],
                            (int) $date['day']
                        );
                    }
                }
                unset($value);

                if (count($row) !== count($columns)) {
                    throw new RuntimeException(
                        "{$csvFile}: line {$line} has " . count($row)
                        . ' values; expected ' . count($columns)
                    );
                }

                $statement->execute($row);

                $count++;
            }

            $this->db->commit();

        } catch (Throwable $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            fclose($handle);

            throw $e;
        }

        fclose($handle);

        echo "{$table} : {$count} rows inserted." . PHP_EOL;
    }
}

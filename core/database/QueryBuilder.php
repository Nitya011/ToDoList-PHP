<?php

class QueryBuilder {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function read($table) {
        $statement = $this->pdo->prepare("SELECT * FROM {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function create($table, $data) {
        $keys = implode(',', array_keys($data));
        $values = ':' . implode(',:', array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$values})";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
    }

    public function update($table, $data, $id) {
        // Prepare the SET clause for the update query
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            // Skip the ID field as it should not be updated
            if ($key !== 'id') {
                $fields[] = "$key = ?";
                $values[] = $value;
            }
        }
        $setClause = implode(', ', $fields);
    
        // Prepare the update query
        $sql = "UPDATE $table SET $setClause WHERE id = ?";
        $values[] = $id;
    
        // Execute the update query using prepared statement
        $statement = $this->pdo->prepare($sql);
        $statement->execute($values);
    }    
    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";

        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}


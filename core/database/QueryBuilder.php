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
    
    public function update($table, $parameters, $whereClause, $whereParameters)
    {
        $setParts = [];
        foreach ($parameters as $key => $value) {
            $setParts[] = "{$key} = :{$key}";
        }
        $setClause = implode(', ', $setParts);
        // Construct the update query
        $sql = sprintf(
            'UPDATE %s SET %s WHERE %s',
            $table,
            $setClause,
            $whereClause
        );
        // Merge parameters for set values and where clause
        $allParameters = array_merge($parameters, $whereParameters);
        // Prepare and execute the query
        $statement = $this->pdo->prepare($sql);
        foreach ($allParameters as $key => &$value) {
            $statement->bindParam(":{$key}", $value);
        }
        $statement->execute();
        return $statement->rowCount() > 0;
    }
    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
    }
}


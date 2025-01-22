<?php

    interface IDbCommand{
        public function createTable(string $dbName, string $tabelName) : bool;
        public function insert(string $tableName, string $columnName, array $values): bool;
        public function select(string $tableName, string $columnName, string $values): array;
    
        public function getMyConnection();
    }

?>
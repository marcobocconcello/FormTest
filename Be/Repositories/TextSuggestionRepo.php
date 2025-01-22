<?php

    require_once 'C:\xampp\htdocs\Test\Be\Repositories\ITextSuggestionRepo.php'; 

    class TextSuggestionRepo implements ITextSuggestionRepo{

        private array $mock_text = array('p','pr','pro','prov','prova', 't', 'te', 'test'); 

        private IDbCommand $command;
        private string $dbTable;
        private string $tableName;
        private IFileOperation $logger;
        
        public function get_dbName() : string{
            return $this->dbTable;
        }
        public function get_tableName() : string{
            return $this->tableName;
        }

        public function getDbCommand(){
            return $this -> command;
        }

        public function __construct(IDbCommand $command, 
                                    string $dbTable,
                                    string $tableName,
                                    IFileOperation $logger){
            $this->command = $command;
            $this->dbTable = $dbTable;
            $this->tableName = $tableName;
            $this->logger = $logger;

            $this->command -> createTable($dbTable, $tableName);
        }

        public function mock_table(string $columnname) : bool{
            if($columnname !== null && $columnname !== ""){
                $this->logger -> writelog("Chiamata al mock table", Level::Warning -> value);

                return $this->command -> insert($this -> tableName , $columnname, $this->mock_text);
            }
            return false;
        }

        public function select_text(string $text, string $columnname) : array{

            if($text !== null && $text !== "" && $columnname !== null && $columnname !== ""){
                $this->logger -> writelog("Chiamata alla select", Level::Information -> value);
                return $this -> command -> select($this->tableName, $columnname, $text);
            }

            return [];

        }
    }

?>
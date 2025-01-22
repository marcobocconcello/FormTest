<?php

    require_once 'C:\xampp\htdocs\Test\Be\Context\IDbCommand.php';
    require_once 'C:\xampp\htdocs\Test\Be\Context\MySqlConnection.php'; 

    class MySqlCommand implements IDbCommand{

        private $host;
        private $user;
        private $password;
        private $database;
    
        private MySqlConnection $myConnection;

        private IFileOperation $logger;

        public function getMyConnection() : MySqlConnection{
            return $this->myConnection;
        }

        public function __construct(string $host,
                                    string $user,
                                    string $password,
                                    string $database,
                                    IFileOperation $logger)
        {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
            $this-> myConnection = new MySqlConnection();
            $this->logger = $logger;
        }

        public function createTable(string $dbName, 
                                    string $tabelName) : bool{

            try{

                $this->logger -> writelog("Inzio connessione...", Level::Information -> value);
                $this -> myConnection -> Connect($this -> host,
                                                $this -> user,
                                                $this -> password,
                                                $this -> database);

                $this->logger -> writelog("Connessione avvenuta con successo", Level::Information -> value);
                $queryTableEx = "SELECT * 
                                FROM information_schema.tables
                                WHERE table_schema = '$dbName' 
                                    AND table_name = '$tabelName'
                                LIMIT 1;";

                $queryTableCreate = "CREATE TABLE $tabelName(
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    possiblevalue LONGTEXT
                )";

                $result = $this -> myConnection -> get_connection()-> query($queryTableEx);
                $this->logger -> writelog("Risultato select per presenza tabella: $result->num_rows", Level::Information -> value);

                if($result -> num_rows <= 0){
                    $this -> myConnection -> get_connection()-> query($queryTableCreate);
                    $this->logger -> writelog("Tabella creata", Level::Information -> value);
                    return true;
                }

                return false;

            }catch(Exception $ex){
                $this -> myConnection -> get_connection()-> close();
                $this->logger -> writelog("Errore nella creazione dell tabella: $ex -> getMessage()", Level::Error -> value);
                throw new Exception("Errore nell'esecuzione della query. Message: ". $ex -> getMessage());
            }
        }

        public function insert(string $tableName, string $columnName, array $values): bool{
            try{
                $queryInsert = '';
                            
                if($values == null || count($values) <= 0)
                {
                    $this->logger -> writelog("Inserimento in tabella $tableName con numero di valori di default", Level::Warning -> value);
                    $queryInsert = " INSERT INTO  $tableName($columnName)
                                        VALUES('p'),
                                            ('pr'),
                                            ('pro'),
                                            ('prov'),
                                            ('prova')";
                }
                else
                {
                    $this->logger -> writelog("Inserimento in tabella $tableName con numero di valori non di default", Level::Warning -> value);
                    $queryInsertBuilder = " INSERT INTO  $tableName($columnName)
                                                VALUES";

                    foreach($values as $text){
                        $queryInsertBuilder = $queryInsertBuilder. "('$text'),";
                    } 
                    //rimuovo l'ultima virgola
                    $queryInsert = substr($queryInsertBuilder,0,-1);


                }
                
                
                $querySelect = "    SELECT * 
                                    FROM $tableName
                                    WHERE $columnName LIKE('%p%')";

                if(($this -> myConnection -> get_connection()-> query($querySelect) -> num_rows) <=0){
                    $this->logger -> writelog("Inserimento dei valori in quanto non ancora inseriti", Level::Information -> value);
                    $this -> myConnection -> get_connection()-> query($queryInsert);
                    return true;
                }
                $this->logger -> writelog("Inserimento dei valori non avvenuto in quanto già inseriti", Level::Information -> value);
                return false;

            }catch(Exception $ex){
                $this -> myConnection -> get_connection()-> close();
                $this->logger -> writelog("Errore nell'insert sulla tabella: $ex -> getMessage()", Level::Error -> value);
                throw new Exception("Errore nell'esecuzione della query. Message: ". $ex -> getMessage());
            }
        }

        public function select(string $tableName, string $columnName, string $testo): array{
            try{
                
                $querySelect = "    SELECT * 
                                        FROM $tableName  
                                        WHERE $columnName LIKE('%$testo%')
                                        ";

                $this->logger -> writelog("Inizio select degli elementi", Level::Information -> value);

                $resultselect2 = $this -> myConnection -> get_connection()-> query($querySelect);
                $data = array();
                while($row= $resultselect2 -> fetch_array()){
                    array_push($data, $row["possiblevalue"]);
                }

                return $data;
               

            }catch(Exception $ex){
                $this -> myConnection -> get_connection()-> close();
                $this->logger -> writelog("Errore nella select: $ex -> getMessage()", Level::Error -> value);
                throw new Exception("Errore nell'esecuzione della query. Message: ". $ex -> getMessage());
            }
        }
    }

?>
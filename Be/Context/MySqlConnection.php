<?php

    class MySqlConnection{

        private mysqli $connection;

        public function get_connection() : mysqli {
            return $this-> connection;
        }

        public function Connect(string $host, 
                                string $user, 
                                string $password, 
                                string $database) : bool {
            try{
                
                if ($host === null ||
                 $user === null || 
                 $password === null || 
                 $database === null){
                    throw new Exception("Parametri di input null");
                 }  

                if($host === "" || $user === "" || $database === ""){
                    throw new Exception("Parametri di input richiesti per la connesione vuoti. $host, $user, $password");
                }

                $this -> connection = new mysqli(
                    $host,
                    $user,
                    $password,
                    $database
                );
            
                return ($this -> connection == false) ? false : true;
                

            }catch(Exception $ex){
                $this-> connection -> close();
                throw new Exception("Errore nella connessione a db. Message: " . $ex -> getMessage());
            }
        }
    }

?>
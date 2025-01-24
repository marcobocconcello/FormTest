<?php

    class MySqlConnection{

        private static mysqli $connection;

        public static function get_connection() : mysqli {
            return self::$connection;
        }

        public static function Connect(string $host, 
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

                self::$connection = new mysqli(
                    $host,
                    $user,
                    $password,
                    $database
                );
            
                return (self::$connection == false) ? false : true;
                

            }catch(Exception $ex){
                self::$connection -> close();
                throw new Exception("Errore nella connessione a db. Message: " . $ex -> getMessage());
            }
        }
    }

?>
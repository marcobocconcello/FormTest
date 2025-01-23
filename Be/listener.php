<?php

    //variable superglobale = fuori scope che contiene il body della chiamata http in metodo post del cient.
    //in questo caso sto recuperando il valore della chiave 'testo' in request 
    $testo =  $_POST["testo"];

    require_once 'C:\xampp\htdocs\Test\Be\Repositories\TextSuggestionRepo.php'; 
    require_once 'C:\xampp\htdocs\Test\Be\Context\MySqlCommand.php'; 
    require_once 'C:\xampp\htdocs\Test\Be\Utilties\config.php'; 
    require_once 'C:\xampp\htdocs\Test\Be\Controllers\ListenerController.php';
    require_once 'C:\xampp\htdocs\Test\Be\Utilties\FileManager.php'; 
    require_once 'C:\xampp\htdocs\Test\Be\Utilties\IFileOperation.php';
    require_once 'C:\xampp\htdocs\Test\Be\Utilties\FileOperation.php';
    
    try{

        /*istanzio un oggetto di tipo FileOperation per scrivere a log che:
            * nel costruttore chiama il metodo statico istance() della classe FileManager
            * la classe FileManager è implementata come singleton quindi:
                * costruttore privato richiamato mediante il metodo statico istance()
                * il costruttore della classe FileManager:
                    * crea la cartella Log nel percorso indicato nella costante FILE_NAME definita in config.php
                    * crea il file Log.txt nella stessa cartella 
        */
        $logger = new FileOperation();

        $logger -> writelog("Start listener", Level::Information -> value);

        $sqlClient = new MySqlCommand(HOST_NAME, 
                                        USER_NAME,
                                        PASSWORD,
                                        DB_NAME,
                                        $logger);

        $repo = new TextSuggestionRepo($sqlClient,
                                        DB_NAME,
                                        TABLE_NAME,
                                        $logger);

        $controller = new ListenerController($repo, $sqlClient, $logger);

        switch($_SERVER["REQUEST_METHOD"]){
            
            case "POST":
                $controller -> getAllSuggestion($_POST["testo"]);
                break;
            default:
                throw new Exception("Nessun metodo in request");
                break;
        }

    }
    catch(Exception $ex){
        throw new Exception("Errore nella post. Mesage: " . $ex -> getMessage());
    }

?>
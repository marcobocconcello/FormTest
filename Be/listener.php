<?php

    //variable superglobale = fuori scope che contiene il body della chiamata http in metodo post del cient.
    //in questo caso sto recuperando il valore della chiave 'testo' in request 
    $testo =  $_POST["testo"];

    require_once 'C:\xampp\htdocs\FormTest\Be\Repositories\TextSuggestionRepo.php'; 
    require_once 'C:\xampp\htdocs\FormTest\Be\Context\MySqlCommand.php'; 
    require_once 'C:\xampp\htdocs\FormTest\Be\Utilties\config.php'; 
    require_once 'C:\xampp\htdocs\FormTest\Be\Controllers\ListenerController.php';
    require_once 'C:\xampp\htdocs\FormTest\Be\Utilties\FileManager.php'; 
    require_once 'C:\xampp\htdocs\FormTest\Be\Utilties\IFileOperation.php';
    require_once 'C:\xampp\htdocs\FormTest\Be\Utilties\FileOperation.php';
    require_once 'C:\xampp\htdocs\FormTest\Be\Dto\IAdapter.php';
    require_once 'C:\xampp\htdocs\FormTest\Be\Dto\Adapter.php';
    require_once 'C:\xampp\htdocs\FormTest\Be\Model\Testtable.php';
    
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

        $adapter = new Adapter($logger);

        /*
            Implementata la connessione seguendo uno pseudo Absatrct factory 
            Questo per permettere eventualmente di implementare altri provider e/o altre crud.

            dove:
              * concrete products: sono le connessioni -> MySqlConnection, MySqlCommand
              * abtract products sono i commandi -> IMySqlCommand
              * la classe factory che orchestra le istanze dei concrete product è omessa ed è inglobata direttamente nel concrete product MySqlCommand
        */
        $sqlClient = new MySqlCommand(HOST_NAME, 
                                        USER_NAME,
                                        PASSWORD,
                                        DB_NAME,
                                        $logger);

        /*
            Uso il pattern Repository in modo da separare l'accesso ai dati e quindi l'interfacciamento con il db rispetto al resto della logica
        */

        $repo = new TextSuggestionRepo($sqlClient,
                                        DB_NAME,
                                        TABLE_NAME,
                                        $logger,
                                        $adapter);

        /*
            Uso il pattern MV di una web api quindi istanzio il controller che si occupa di accedere ai dati sfruttando il repo.
        */

        $controller = new ListenerController($repo, $logger);

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
        exit;
    }

?>
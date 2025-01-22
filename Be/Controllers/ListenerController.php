<?php
     require_once 'C:\xampp\htdocs\Test\Be\Dto\Response.php'; 
     require_once 'C:\xampp\htdocs\Test\Be\Controllers\BaseController.php';

    class ListenerController extends BaseController{

        private ITextSuggestionRepo $repo;
        private MySqlCommand $command;
        private IFileOperation $logger;

        public function __construct(ITextSuggestionRepo $repo, 
                                    MySqlCommand $command,
                                    IFileOperation $logger)
        {
            $this->command = $command;
            $this->repo = $repo;
            $this->logger = $logger;
        }

        public function getAllSuggestion(string $testo){
            try{
                
                $this->logger -> writelog("Inzio mock della tabella sul controller", Level::Information -> value);

                $this -> repo -> mock_table(COLUMN_NAME);
                
                $headerArray = array();
                array_push($headerArray, 'Content-Type: application/json');

                BaseController::setResponse(200, 
                                        $this -> repo -> select_text($testo, COLUMN_NAME),
                                        $headerArray) -> toJson();

                //echo serve per visualizzare uno o più stringhe
                echo BaseController::setResponse(
                                        200, 
                                        $this -> repo -> select_text($testo, COLUMN_NAME),
                                        $headerArray) -> toJson();

            }
            catch(Exception $ex){
                    $this->logger -> writelog("Errore nel controller: $ex -> getMessage()", Level::Error -> value);
                    echo BaseController::setResponse(
                                        500, 
                                        [],
                                        $headerArray) -> toJson();
            }finally{
                $this->logger -> writelog("Chiusura della connessione", Level::Information -> value);
                $this -> command-> getMyConnection() -> get_connection() -> close();
                exit;
            }

        }
       
    }


?>
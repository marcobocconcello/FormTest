<?php
    enum Level : string{
        case Information = 'INFORMATION';
        case Warning = 'WARNING'; 
        case Error = 'ERROR'; 
    }

    class FileOperation implements IFileOperation{
        
        private FileManager $file;

        public function __construct()
        {
            $this->file = FileManager::istance();
        }
        
        public function writelog(string $text, string $level)
        {
            try{
                file_put_contents(FILE_NAME,
                                    $this -> composeMessage($text, $level),
                                    FILE_APPEND);
            }
            catch(Exception $ex){
                throw $ex;
            }
        }

        private function composeMessage(string $text, string $level) : string{
            return date('d-m-Y h:i:s', time()). " -- $level -- " . "$text" .PHP_EOL;
        }
    }

?>


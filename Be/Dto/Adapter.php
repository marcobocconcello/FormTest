<?php

    class Adapter implements IAdapter{

        private IFileOperation $logger;

        public function __construct(IFileOperation $logger)
        {
            $this->logger = $logger;
        }

        public function fromModelToDto(array $modelList) : array{
            try{

                $out = array();

                if($modelList !== null){
                    foreach($modelList as $val){
                        array_push($out, self::singleAdapter($val));
                    }
                }

                return $out;
            }
            catch(Exception $ex){
                $this->logger->writelog("Errore nell'adapter da Model a Dto: $ex -> getMessage()", Level::Error -> value);
                throw new Exception("Errore nell'adapter da Model a Dto");
            }
        }

        private static function singleAdapter(Testtable $suggested) : string{
            return $suggested -> get_possibileValue();
        }
    }

?>
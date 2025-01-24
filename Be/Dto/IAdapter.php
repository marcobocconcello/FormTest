<?php

    interface IAdapter{
        public function fromModelToDto(array $modelList) : array;
    }

?>
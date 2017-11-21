<?php

if(!class_exists('RecoverConnection')) {
    class RecoverConnection
    {
        protected function getConnection()
        {
            require_once($_SESSION['caminhoFisico'] . "/../database/config/globalFunctions.php");
        }
    }
}

<?php
/*Config global*/
require_once __DIR__ . "/../database/globalConfig.php";

/*Redirect*/
header("Location: {$global->project->home}");
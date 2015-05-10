<?php
    require_once('../private/definitions/paths-class.php');
    $paths = new Paths();    
    require_once($paths->GetControllerClassFile());
    
    $controller = new Controller($paths);
    $controller->Run();
?>
<?php
    /* El if valida que se recibieron todos los datos */
    if(isset($_POST['noparte'],$_POST['cantidad'],$_POST['fecha'],$_POST['noran'],$_POST['nolote'],$_POST['inspec'])){
        
        require "session_modules.php"; // Consultar función session_modules en archivo session_modules.php
        session_modules(); 

        require "../tasks/jsonType.php";
        require "../queries/generate_label.php"; // Consultar función generate_label en archivo generate_label.php
        
        // Se retorna la etiqueta o el error correspondiente
        exit(generate_label(null,null,trim($_POST['noparte']),trim($_POST['cantidad']),trim($_POST['fecha']),trim($_POST['noran']),trim($_POST['nolote']),trim($_POST['inspec'])));
    
    }
    // Si el if falla redirige a la página de error
    header("location:../../pages/error.html");
?>

<?php
    if(isset($_SESSION['user_name'],$_SESSION['user_role'])){
        if($_SESSION['user_role']==='user'){
            echo "<button id='btn-menu' class='btn-menu'>Menú</button>
                    <nav class='menu-main' id='menu'>
                        <a class='active' href='menu_user.php'>Inicio</a>
                        <a href='label.php'>Nueva Etiqueta</a>
                        <a href='part.php'>Nueva Parte</a>
                        <a href='lot.php'>Nuevo Lote</a>
                        <a href='../server/tasks/close_session.php'>Cerrar sesión</a>
                    </nav>";
            //exit;
        }else if($_SESSION['user_role']==='admin'){
            echo "<button id='btn-menu' class='btn-menu'>Menú</button>
                    <nav class='menu-main' id='menu'>
                        <a class='active' href='menu_admin.php'>Inicio</a>
                        <a href='label.php'>Nueva Etiqueta</a>
                        <a href='part.php'>Nueva Parte</a>
                        <a href='lot.php'>Nuevo Lote</a>
                        <a href='delete_part.php'>Eliminar Parte</a>
                        <a href='change_features_part.php'>Actualizar Parte</a>
                        <a href='change_features_lot.php'>Actualizar Lote</a>
                        <a href='equal_data.php'>Cambiar datos fijos</a>
                        <a href='new_user.php'>Nuevo Usuario</a>
                        <a href='../server/tasks/close_session.php'>Cerrar sesión</a>
                    </nav>";
            //exit;
        }
    }
    //header("location:../pages/error.html");
?>

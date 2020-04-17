<?php
//return "noparte="+noparte+"&cantidad="+cantidad+"&fecha="+fecha+"&origen="+origen+"&noran="+noran+"&nolote="+nolote;
    if(isset($_POST['noparte'],$_POST['cantidad'],$_POST['fecha'],$_POST['origen'],$_POST['noran'],$_POST['nolote'])){
        echo "Datos recibidos con éxito";
    }else{
        echo "error";
    }
?>

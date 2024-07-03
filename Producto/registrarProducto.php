<?php 

    var_dump($_POST);

    $productos = array(
        "nombre"=>$_POST["nombre"],
        "precio"=>$_POST["precio"],
        "stock"=>$_POST["stock"]
    );
    
    $handler = fopen("productos.json", "w+");
    fwrite($handler, json_encode($productos));
    fclose($handler);

?>
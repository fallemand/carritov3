<?php
    session_start();
    include_once($_SESSION["www"]."/sources/class.Bd.php");
    $bd=new Bd();
    $sql="SELECT * FROM usuarios WHERE usuario=\"%s\" AND clave=\"%s\"";
    $sql=sprintf($sql,$_POST["usuario"],md5($_POST["clave"]));
    $resultados=$bd->ejecutar($sql);
    if(mysql_num_rows($resultados)>0) {
        $_SESSION["usuario"]="admin";
        header("location:../index.php?show=admin");
    }
    else {
        header("location:../index.php?show=admin&error");
        exit();
    }
?>
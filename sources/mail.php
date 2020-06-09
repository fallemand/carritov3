<?php
session_start();
include("phpmailer/class.phpmailer.php");
include("phpmailer/class.smtp.php");
include_once($_SESSION["www"]."/sources/Funciones.php");

if(!isset($_GET["contacto"]))
    $carrito=carrito();
$nombre=$_POST["nombre"];
$telefono=$_POST["telefono"];
$email=$_POST["mail"];
$domicilio=$_POST["domicilio"];
$mensaje=$_POST["mensaje"];

$mail = new PHPMailer();
$mail->From = $email;
$mail->FromName = $nombre;
$mail->Subject = "Consulta CarritoV3";
$mail->AltBody = $mensaje;
$mail->MsgHTML("
                <b>Nombre: </b>".$nombre."<br />
                <b>Telefono: </b>".$telefono."<br />
                <b>Mail: </b>".$email."<br />
                <b>Domicilio: </b>".$domicilio."<br />
                <b>Mensaje: </b>".$mensaje."<br /><br />
                <b>Compra:</b> <br />".$carrito);
$mail->AddAddress("facualle@hotmail.com", "CarritoV3");
$mail->IsHTML(true);

if(!$mail->Send())
    echo '<br /><br /><div id="formulario"><p class="big-bold2">Error</p>'.$mail->ErrorInfo.'</div>';
else
    echo '<br /><br /><div id="formulario"><p class="big-bold2">Mensaje Enviado Correctamente!</p></div>';
?>
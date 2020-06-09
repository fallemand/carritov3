<?php
session_start();
?>
<div id="big-bold">
  <h1 class="big-bold">Finalizar Compra</h1>
  <p>Mediante el siguiente formulario podra llegarnos su pedido. A la brevedad nos comunicaremos.</p>
</div>
<div id="formulario">
    <form action="index.php?show=mail" enctype="multipart/form-data" method="post" onsubmit="
        var nombre=document.getElementById('nombre');
        var mail=document.getElementById('mail');
        var consulta=document.getElementById('consulta');
        var telefono=document.getElementById('telefono');
        var domicilio=document.getElementById('domicilio');
        var mensaje=document.getElementById('consulta');
        var regex=/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/;

        if(nombre.value=='') {
            alert('Por favor ingrese el nombre!');
            nombre.focus();
            return false;
        }
        if(telefono.value=='' && mail.value=='') {
            alert('Por favor ingrese el telefono!');
            telefono.focus();
            return false;
        }
        if(telefono.value=='' && !regex.test(mail.value)) {
            alert('Ingrese un mail valido');
            mail.focus();
            return false;
        }
        if(domicilio.value=='') {
            alert('Por favor ingrese el domicilio!');
            domicilio.focus();
            return false;
        }
    ">
        Nombre: &nbsp;<input id="nombre" name="nombre" type="text" value="" /><br /><br />
        Telefono: <input id="telefono" name="telefono" type="text" value="" /><br /><br />
        Mail: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="mail" name="mail" type="text" value="" /><br /><br />
        Domicilio: <input id="domicilio" name="domicilio" type="text" value="" /><br /><br />
        Mensaje&nbsp;<br /><textarea name="mensaje" id="mensaje" rows="3" cols="40"></textarea><br /><br />
        <input type="hidden" name="idproducto" id="idproducto" value=""/>
        <input id="submit" name="submit" type="submit">
    </form>
</div>   <br />
<?php
include("ver-carrito.php");
?>

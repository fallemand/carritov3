<div id="big-bold">
  <h1 class="big-bold">Contacto</h1>
  <p>Mediante el siguiente formulario podremos podra hacernos lelgar sus inquietudes</p>
</div>
<div id="formulario">
    <form action="index.php?show=mail&contacto" enctype="multipart/form-data" method="post" onsubmit="
        var nombre=document.getElementById('nombre');
        var mail=document.getElementById('mail');
        var mensaje=document.getElementById('mensaje');
        var regex=/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/;
        if(nombre.value=='') {
            alert('Por favor ingrese el nombre!')
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
        if(mensaje.value=='') {
            alert('Por favor ingrese un mensaje!')
            mensaje.focus();
            return false;
        }
    ">
        Nombre: &nbsp;<input id="nombre" name="nombre" type="text" value="" /><br /><br />
        Telefono: <input id="telefono" name="telefono" type="text" value="" /><br /><br />
        Mail: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="mail" name="mail" type="text" value="" /><br /><br />
        Domicilio: <input id="domicilio" name="domicilio" type="text" value="" /><br /><br />
        Mensaje<br /><textarea name="mensaje" id="mensaje" rows="10" cols="40"></textarea><br /><br />
        <input type="hidden" name="idproducto" id="idproducto" value=""/>
        <input cols=30 rows=6 id="submit" name="submit" type="submit">
    </form>
</div>

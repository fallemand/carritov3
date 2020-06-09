<?php
session_start();
include_once($_SESSION["www"]."/sources/Funciones.php");
echo '<link rel="stylesheet" type="text/css" href="/estilo.css"/>';
if($_SESSION["unidades"]!=0) {
    echo '<br />
    <table id="tablas" style="width:95%;font: 12px tahoma, sans-serif; font-weight:normal;">
        <tr>
            <th>Producto</th><th>Precio</th><th>Cant</th><th>Total</th>
        </tr>';
        for($i=0;$i<count($_SESSION["carrito"]);$i++) {
            $total+=$_SESSION["carrito"][$i]["cantidad"]*$_SESSION["carrito"][$i]["precio"];
            echo '
            <tr>
                <td>'.reemplazarCaracteres(acortar($_SESSION["carrito"][$i]["nombre"],50)).'</td>
                <td>$'.$_SESSION["carrito"][$i]["precio"].'</td>
                <td>'.$_SESSION["carrito"][$i]["cantidad"].'</td>
                <td>$'.$_SESSION["carrito"][$i]["cantidad"]*$_SESSION["carrito"][$i]["precio"].'</td>
            </tr>';
        }
        echo '
    </table>
    <span class="precio" style="margin-left:12px;"><b>Total: $'.$total.'</b></span>
    <span style="float:right; margin:5px 20px 5px 0;"><a href="index.php?show=comprar" onclick=\'
          parent.Windows.close("win2",event);
          parent.location.href = "/index.php?show=comprar";
          return false;
        \'><img src="/images/comprar.png" alt="Comprar" border=0 /></a></span>';
}
else
    echo '<div style="margin:100px 0pt 10px 220px; color:#ccc; font-size:14px"><b>El carrito esta vacio</b>';

?>
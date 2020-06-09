<?php
session_start();
include_once("sources/Funciones.php");
if(!isset($_SESSION["unidades"]))
    $_SESSION["unidades"]=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Carritov3 | Tu carrito de compras online!</title>
    <meta name="keywords" content="carrito, comercio, online, vender, compras, shop, ventas, comprar" />
    <link rel="stylesheet" type="text/css" href="estilo.css"/>
    <link href="sources/frameworks/default.css" rel="stylesheet" type="text/css"/>
    <link href="sources/frameworks/alphacube.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="sources/ajax.js"></script>
    <script type="text/javascript" src="sources/frameworks/prototype.js"></script>
    <script type="text/javascript" src="sources/frameworks/scriptaculous.js?load=effects,builder"></script>
    <script type="text/javascript" src="sources/frameworks/lightbox.js"></script>
    <script type="text/javascript" src="sources/frameworks/window.js"></script>
    <script type="text/javascript" src="sources/frameworks/window_effects.js"></script>
    <script type="text/javascript" src="sources/frameworks/effects.js"></script>
    <script>
    function win2() {
        var win = new Window({id: "win2", className: "alphacube", title: "Carrito!", url: "/paginas/ver-carrito.php", width:570, height:350, showEffectOptions: {duration:0.4}, hideEffectOptions: {duration:0.4}});
        win.setDestroyOnClose();
        win.showCenter(true);
        win.toFront();}
    </script>

  </head>
  <body>
      <div class="header">
        <div id="logo"><a href="#"  title="Carritov3 | Tu carrito de compras online!"></a></div>
        <div id="buscar">
            <form action="index.php" method="get" onsubmit="contenido('sources/productos.php?busqueda='+document.getElementById('busqueda').value,'contenido');return false;">
		        <input class="busqueda" type="text" id="busqueda" name="busqueda" value="Buscar en el Sitio!" onfocus="this.value='';" onblur="if(this.value=='') this.value='Buscar en el Sitio!'" />
		    </form>
        </div>
    </div>
    <div class="menu">
        <?php
        echo'
        <div id="botones">
		    <ul>
			    <li><a href="index.php" onclick=\'contenido("sources/productos.php","contenido");return false;\'>Home</a></li>
			    <li><a href="index.php?show=categorias" onclick=\'contenido("paginas/categorias.php","contenido");return false;\' id="current">Categorias</a></li>
                <li><a href="index.php?show=envios" onclick=\'contenido("paginas/envios.php","contenido");return false;\' id="current">Envios/Pagos</a></li>
                <li><a href="index.php?show=contacto" onclick=\'contenido("paginas/contacto.php","contenido");return false;\'>Contacto</a></li>
                <li><a href="index.php?show=admin" onclick=\'contenido("admin/index.php","contenido");return false;\'>Admin</a></li>

            </ul>
        </div>

        <div id="barra">
            <img src="/images/ver-carrito.png" alt="X" title="Cantidad Productos en el Carrito" /><span id="carrito">'.$_SESSION["unidades"].'</span> &nbsp;&nbsp;
            <img src="/images/cart.png" alt="Carrito" title="Ver Carrito" /><a style="margin-left:5px;" href="?show=ver-carrito" onclick=\'win2(); return false;\' title="Ver Carrito">Ver Carrito</a>&nbsp;&nbsp;
            <img src="/images/cart.png" alt="Carrito" /><a style="margin-left:5px;" href="index.php?show=comprar" title="Finalizar Compra">Comprar</a>';
            if($_SESSION["usuario"]=="admin")
                echo '&nbsp;&nbsp;<a href="admin/cerrar-sesion.php" title="Cerrar Sesion"><img src="/images/salir.png" alt="Salir" border=0></a>';
            ?>
        </div>
	</div>
    <div class="body">
        <div class="menulat">
             <?php
                $resultados=datosCat();
                echo '
                <div id="left">
                    <h2><span>Categorias</span></h2>
                        <ul>';
                            while($r=mysql_fetch_array($resultados))
                                echo '<li><a href="index.php?show=productos&idcategoria='.$r["idcategoria"].'" onclick=\'contenido("sources/productos.php?idcategoria='.$r["idcategoria"].'","contenido"); return false; \'>'.$r["descripcion"].'</a></li>';
                        echo '
                        </ul>
                </div>';
                $resultados=randProd(1);
                echo '
                <div id="left">
                    <h2><span>Ofertas</span></h2>
                        <ul>';
                            $r=mysql_fetch_array($resultados);
                            $imagen=glob("images/productos/".$r["idproducto"]."_*-C.*");
                                echo '
                                <li>
                                    <a href="index.php?show=ver-producto&idproducto='.$r["idproducto"].'" title="'.$r["nombre"].'" onclick=\'contenido("paginas/ver-producto.php?idproducto='.$r["idproducto"].'","contenido"); return false; \'>
                                        <span style="margin-left:10px;" class="precio"><b>$'.$r["precio"].'</b></span>
                                        <br /><div style="height:120px;"><img style="margin-bottom:5px; margin-left:10px;" src="'.$imagen[0].'" alt="imagen" border=0 /></div>
                                    </a>
                                </li>
                        </ul>
                </div>';
                unset($r);
			 ?>
        </div>
        <div id="contenido" class="contenido">
        <?php
            $show=$_GET["show"].".php";
            switch($show) {
              case "admin.php"          : $show="admin/index.php";            break;
              case "comprar.php"        : $show="paginas/comprar.php";        break;
              case "envios.php"         : $show="paginas/envios.php";         break;
              case "contacto.php"       : $show="paginas/contacto.php";       break;
              case "mail.php"           : $show="sources/mail.php";           break;
              case "categorias.php"     : $show="paginas/categorias.php";     break;
              case "ver-carrito.php"    : $show="paginas/ver-carrito.php";    break;
              case "ver-producto.php"   : $show="paginas/ver-producto.php";   break;
              case "carrito.php"        : $show="sources/carrito.php";        break;

            }
            if(file_exists($show))
                include($show);
            else
                include_once("sources/productos.php");
        ?>
        </div>
        <br clear="all" />
    </div>
    <div class="pie">
          <div id="links">
            <a href="index.php" onclick='contenido("sources/productos.php","contenido");return false;'>HOME</a> | <a href="index.php?show=categorias" onclick='contenido("paginas/categorias.php","contenido");return false;'>CATEGORIAS</a> | <a href="index.php?show=envios" onclick='contenido("paginas/envios.php","contenido");return false;'>ENVIOS/PAGOS</a> | <a href="index.php?show=contacto" onclick='contenido("paginas/contacto.php","contenido");return false;'>CONTACTO</a> | <a href="index.php?show=admin" onclick='contenido("admin/index.php","contenido");return false;'>ADMIN</a><br />
            Desarrollado por <a href="http://www.WindowsWolf.com">WindowsWolf.com&reg;</a> - Web Demo, nada de lo expresado en esta página es real.
          </div>

          <div id="wolf">
            <a href="http://es-es.facebook.com/" title="Seguinos en Facebook"><img src="/images/facebook.gif" border=0 alt="Facebook"></a>&nbsp;&nbsp;
            <a href="http://twitter.com/" title="Seguinos en Twitter"><img src="/images/twitter.gif" border=0 alt="Twitter"></a>&nbsp;&nbsp;
            <a href="http://youtube.com/" title="Seguinos en Youtube"><img src="/images/youtube.gif" border=0 alt="Youtube"></a> &nbsp;&nbsp;
            <a href="http://youtube.com/" title="RSS"><img src="/images/rss.gif" border=0 alt="RSS"></a>
          </div>
    </div>
  </body>
</html>
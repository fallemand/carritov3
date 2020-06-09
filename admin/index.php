<?php
session_start();
        if($_SESSION["usuario"]=="admin") {
          echo '
            <div id=menu-admin>
                <div id=boton-admin>
                    <a href="index.php?show=admin&m=cargar-cat" onclick=\'contenido("admin/cargar-categorias.php","contenido-admin"); return false;\' title="Editar/Agregar Categorias"><img src="/images/1.png" border=0 alt="Imagen" />Editar/Agregar Categorias</a>
                </div>
                <div id=boton-admin>
                    <a href="index.php?show=admin&m=ver-prod" onclick=\'contenido("admin/ver-productos.php","contenido-admin"); return false;\' title="Ver Productos"><img src="/images/2.png" border=0 alt="Imagen" />Ver Productos</a>
                </div>
                <div id=boton-admin>
                    <a href="index.php?show=admin&m=cargar-prod" onclick=\'contenido("admin/cargar-productos.php","contenido-admin"); return false;\' title="Agregar Productos"><img src="/images/3.png" border=0 alt="Imagen" />Agregar Productos</a>
                </div>
                <div id=boton-admin>
                    <a href="index.php?show=admin&m=listado-prod" onclick=\'contenido("admin/lista-productos.php","contenido-admin"); return false;\' title="Listado Productos"><img src="/images/4.png" border=0 alt="Imagen" />Listado Productos</a>
                </div>
            </div>';

        }
        else
            echo '';
        echo '<div id=contenido-admin>';
            switch($_GET["m"]) {
                case "cargar-cat"   :   if(file_exists($_SESSION["www"]."/admin/cargar-categorias.php"))    include($_SESSION["www"]."/admin/cargar-categorias.php"); break;
                case "ver-prod"     :   if(file_exists($_SESSION["www"]."/admin/ver-productos.php"))        include($_SESSION["www"]."/admin/ver-productos.php"); break;
                case "cargar-prod"  :   if(file_exists($_SESSION["www"]."/admin/cargar-productos.php"))     include($_SESSION["www"]."/admin/cargar-productos.php"); break;
                case "listado-prod" :   if(file_exists($_SESSION["www"]."/admin/lista-productos.php"))      include($_SESSION["www"]."/admin/lista-productos.php"); break;
                default :
                if($_SESSION["usuario"]!="admin") {
                    echo '<br /><br />
                    <div id="formulario">
                        <b><p class="big-bold2">Debe loguearse para acceder!</p>';
                           if(isset($_GET["error"]))
                              echo '<p style="color:#bd0000">Usuario o contraseña incorrecta!</p><br />';
                        echo '</b>
        	            <form id="loginbox" action="admin/validar.php" method="post">
			                <div id="username">
				    	        <input id="usrnme" name="usuario" type="text" onfocus="if(this.value==\'usuario\')value=\'\';" onblur="if(this.value==\'\')value=\'usuario\';" value="usuario" />
			    	        </div>
			    	        <div id="password">
				    	        <input id="psswrd" name="clave" type="password" onfocus="if(this.value==\'password\')value=\'\';" onblur="if(this.value==\'\')value=\'password\';" value="password" />
			    	        </div>
                            <div id="loginbutton">
                                <input id="loginbutton" type="submit" value="" name="submit" />
                            </div>
			            </form>
                    </div>';
                }
            }
        echo '</div>';
        ?>
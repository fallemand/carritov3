<?php
    session_start();
    include_once($_SESSION["www"]."/sources/Funciones.php");
    $bd=new Bd();
    define("REGISTROS",8);
    $pag=(isset($_GET["pag"]))?($_GET["pag"]):1;
    $inicio=0;
    if($pag>1)
        $inicio=($pag - 1) * REGISTROS;

    $sql="SELECT * FROM productos ";

    if(isset($_GET["busqueda"]))
      $sql.="WHERE nombre LIKE '%{$_GET["busqueda"]}%' OR descripcion LIKE '%{$_GET["busqueda"]}%'";
    elseif(isset($_GET["idcategoria"]))
      $sql.="WHERE idcategoria={$_GET["idcategoria"]}";
    elseif(!isset($_GET["pag"]))
      $sql.="ORDER BY RAND()";

    $resultados=$bd->ejecutar($sql);
    $total=mysql_num_rows($resultados);
    //Si se encontraron coincidencias!
    if($total>0) {
        $paginas=ceil($total/REGISTROS);
        for($i=$inicio;$i<min($inicio+REGISTROS,$total);$i++) {
            mysql_data_seek($resultados,$i);
            $r=mysql_fetch_array($resultados);
            $imagenes=glob($_SESSION["www"]."/images/productos/{$r["idproducto"]}_*-C.*");
            $imagenes[0]=str_replace($_SESSION["www"],"",$imagenes[0]);
            echo reemplazarCaracteres('
            <div id="producto">
                <table>
                    <tr>
                        <td id="grande">'.acortar($r["nombre"],42).'</td>
                    </tr>
                    <tr>
                        <td class="precio">$'.$r["precio"].'</td>
                    </tr>
                    <tr>
                        <td><table>
        	                <tr>
          		                <td class="border"> <a href="index.php?show=ver-producto&idproducto='.$r["idproducto"].'" onclick=\'contenido("paginas/ver-producto.php?idproducto='.$r["idproducto"].'", "contenido"); return false;\' ><img src="'.$imagenes[0].'" border=0 alt="producto"></a></td>
        	                </tr>
    	                    </table>
                        </td>
                    </tr>
                    <tr>
                        <td><table>
                            <tr><td><img src="/images/cart_add.png" /> <a href="/index.php?show=carrito&idproducto='.$r["idproducto"].'" onclick=\'carrito("sources/carrito.php?idproducto='.$r["idproducto"].'","carrito");return false;\'>Añadir carrito</a></td></tr>
                            <tr><td><img src="/images/zoom.png" /> <a href="index.php?show=ver-producto&idproducto='.$r["idproducto"].'" onclick=\'contenido("paginas/ver-producto.php?idproducto='.$r["idproducto"].'", "contenido"); return false;\' >Ver producto</a></td></tr>
                        </table></td>
                    </tr>
                </table>
            </div>');
        }
        if(isset($_GET["idcategoria"])) {
            echo '<div style="background-color:#cacaca; padding:2px 4px 2px 8px; position:absolute; bottom: 15px; text-align:center;margin-left:250px; color:#045fb4"><b>Pag: </b>';
            for($i=1;$i<=$paginas;$i++) {
                if($i==$pag)
                    echo '<a style="font-size:16px;font-weight:bold;margin:5px;color:#bc0000" href="index.php?pag='.$i.'&idcategoria='.$_GET["idcategoria"].'" onclick=\'contenido("sources/productos.php?pag='.$i.'&idcategoria='.$_GET["idcategoria"].'","contenido");return false;\'>'.$i.'</a>';
                else
                    echo '<a style="font-size:14px;font-weight:bold;margin:5px;" href="index.php?pag='.$i.'&idcategoria='.$_GET["idcategoria"].'" onclick=\'contenido("sources/productos.php?pag='.$i.'&idcategoria='.$_GET["idcategoria"].'","contenido");return false;\'>'.$i.'</a>';
            }
            echo "</div>";
        }
        elseif(isset($_GET["busqueda"])) {
            echo '<div style="background-color:#cacaca; padding:2px 4px 2px 8px; position:absolute; bottom: 15px; text-align:center;margin-left:250px; color:#045fb4"><b>Pag: </b>';
            for($i=1;$i<=$paginas;$i++) {
                if($i==$pag)
                    echo '<a style="font-size:16px;font-weight:bold;margin:5px;color:#bc0000" href="index.php?pag='.$i.'&busqueda='.$_GET["busqueda"].'" onclick=\'contenido("sources/productos.php?pag='.$i.'&busqueda='.$_GET["busqueda"].'","contenido");return false;\'>'.$i.'</a>';
                else
                    echo '<a style="font-size:14px;font-weight:bold;margin:5px;" href="index.php?pag='.$i.'&busqueda='.$_GET["busqueda"].'" onclick=\'contenido("sources/productos.php?pag='.$i.'&busqueda='.$_GET["busqueda"].'","contenido");return false;\'>'.$i.'</a>';
            }
            echo '</div>';
        }

    }
    //No se encontraron coincidencias!
    else
        echo '<br /><br /><div id="formulario"><p class="big-bold2">No se encontraron resultados!</p></div>';
    mysql_free_result($resultados); //-> Libero las variables.
    $bd->__destruct();
?>
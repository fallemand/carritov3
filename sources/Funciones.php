<?php
    //Configuraciones
    $_SESSION["www"]=realpath($_SERVER['DOCUMENT_ROOT']);
    include_once($_SESSION["www"]."/sources/class.Bd.php");

    //Funciones
    function comboCat($id=0) {
        $bd=new Bd();
        $sql="SELECT * FROM categorias";
        $resultado=$bd->ejecutar($sql);
        while($r=$bd->retornarFila($resultado)) {
            $a="";
            if($r["idcategoria"]==$id)
                $a=" selected";
            $combo=$combo.'<option value='.$r["idcategoria"].''.$a.'>'.$r["descripcion"].'</option>';
        }
        $bd->__destruct();
        return $combo;
    }

    function comboProd($id=0) {
        $bd=new Bd();
        $sql="SELECT * FROM productos";
        $resultado=$bd->ejecutar($sql);
        while($r=$bd->retornarFila($resultado))
        {
            $a="";
            if($r["idproducto"]==$id)
                $a=" selected";
            $combo=$combo.'<option value='.$r["idproducto"].''.$a.'>'.$r["nombre"].'</option>';
        }
        $bd->__destruct();
        return $combo;
    }

    function datosProdyCat($idproducto=0,$idcategoria=0) {
        $bd=new Bd();
        $sql="SELECT p.nombre, p.stock, p.precio, p.idproducto, p.idcategoria, p.descripcion, c.descripcion AS categoria FROM productos p INNER JOIN categorias c ON p.idcategoria=c.idcategoria ";
        if($idproducto>0) {
          $sql.="WHERE p.idproducto=%d ORDER BY p.idproducto";
          $sql=sprintf($sql, $idproducto);
        }
        elseif($idcategoria>0) {
          $sql.="WHERE c.idcategoria=%d ORDER BY p.idproducto";
          $sql=sprintf($sql, $idcategoria);
        }
        $resultado=$bd->ejecutar($sql);
        $bd->__destruct();
        return $resultado;
    }

    function randProd($cant) {
      $bd=new Bd();
      $sql="SELECT p.nombre, p.precio, p.stock, p.descripcion, p.idcategoria, p.idproducto, c.descripcion AS categoria, c.idcategoria FROM productos p LEFT JOIN categorias c ON p.idcategoria=c.idcategoria ORDER BY RAND() LIMIT %d";
      $sql=sprintf($sql,$cant);
      $resultados=$bd->ejecutar($sql);
      $bd->__destruct();
      return $resultados;
    }

    function datosCat() {
      $bd=new Bd();
      $sql="SELECT * FROM categorias";
      $resultados=$bd->ejecutar($sql);
      $bd->__destruct();
      return $resultados;
    }

    function acortar($texto,$caracteres) {
        if (strlen($texto) > $caracteres)
            $z=substr($texto,0,$caracteres).'...';
        else
            $z=$texto;
        return $z;
    }

    function reemplazarCaracteres($cadena) {
      $cadena=htmlentities($cadena,ENT_NOQUOTES,"ISO-8859-1");
      $cadena=htmlspecialchars_decode($cadena,ENT_NOQUOTES);
      return $cadena;
    }

    function crearImagenes($id) {
      $imagenes=glob($_SESSION["www"]."/images/productos/temp/{$id}-*.*");
      for($x=0;$x<count($imagenes);$x++) {
        $archivo=$imagenes[$x];
        $extension=pathinfo($archivo);
        switch(strtolower($extension["extension"])) {
            case 'gif' : @$origen=imagecreatefromgif($archivo);break;  //Si por algun motivo no la pudo crear, apago el error.
            case 'png' : @$origen=imagecreatefrompng($archivo);break;
            default    : @$origen=imagecreatefromjpeg($archivo);break;
        }
        if($origen) {
            $ancho_origen=imagesx($origen);
            $alto_origen=imagesy($origen);
            $ancho=$ancho_origen;
            $alto=$alto_origen;
            if($ancho_origen>$alto_origen) {
            for($i=0;$i<3;$i++) {
                switch($i) {
                    case 0: if($ancho_origen>100) $ancho=100; else $ancho=$ancho_origen; $sufijo='C'; break;
                    case 1: if($ancho_origen>200) $ancho=200; else $ancho=$ancho_origen; $sufijo='M'; break;
                    case 2: if($ancho_origen>600) $ancho=600; else $ancho=$ancho_origen; $sufijo='G'; break;
                }
                $alto=($alto_origen*$ancho)/$ancho_origen;
                $destino=imagecreatetruecolor($ancho, $alto);
                imagecopyresampled($destino,$origen,0,0,0,0,$ancho,$alto,$ancho_origen,$alto_origen); //1-lienzo destino 2-imagen origen 3-4-5-6-crop imagen(cortar) 7-Alto imagen destino 8-ancho imagen destino 9-alto imagen origen 10-alto imagen origen
                imagejpeg($destino,$_SESSION["www"]."/images/productos/{$id}_{$x}-{$sufijo}.jpg");
                imagedestroy($destino);
            }
            }
            else
            for($i=0;$i<3;$i++) {
                switch($i) {
                    case 0: if($alto_origen>100) $alto=100; else $alto=$alto_origen; $sufijo='C'; break;
                    case 1: if($alto_origen>200) $alto=200; else $alto=$alto_origen; $sufijo='M'; break;
                    case 2: if($alto_origen>600) $alto=600; else $alto=$alto_origen; $sufijo='G'; break;
                }
                $ancho=($ancho_origen*$alto)/$alto_origen;
                $destino=imagecreatetruecolor($ancho, $alto);
                imagecopyresampled($destino,$origen,0,0,0,0,$ancho,$alto,$ancho_origen,$alto_origen); //1-lienzo destino 2-imagen origen 3-4-5-6-crop imagen(cortar) 7-Alto imagen destino 8-ancho imagen destino 9-alto imagen origen 10-alto imagen origen
                imagejpeg($destino,$_SESSION["www"]."/images/productos/{$id}_{$x}-{$sufijo}.jpg");
                imagedestroy($destino);

            }
            imagedestroy($origen);
        }

        @unlink($imagenes[$x]);
      }
    }

    function crearImagenCat($id) {
        $archivo=glob($_SESSION["www"]."/images/categorias/temp/{$id}.*");
        $extension=pathinfo($archivo[0]);
        switch(strtolower($extension["extension"])) {
            case 'gif' : @$origen=imagecreatefromgif($archivo[0]);break;  //Si por algun motivo no la pudo crear, apago el error.
            case 'png' : @$origen=imagecreatefrompng($archivo[0]);break;
            default    : @$origen=imagecreatefromjpeg($archivo[0]);break;
        }
        if($origen) {
            $ancho_origen=imagesx($origen);
            $alto_origen=imagesy($origen);
            $ancho=$ancho_origen;
            $alto=$alto_origen;
            if($ancho_origen>$alto_origen) {
                if($ancho_origen>50) $ancho=50; else $ancho=$ancho_origen;
                    $alto=($alto_origen*$ancho)/$ancho_origen;
            }
            else {
                if($alto_origen>50) $alto=50; else $alto=$alto_origen;
                    $ancho=($ancho_origen*$alto)/$alto_origen;
            }
            $destino=imagecreatetruecolor($ancho, $alto);
            imagecopyresampled($destino,$origen,0,0,0,0,$ancho,$alto,$ancho_origen,$alto_origen); //1-lienzo destino 2-imagen origen 3-4-5-6-crop imagen(cortar) 7-Alto imagen destino 8-ancho imagen destino 9-alto imagen origen 10-alto imagen origen
            imagejpeg($destino,$_SESSION["www"]."/images/categorias/{$id}.jpg");
            imagedestroy($destino);
            imagedestroy($origen);
        }
        @unlink($archivo[0]);
    }

    function carrito() {
        $carrito.='<table style="font: 12px tahoma, sans-serif; font-weight:normal; border:1px solid #222;">
        <tr>
            <th>Producto</th><th>Precio</th><th>Cant</th><th>Total</th>
        </tr>';
        for($i=0;$i<count($_SESSION["carrito"]);$i++) {
            $total+=$_SESSION["carrito"][$i]["cantidad"]*$_SESSION["carrito"][$i]["precio"];
            $carrito.='
            <tr>
                <td>'.$_SESSION["carrito"][$i]["nombre"].'</td>
                <td>$'.$_SESSION["carrito"][$i]["precio"].'</td>
                <td>'.$_SESSION["carrito"][$i]["cantidad"].'</td>
                <td>$'.$_SESSION["carrito"][$i]["cantidad"]*$_SESSION["carrito"][$i]["precio"].'</td>
            </tr>';
        }
        $carrito.='
        </table>
        <span style=\"margin-left:12px;\"><b>Total: $'.$total.'</b></span>';
        return $carrito;
    }
?>
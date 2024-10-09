<?php
$lenguajes_cliente= array(
                    "primeros"=>"javascrip","segundo"=>2,"Tercero"=>3);
$lenguajes_servidor=array("Cuarto"=>4,"Quiento"=>5,"Sexto"=>6);
$nuevo=array(array(),array());
$cont=0;

        $nuevo=array_merge($lenguajes_cliente,$lenguajes_servidor);
echo "<table>";

foreach ($nuevo as $raza => $nombre) {
    
    echo "<tr>";
    echo " <th> $raza</th>";
    echo "</tr>";
    echo "<tr>";
    echo " <td> $nombre</td>";
    echo "</tr>";

    }
    echo "</table>";

?>
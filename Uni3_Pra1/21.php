<?php
$numeros=array("Primer"=>3,"Segundo"=>2,"Tercer"=>8,"Cuarto"=>123,"Quinto"=>5,"Sexto"=>1);
array_multisort($numeros);
echo "<table>";
foreach ($numeros as $raza => $nombre) {
    
    echo "<tr>";
    echo " <th> $raza</th>";
    echo "</tr>";
    echo "<tr>";
    echo " <td> $nombre</td>";
    echo "</tr>";

    }
    echo "</table>";
?>
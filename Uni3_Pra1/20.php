<?php
$estadios_futbol = array("Barcelona" => "Camp Nou", "Real Madrid" => "Santiago Bernabeu", "Valencia" => "Mestalla", "Real Sociedad" => "Anoeta");
echo "<table>";
foreach ($estadios_futbol as $estadio => $nombre) {
    
    echo "<tr>";
    echo " <th> $estadio</th>";
    echo "</tr>";
    echo "<tr>";
    echo " <td> $nombre</td>";
    echo "</tr>";

    }
    echo "</table>";
  unset($estadios_futbol["Real Madrid"]);
    foreach ($estadios_futbol as $estadio => $nombre) {

    

echo "<tr>";
echo " <th> $estadio</th>";
echo "</tr>";
echo "<tr>";
echo " <td> $nombre</td>";
echo "</tr>";
    }
    
?>
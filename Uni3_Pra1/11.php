<?php
$meses= array("Enero"=>9,"Febrero"=>12
,"Marzo"=>0,"Abril"=>17);

    
    foreach ($meses as $mes => $nombre) {
        if($nombre==0){
        echo "  $mes => $nombre\n";
        echo "<br>";
    }
        
    }
?>
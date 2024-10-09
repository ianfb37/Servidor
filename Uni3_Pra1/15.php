<?php
$nombres=array("Pedro","Ismael","Sonia","Clara","Susana","Alfonso","Teresa");
$cont=0;
echo "<ul>";
for($i=0;$i<count($nombres);$i++){
echo "<li>";
echo $nombres[$i];
$cont++;
}
echo"</ul>";
echo "Hay $cont nombres";


?>
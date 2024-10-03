<?php
$a=1;
$b=4;
$c=3;
$sol1=0;

$sol1=($b**2)-(4*$a*$c);
if($sol1<0){
echo "No hay soluciones";
}
else{
if($sol1==0){
echo -$b/(2*$a);
}
else{
echo $sol1=(-$b+sqrt($b**2-(4*$a*$c)))/(2*$a);
echo "<br>";
echo $sol1=(-$b-sqrt($b**2-(4*$a*$c)))/(2*$a);

}

}

?>
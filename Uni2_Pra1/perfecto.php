<?php
 $num=rand(1, 20);
 $resul=0;
 $resulsuma=0;
 $i=0;
 for($i=$num;$i>=1;$i--){
    
    if(($num%$i)==0){
        $resul=$i;
        $resulsuma=$resul+$resulsuma;
        
    }
  
 }

 if($resulsuma==$num){
    echo "El numero $num es perfecto";
 }
 else
 echo "El numero $num no es perfecto";
?>
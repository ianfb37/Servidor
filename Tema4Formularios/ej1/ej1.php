<?php
if(isset($_POST['Enviar'])){
    switch($_POST){
case 'Menos de 14 años':
    echo "Eres una personita";
    echo "<br>";
break;
case '1':
        echo "Todavía eres muy joven";
        echo "<br>";
break;
case '2':
                echo "Eres una persona joven";
                echo "<br>";
break;
case   '3':
             echo "Eres una persona madura";
            echo "<br>";
break;
case '4':
       echo "Ya eres una persona mayor";
       echo "<br>";
    break;
    default:
    echo"No se";
        } 
}    
?>
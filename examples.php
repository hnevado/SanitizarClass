<?php 
session_start();
/**  
 * Ejecuta php examples.php en el terminal para ver los ejemplos o abre un navegador web 
*/

require ('src/Sanitizar.php');

use App\Sanitizar;
$sanitizar = new Sanitizar();


/** 
     * limpiarString() sanitiza un string
     * OUTPUT:
     * Quita los elementos HTML y escapa las comillas: \'Hola,qué tal?\'
     * Escapa las comillas pero mantiene los elementos HTML: \'Hola,<p>qué tal?</p>\'
     * Elimina los elementos HTML pero mantiene las comillas: 'Hola,qué tal?'
**/

echo "----- Función limpiarString() -------- \n\n";

    echo "Quita los elementos HTML y escapa las comillas:\n";
    echo $sanitizar->limpiarString("'Hola,<p>qué tal?</p>'");
    echo "\n\n";
        
    echo "Escapa las comillas pero mantiene los elementos HTML:\n";
    echo $sanitizar->limpiarString("'Hola,<p>qué tal?</p>'",strip_tags:false);
    echo "\n\n";
        
    echo "Elimina los elementos HTML pero mantiene las comillas:\n";
    echo $sanitizar->limpiarString("'Hola,<p>qué tal?</p>'",addslashes:false);
    echo "\n\n";

echo "\n----- Fin función limpiarString() -------- \n\n";

/** 
     * Fin pruebas limpiarString()
**/






/** 
     * listaNegra() sustituye palabras de un string por espacios en blanco
     * OUTPUT:
     * Sustituye todas las palabras definidas en listaNegra: id
     * Descartamos elementos para que no los tenga en cuenta: GROUP BY id
**/

echo "----- Función listaNegra() -------- \n\n";

    echo "Sustituye todas las palabras definidas en listaNegra:\n";
    echo $sanitizar->listaNegra("GROUP BY id");
    echo "\n\n";

    echo "Descartamos elementos para que no los tenga en cuenta:\n";
    echo $sanitizar->listaNegra("GROUP BY id",['GROUP BY']);
    echo "\n\n";


echo "\n----- Fin función listaNegra() -------- \n\n";

/** 
* Fin pruebas listaNegra()
**/



/** 
     * limpiarEntero() sanitiza un entero
     * OUTPUT:
     * Pasamos un entero negativo y decimos que solo queremos positivos 
     * False. No es positivo.
     * Paso otro entero negativo con onlyPositive a false (valor por defecto)
     * -5
**/

echo "----- Función limpiarEntero() -------- \n\n";

     echo "Pasamos un entero negativo y decimos que solo queremos positivos \n";
     if (!$sanitizar->limpiarEntero(-5,true))
     echo "False. No es positivo.\n";

     echo "Paso otro entero negativo con onlyPositive a false (valor por defecto)\n";

     echo $sanitizar->limpiarEntero(-5)."\n \n";

echo "----- Fin función limpiarEntero() -------- \n\n";


/** 
* Fin pruebas limpiarEntero()
**/


/** 
     * comprobarExtension() comprueba extensión de un string
     * OUTPUT:
     * Extensión correcta para test_image.jpg
     * Extensión incorrecta para test_image.jpg, se esperaba un pdf
**/

echo "----- Función comprobarExtension() -------- \n\n";

     if ($sanitizar->comprobarExtension("test_image.jpg", "jpg, jpeg, png"))
      echo "Extensión correcta para test_image.jpg \n";

     if (!$sanitizar->comprobarExtension("test_image.jpg", "pdf"))
      echo "Extensión incorrecta para test_image.jpg, se esperaba un pdf";

echo "\n \n ----- Fin función comprobarExtension() -------- \n\n";

/** 
* Fin pruebas comprobarExtension()
**/


/** 
     * pathTraversal() evita el ataque que afecta al sistema de archivos
     * OUTPUT:
     * Fichero sanitizado
**/

echo "----- Función pathTraversal() -------- \n\n";

$fichero='..\..\etc\passwd';
echo "Fichero sin sanitizar: ".$fichero."\n";

if (!$sanitizar->pathTraversal($fichero))
 echo "El fichero NO existe o no tienes permisos. No se ha podido sanitizar";
else 
 echo "Fichero sanitizado: ".$sanitizar->pathTraversal($fichero);

echo "\n \n ----- Fin función pathTraversal() -------- \n\n";

/** 
* Fin pruebas pathTraversal()
**/

/** 
     * csrf() evita el ataque que afecta al sistema de archivos.
     * Se crea un token CSRF único en forma de cadena hexadecimal y se asocia a la sesión del usuario
     * Para luego poder comparar si el token que está en $_SESSION["csrf_token"] es igual al del formulario
     * OUTPUT:
     * Token csrf
**/
echo "---------- Función csrf() ---------- \n\n";

$csrf=$sanitizar->csrf();

echo "Valor de csrf ".$csrf."\n";
echo "Valor de la sesión después de llamar a la función csrf:".$_SESSION["csrf_token"]."\n\n";

?>
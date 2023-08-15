<?php 

class Sanitizar {
    

    /** 
     * limpiarString() sanitiza un string
     * Esta función admite 3 parámetros:
     * $variable (obligatoria) que es la cadena a limpiar
     * $strip_tags para indicar si quieres usar la función strip_tags (true por defecto)
     * $addslashes para indicar si quieres usar la función addslashes junto a strip_tags (true por defecto)
     * Ejemplo de uso: limpiarString("'Hola,<p>qué tal?</p>'");
     * Esto devolvería: \'Hola,qué tal?\'
    */
    public function limpiarString(string $variable, 
                                  bool $strip_tags = true, 
                                  bool $addslashes = true) : string
    {

        if ($strip_tags && $addslashes)
          return strip_tags(addslashes($variable));

        if ($strip_tags)
          return strip_tags($variable);

        
        return addslashes($variable);

     
    }


    /** 
     * listaNegra() elimina palabras de un string que pueden ser utilizadas para hacer SQL injection
     * Esta función admite dos parámetros:
     * $variable (obligatoria) que es la cadena a limpiar
     * $descartar (opcional) que es un array al que le puedes pasar elementos para que no los tenga en cuenta
     * Ejemplo de uso: listaNegra("CONCATENOS", ['CONCAT','password']); 
     * Devuelve el string sustituyendo las ocurrencias encontradas del array $very_bad por espacios en blanco
    */

    public function listaNegra(string $variable, array $descartar = null) : string
    {

        $very_bad = array("CONCAT","concat","password","PASSWORD","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","truncate","update","insert","drop","select","DELETE","TRUNCATE","UPDATE","INSERT","DROP","SELECT","(","\x00","\x1a","\'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","\r","\n","%0a","%0d",";","=","$","%","<",">","script","@","*","[","]","{","}","^","html","url","lyubovnaya");

        if (!is_null($descartar) && is_array($descartar))
        {
            $very_bad = array_diff($very_bad, $descartar);
            array_values($very_bad);
        }
       
        return str_replace($very_bad,' ',$variable);


    }

    /** 
     * limpiarEntero() sanitiza un entero, eliminando todos los caracteres excepto dígitos 
     * Esta función admite dos parámetros:
     * $variable (obligatoria) que es el entero a comprobar
     * $onlyPositive (opcional) que es un booleano para indicar si quieres solo números positivos
     * Ejemplo de uso: limpiarEntero(-5, true); 
     * Devuelve el entero sanitizado o false en caso de que le hayas marcado onlyPositive como true y 
     * el número sea negativo
    */

    public function limpiarEntero(int $variable, bool $onlyPositive = false) : bool | string
    {

        
        $variable=filter_var($variable,FILTER_SANITIZE_NUMBER_INT);

        if ($onlyPositive)
        {
           if ($variable >= 0)
            return $variable;
           else 
            return false;
        }

        return $variable;
    }



    /** 
     * comprobarExtension() comprueba la extensión de un string que se le pasa
     * Esta función admite dos parámetros:
     * $url (obligatoria) que es la cadena de texto a comprobar
     * $allowed (obligatoria) que son las extensiones permitidas separadas por ,
     * Ejemplo de uso: comprobarExtension("test_image.jpg", "jpg, jpeg, png"); 
     * Devuelve true si la extensión es correcta y false si no lo es
    */

    public function comprobarExtension(string $url, string $allowed) : bool
    {

        $allowed_extensions = explode(",",$allowed);
        $ext = pathinfo($url, PATHINFO_EXTENSION);

        if (!in_array($ext, $allowed_extensions)) {
            return false;
        }

        return true;


    }



  } //fin clase 

?>
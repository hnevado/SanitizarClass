<?php
namespace App\Test;
use App\Sanitizar;

use PHPUnit\Framework\TestCase;

class SanitizarTest extends TestCase {



    public static function posiblesStrings():array 
    {


        return [
            ["\'Hola,qué tal?\'","'Hola,<p>qué tal?</p>'",true,true],
            ["\'Hola,<p>qué tal?</p>\'","'Hola,<p>qué tal?</p>'",false,true],
            ["'Hola,qué tal?'","'Hola,<p>qué tal?</p>'",true,false],
        ];

    }

    /** 
     * @dataProvider posiblesStrings
     */

    public function testLimpiaString($resultadoEsperado, $cadena, $strip_tags, $addslashes) {


        $sanitizar = new Sanitizar();

        $this->assertEquals($resultadoEsperado, 
                            $sanitizar->limpiarString($cadena,strip_tags:$strip_tags,addslashes:$addslashes));

    }

    

    public function testListaNegra() {

        $sanitizar = new Sanitizar();

        $this->assertEquals('  id',$sanitizar->listaNegra("GROUP BY id"));

    }


    public static function posiblesEnteros():array 
    {

        return [
            [false,-5,true],
            [-5, -5, false],
            [5, 5, true]
        ];
    }

    /**
     * @dataProvider posiblesEnteros
     */
    
     public function testLimpiarEntero($resultadoEsperado, $entero, $soloPositivo)
     {

        $sanitizar = new Sanitizar();

        $this->assertEquals($resultadoEsperado,$sanitizar->limpiarEntero($entero,$soloPositivo));

     }

     public function testComprobarExtension()
     {

        $sanitizar = new Sanitizar();

        $this->assertEquals(true,$sanitizar->comprobarExtension("test_image.jpg", "jpg, jpeg, png"));

     }

     public function testComprobarMimeContentType()
     {

        $sanitizar = new Sanitizar();

        $this->assertEquals(true,$sanitizar->comprobarMimeContentType("test_image.jpg", "image/gif,image/jpeg"));

     }

     public function testComprobarPathTraversal()
     {

        $sanitizar = new Sanitizar();

        $this->assertEquals(false,$sanitizar->pathTraversal("..\..\etc\passwd"));

     }

     public function testComprobarCsrfIguales()
     {

        $sanitizar = new Sanitizar();

        $csrfToken1 = $sanitizar->csrf();
        $csrfToken2 = $sanitizar->csrf();

        // Verificar que la función devuelve el mismo token CSRF
        $this->assertEquals($csrfToken1, $csrfToken2);

     }

     public function testComprobarStringCsrf()
     {

        //Compruebo que la función csrf me devuelve un string, que es lo que espero.
        
        $sanitizar = new Sanitizar();

        $csrfToken = $sanitizar->csrf();

        $this->assertIsString($csrfToken);

     }

}
?>
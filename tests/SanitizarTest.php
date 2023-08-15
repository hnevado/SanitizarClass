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


}
?>
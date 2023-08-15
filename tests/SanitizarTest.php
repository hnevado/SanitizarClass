<?php
namespace App\Test;
use App\Sanitizar;

use PHPUnit\Framework\TestCase;

class SanitizarTest extends TestCase {

    public function testLimpiaString() {


        $sanitizar = new Sanitizar();

        $this->assertEquals("\'Hola,qué tal?\'", $sanitizar->limpiarString("'Hola,<p>qué tal?</p>'"));

    }

}
?>
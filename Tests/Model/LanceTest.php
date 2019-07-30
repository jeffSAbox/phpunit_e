<?php

namespace PhpUnitEstudo\Tests\Model;

use PHPUnit\Framework\TestCase;
use PhpUnitEstudo\Leilao\Model\Leilao;
use PhpUnitEstudo\Leilao\Model\Lance;
use PhpUnitEstudo\Leilao\Model\Usuario;

class LanceTest extends TestCase
{

    /**
     * @dataProvider geraLances
     */
    public function testVerificaRepeticaoDeLanceDoMesmoUsuario(Leilao $leilao, int $qtd)
    {
        self::assertCount($qtd, $leilao->getLances());

        $ultimoLance = new Lance(new Usuario("Variavel Inicial"), 0);
        foreach( $leilao->getLances() as $i => $lance ){
            if($ultimoLance->getUsuario() == $lance->getUsuario() ) {
                self::assertTrue("Existe lances em sequencia da mesma pessoa/usuário");
            }
            $ultimoLance = $lance;
        }
    }

    public function geraLances()
    {
        $joao = new Usuario('João');
        $maria = new Usuario("Maria");

        $leilao = new Leilao("FIAT 147 0KM");
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($joao, 5000));

        $leilao2 = new Leilao("FUSCA 1980 0KM");
        $leilao2->recebeLance(new Lance($joao, 1000));
        $leilao2->recebeLance(new Lance($maria, 2000));
        $leilao2->recebeLance(new Lance($joao, 5000));
        $leilao2->recebeLance(new Lance($joao, 6000));
        $leilao2->recebeLance(new Lance($maria, 6000));
        $leilao2->recebeLance(new Lance($maria, 15000));

        return [
         "LancesEmOrdem" => [$leilao, 3],
         "LancesRepetidosSequencia" => [$leilao2, 4]
        ];
    }

}

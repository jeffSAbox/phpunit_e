<?php

namespace PhpUnitEstudo\Leilao\Tests\Service;

use PhpUnitEstudo\Leilao\Model\Lance;
use PhpUnitEstudo\Leilao\Model\Leilao;
use PhpUnitEstudo\Leilao\Model\Usuario;
use PhpUnitEstudo\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

    private $leiloeiro;

    protected function setUp(): void{
        $this->leiloeiro = new Avaliador();
    }

    /**
    * @dataProvider leilaoEmOrdemAleatoria
    */
    public function testAvaliadorDeveEncontrarOMaiorValor(Leilao $leilao)
    {

        // Act - When
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(3500, $maiorValor);
    }

    /**
    * @dataProvider leilaoEmOrdemAleatoria
    */
    public function testAvaliadorDeveEncontrarOMenorValor(Leilao $leilao)
    {

        // Act - When
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(1000, $menorValor);
    }

    /**
    *   @dataProvider leilaoEmOrdemAleatoria 
    */
    public function testAvaliadorDeveBuscarOs3MaioresLances(Leilao $leilao)
    {        

        $this->leiloeiro->avalia($leilao);

        $maioresLances3 = $this->leiloeiro->getMaioresLances();

        self::assertCount(3, $maioresLances3);
        self::assertEquals(3500, $maioresLances3[0]->getValor());
        self::assertEquals(2550, $maioresLances3[1]->getValor());
        self::assertEquals(1600, $maioresLances3[2]->getValor());   

    }

    public function leilaoEmOrdemAleatoria(): array
    {
        $leilao     = new Leilao("FIAT 147 0KM");
        $joao       = new Usuario("João");
        $ana        = new Usuario("Ana");
        $carlos     = new Usuario("Carlos");
        $amanda     = new Usuario("Amanda");
        $jessica    = new Usuario("Jessica");

        $leilao->recebeLance(new Lance($joao, 1600));
        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($carlos, 3500));
        $leilao->recebeLance(new Lance($amanda, 2550));
        $leilao->recebeLance(new Lance($jessica, 1450));

        $leilao->lancesRand();

        return [[$leilao]];

    }

}

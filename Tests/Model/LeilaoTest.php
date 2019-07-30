<?php

namespace PhpUnitEstudo\Tests\Model;

use PHPUnit\Framework\TestCase;
use PhpUnitEstudo\Leilao\Model\Usuario;
use PhpUnitEstudo\Leilao\Model\Leilao;
use PhpUnitEstudo\Leilao\Model\Lance;
use PhpUnitEstudo\Leilao\Service\Avaliador;

class LeilaoTest extends TestCase
{

	private $leiloeiro;


	protected function setUp(): void
	{
		$this->leiloeiro = new Avaliador();
	}

	/**
	*	@dataProvider geraLances
	*/
    public function testLeilaoDeveReceberLances(int $qtd, Leilao $leilao, array $valores)
    {

    	self::assertCount($qtd, $leilao->getLances());

    	foreach( $valores as $i => $valor ){
    		self::assertEquals($valor, $leilao->getLances()[$i]->getValor());
    	}
    }

    public function geraLances()
    {
    	$joao = new Usuario('João');
    	$maria = new Usuario("Maria");

    	$leilao1 = new Leilao("FIAT 147 0KM");
    	$leilao1->recebeLance(new Lance($joao,1000));
    	$leilao1->recebeLance(new Lance($maria,2000));

    	$amanda = new Usuario("Amanda");

    	$leilao2 = new Leilao("FUSCA 1980 0KM");
    	$leilao2->recebeLance(new Lance($amanda,5000));

    	return [
    		"leilao1" => [2, $leilao1, [1000,2000]],
    		"leilao2" => [1, $leilao2, [5000]]
    	];

    }
    
    public function testLeilaoNaoDeveEstarVazio()
    {

    	self::expectException(\DomainException::class);
    	self::expectExceptionMessage("Não é possível avaliar leilão vazio(sem lançes)");

    	$leilao = new Leilao("Carro sem porta, sem teto, sem rodas");
    	$this->leiloeiro->avalia($leilao);
    }
}

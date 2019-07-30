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


	protected function setUp(): void{
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

    /**
    *	@dataProvider geraLancesComMaisDe5LancesPorPessoa
    */
    public function testLeilaoDeveReceberNoMaximo5LancesDaMesmaPessoa(Leilao $leilao)
    {

    	self::assertCount(10, $leilao->getLances());

    }

    public function geraLancesComMaisDe5LancesPorPessoa()
    {
    	$ana 	= new Usuario("Ana");
    	$marcos = new Usuario("Marcos");

    	$leilao = new Leilao("Fusca Amarelo");
    	$leilao->recebeLance(new Lance($ana,1000));
    	$leilao->recebeLance(new Lance($marcos,1500));
    	$leilao->recebeLance(new Lance($ana,2000));
    	$leilao->recebeLance(new Lance($marcos,2500));
    	$leilao->recebeLance(new Lance($ana,3000));
    	$leilao->recebeLance(new Lance($marcos,3500));
    	$leilao->recebeLance(new Lance($ana,4000));
    	$leilao->recebeLance(new Lance($marcos,4500));
    	$leilao->recebeLance(new Lance($ana,5000));
    	$leilao->recebeLance(new Lance($marcos,5500));

    	$leilao->recebeLance(new Lance($ana,6000));

    	return [
    		[$leilao]
    	];
    } 
}

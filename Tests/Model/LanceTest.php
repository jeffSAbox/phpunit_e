<?php

namespace PhpUnitEstudo\Tests\Model;

use PHPUnit\Framework\TestCase;
use PhpUnitEstudo\Leilao\Model\Leilao;
use PhpUnitEstudo\Leilao\Model\Lance;
use PhpUnitEstudo\Leilao\Model\Usuario;

class LanceTest extends TestCase
{

    public function testVerificaRepeticaoDeLanceDoMesmoUsuario()
    {

        self::expectException(\DomainException::class);
        self::expectExceptionMessage("Não pode ter 2+ lançes consecutivos");

        $joao = new Usuario('João');
        $maria = new Usuario("Maria");

        $leilao = new Leilao("FUSCA 1980 0KM");
        
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($joao, 6000));

        
    }

    public function testLeilaoDeveReceberNoMaximo5LancesDaMesmaPessoa()
    {

        self::expectException(\DomainException::class);
        self::expectExceptionMessage("Limite de 5 lances por pessoa");

        $ana    = new Usuario("Ana");
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

    }

}

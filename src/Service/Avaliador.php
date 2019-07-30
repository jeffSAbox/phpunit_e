<?php

namespace PhpUnitEstudo\Leilao\Service;

use PhpUnitEstudo\Leilao\Model\Leilao;
use PhpUnitEstudo\Leilao\Model\Lance;

class Avaliador
{
    private $maiorValor = -INF;
    private $menorValor = INF;
    private $maioresLances;

    public function avalia(Leilao $leilao): void
    {
        if( empty($leilao->getLances()) ){
            throw new \DomainException("Não é possível avaliar leilão vazio(sem lançes)");
        }

        foreach ($leilao->getLances() as $lance) {
            if ($lance->getValor() > $this->maiorValor) {
                $this->maiorValor = $lance->getValor();
            }

            if ($lance->getValor() < $this->menorValor) {
                $this->menorValor = $lance->getValor();
            }
        }


        $lances = $leilao->getLances();
        usort($lances, function (Lance $lan1, Lance $lan2){
            if( $lan1->getValor() == $lan2->getValor() ) return 0;
            return ($lan1->getValor() > $lan2->getValor())?-1:1;
        });
        $this->maioresLances = array_splice($lances,0,3);

    }

    public function getMaiorValor(): float
    {
        return $this->maiorValor;
    }

    public function getMenorValor(): float
    {
        return $this->menorValor;
    }

    public function getMaioresLances(): array
    {
        return $this->maioresLances;
    }

}
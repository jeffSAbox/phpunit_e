<?php

namespace PhpUnitEstudo\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    /**
    *   MISTURAR OS LANCES
    */
    public function lancesRand()
    {
        $lances_aux = self::getLances();
        usort($lances_aux, function (Lance $lan1, Lance $lan2){
            return rand(-1,1);
        });
        $this->lances = $lances_aux;
    }
}

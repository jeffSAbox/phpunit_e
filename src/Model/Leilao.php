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
        if( !empty($this->lances) and $this->checkLanceRepetido($lance) )
            return;

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

    private function checkLanceRepetido(Lance $lance)
    {        
        $nomeUltimo = $this->lances[count($this->lances)-1];
        if( $lance->getUsuario() == $nomeUltimo->getUsuario() ){
            return true;
        }
        return false;
    }
}

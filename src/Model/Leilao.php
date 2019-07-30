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
        if( $this->checkLanceRepetido($lance) )
            return;

        if( $this->checkLanceLimite($lance) )
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

    private function checkLanceRepetido(Lance $lance): bool
    {                
        if( count($this->lances) < 1 )
            return false;

        $nomeUltimo = $this->lances[array_key_last($this->lances)];
        if( $lance->getUsuario() == $nomeUltimo->getUsuario() ) 
            return true;
        
        return false;
    }

    private function checkLanceLimite(Lance $lance): bool
    {

        $usuario = $lance->getUsuario();
        $total = array_reduce(
            $this->lances, 
            function(int $qtd, $lanceAtual) use ($usuario){

                if( $usuario == $lanceAtual->getUsuario() )
                    return $qtd + 1;

                return $qtd;

            }, 
            0);

        if( $total >= 5 )
            return true;

        return false;

    }

}

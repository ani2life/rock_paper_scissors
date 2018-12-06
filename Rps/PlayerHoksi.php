<?php
namespace Rps;

/**
 * 가위바위보 Player - Hoksi
 */
class PlayerHoksi implements Player
{
    protected $oldRps;
    protected $randMod;
    protected $ruleRound = 100;
    protected $rpsType = 'max';
    
    public function __construct()
    {
        $this->randMod = rand(2,9);
    }
    
    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        int $prev_battle_result
    ): int {
        $mode = $prev_round > 0 && ($prev_round < $this->ruleRound || !($prev_round % $this->randMod));

        $this->addOldRps($my_prev_hand_code, $prev_battle_result);

        if($mode) {
            return $this->getRuleRps($my_prev_hand_code, $rival_prev_hand_code, $prev_battle_result);
        } else {
            return $this->getRandRps();
        }
    }
    
    protected function addOldRps($my_hand_code, $battele_result)
    {
        if($my_hand_code > 0) {
            $idx = $my_hand_code - 1;
            $this->oldRps[$idx] = $this->oldRps[$idx] + $battele_result;
        } else {
            $this->oldRps = [0,0,0];
        }
    }
    
    protected function getBestOldRps($mode = 'max')
    {
        $maxResult = max($this->oldRps);
        $minResult = min($this->oldRps);
        
        if($maxResult != $minResult) {
            return array_search(($mode == 'max' ? $maxResult : $minResult), $this->oldRps) + 1;
        } else {
            return false;
        }
    }
    
    protected function getRandRps()
    {
        $rps = [Hand::CODE_PAPER, Hand::CODE_ROCK, Hand::CODE_SCISSORS];
        return $rps[(rand(11111, 999999) % 3)];
    }
    
    protected function getRuleRps($my_hand_code, $you_hand_code, $battle_result)
    {
        $result = false;
        $this->randMod = rand(2,9);
        
        if($battle_result == -1) {
            $rps = range(1,3);
            
            unset($rps[$my_hand_code - 1]);
            unset($rps[$you_hand_code - 1]);
            
            $result = array_pop($rps);
        } elseif($battle_result == 1) {
            $result = $you_hand_code;
        } else {
            $result = $this->getBestOldRps($this->rpsType);
        }
        
        return $result === false ? $this->getRandRps() : $result;
    }
}

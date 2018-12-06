<?php
namespace Rps;

/**
 * 남원규님의 주먹만 내기
 */
class PlayerRock implements Player
{
    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        int $prev_battle_result
    ): int {
        return Hand::CODE_ROCK;
    }
}

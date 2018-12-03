<?php
namespace Rps;

/**
 * 랜덤 플레이어
 */
class PlayerRand implements Player
{
    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        int $prev_battle_result
    ): int {
        return rand(1, 3);
    }
}

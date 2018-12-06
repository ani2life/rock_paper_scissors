<?php
namespace Rps;

class PlayerMuk implements Player
{
    private const HAND_CODE_LIST = [
        Hand::CODE_ROCK,
        Hand::CODE_PAPER,
        Hand::CODE_SCISSORS,
    ];

    private const BATTLE_CODE_LIST = [
        Arena::BATTLE_LOSE,
        Arena::BATTLE_DRAW,
    ];

    private static $rival_prev_hand_list = [];
    private static $rival_last_hand = false;

    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        int $prev_battle_result
    ): int {
        if ($rival_prev_hand_code !== Hand::CODE_MISS
            && in_array($prev_battle_result, self::BATTLE_CODE_LIST)
        ) {
            if (self::$rival_last_hand !== $rival_prev_hand_code) {
                self::$rival_last_hand = $rival_prev_hand_code;
                self::$rival_prev_hand_list = [];
            }

            self::$rival_prev_hand_list[] = $rival_prev_hand_code;
        }

        if (count(self::$rival_prev_hand_list) >= 3) {
            self::$rival_prev_hand_list = [];

            return $my_prev_hand_code == Hand::CODE_SCISSORS
                ? Hand::CODE_PAPER
                : $my_prev_hand_code + 1;
        }

        if ($my_prev_hand_code) {
            return $my_prev_hand_code;
        }

        return self::HAND_CODE_LIST[array_rand(self::HAND_CODE_LIST, 1)];
    }
}

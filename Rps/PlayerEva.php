<?php
namespace Rps;

/**
 * 신세기 에반게리온의 자가판단 컴퓨터 시스템 MAGI 알고리즘 도입
 */
class PlayerEva implements Player
{
    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        int $prev_battle_result
    ): int {
        // 멜키오르(MELCHIOR) : 과학자로서의 나오코
        $magi_melchior = function () use ($prev_round, $prev_battle_result) {
            if ($prev_battle_result == Arena::BATTLE_WIN) {
                return (time() + $prev_round) % 3 + 1;
            } else {
                return rand(1, 3);
            }
        };

        // 발타자르(BALTHASAR) : 어머니로서의 나오코
        $magi_balthasar = function () use ($my_prev_hand_code) {
            if ($my_prev_hand_code == Hand::CODE_MISS) {
                return rand(1, 3);
            }

            $codes = [Hand::CODE_ROCK, Hand::CODE_PAPER, Hand::CODE_SCISSORS];
            // 내가 이전에 낸거 빼고 내기
            unset($codes[$my_prev_hand_code - 1]);
            shuffle($codes);

            return array_pop($codes);
        };

        // 캐스퍼(CASPER) : 여자로서의 나오코
        $magi_casper = function () use ($rival_prev_hand_code) {
            if ($rival_prev_hand_code == Hand::CODE_MISS) {
                return rand(1, 3);
            }

            $codes = [Hand::CODE_ROCK, Hand::CODE_PAPER, Hand::CODE_SCISSORS];
            // 상대방이 이전에 낸거 빼고 내기
            unset($codes[$rival_prev_hand_code - 1]);
            shuffle($codes);

            return array_pop($codes);
        };

        $magi_com_list = [
            $magi_balthasar,
            $magi_melchior,
            $magi_casper,
        ];

        for ($i = 0; $i < 10; $i++) {
            $code_count = [
                Hand::CODE_ROCK => 0,
                Hand::CODE_PAPER => 0,
                Hand::CODE_SCISSORS => 0,
            ];

            foreach ($magi_com_list as $magi_com) {
                $code = $magi_com();
                ++$code_count[$code];

                // 2대가 합의 했다면
                if ($code_count[$code] == 2) {
                    return $code;
                }
            }
        }

        return rand(1, 3);
    }
}

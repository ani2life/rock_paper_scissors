<?php
namespace Rps;

/**
 * 가위-바위-보 선수 인터페이스
 */
interface Player
{
    /**
     * 가위-바위-보 내기
     *
     * @param int $prev_round 이전 경기 횟수
     * @param int $my_prev_hand_code 나의 이전 낸 손
     * @param int $rival_prev_hand_code 상대의 이전 낸 손
     * @param boo $prev_battle_result 이전 경기 결과
     * @return int
     *     Hand::CODE_ROCK
     *     Hand::CODE_CODE_PAPER
     *     Hand::CODE_SCISSORS
     */
    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        bool $prev_battle_result
    ): int;
}

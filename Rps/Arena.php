<?php
namespace Rps;

/**
 * 투기장
 */
class Arena
{
    /** @var int 경기 결과 - 패배 */
    public const BATTLE_LOSE = -1;
    /** @var int 경기 결과 - 무승부 */
    public const BATTLE_DRAW = 0;
    /** @var int 경기 결과 - 승리 */
    public const BATTLE_WIN = 1;

    /** @var Player 플레이어1 */
    private $player1;
    /** @var Player 플레이어2 */
    private $player2;

    /**
     * 생성자
     * @param Player $player1 플레이어1
     * @param Player $player2 플레이어2
     */
    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * 경기 실행
     * @param int $round_conut 경기 횟수
     * @return array 경기 기록 [
     *     round
     *     p1_hand_code
     *     p2_hand_code
     *     p1_win_point
     *     p2_win_point
     *     win_player_no
     * ]
     */
    public function battle(int $round_conut = 10): array
    {
        $player1 = $this->player1;
        $player2 = $this->player2;

        $battle_log = [];
        $prev_round = 0;

        $p1_prev_hand_code = 0;
        $p2_prev_hand_code = 0;
        $p1_prev_battle_result = 0;
        $p2_prev_battle_result = 0;
        $p1_win_point = 0;
        $p2_win_point = 0;

        for ($i = 1; $i <= $round_conut; $i++) {
            $p1_fire_hand_code = $player1->fireHand(
                $prev_round,
                $p1_prev_hand_code,
                $p2_prev_hand_code,
                $p1_prev_battle_result
            );

            $p2_fire_hand_code = $player2->fireHand(
                $prev_round,
                $p2_prev_hand_code,
                $p1_prev_hand_code,
                $p2_prev_battle_result
            );

            $cmp_result = \Rps\Hand::codeComparison(
                $p1_fire_hand_code,
                $p2_fire_hand_code
            );

            $prev_round = $i;
            $p1_prev_hand_code = $p1_fire_hand_code;
            $p2_prev_hand_code = $p2_fire_hand_code;

            if ($cmp_result == -1) {
                $p1_prev_battle_result = self::BATTLE_LOSE;
                $p2_prev_battle_result = self::BATTLE_WIN;
                ++$p2_win_point;
                $win_player_no = 2;
            } elseif ($cmp_result == 1) {
                $p1_prev_battle_result = self::BATTLE_WIN;
                $p2_prev_battle_result = self::BATTLE_LOSE;
                ++$p1_win_point;
                $win_player_no = 1;
            } else {
                $p1_prev_battle_result
                    = $p2_prev_battle_result
                    = self::BATTLE_DRAW;
                $win_player_no = 0;
            }

            $battle_log[] = [
                'round' => $prev_round,
                'p1_hand_code' => $p1_prev_hand_code,
                'p2_hand_code' => $p2_prev_hand_code,
                'p1_hand_label' => Hand::LABEL_BY_CODE[$p1_prev_hand_code],
                'p2_hand_label' => Hand::LABEL_BY_CODE[$p2_prev_hand_code],
                'p1_win_point' => $p1_win_point,
                'p2_win_point' => $p2_win_point,
                'win_player_no' => $win_player_no,
            ];
        }

        return $battle_log;
    }
}

<?php
namespace Rps;

/**
 * Author: 이현석
 * “win-stay, lose-shift” strategy
 * MIT 테크놀러지 참고했고, 혹시 같은 전략을 가지고 나온 경우에 대한 대비책을 추가한 코드입니다.
 * https://www.technologyreview.com/s/527026/how-to-win-at-rock-paper-scissors/
 */
class PlayerLhs implements Player
{
    private $loseInARow = 0;

    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        int $prev_battle_result
    ): int {
        $this->updateLoseInARow($prev_battle_result);

        if ($my_prev_hand_code === Hand::CODE_MISS) {
            return rand(1, 3);
        }

        if ($this->loseInARow <= 2) {
            return $my_prev_hand_code;
        }

        return $this->shiftToReverseClockwise($my_prev_hand_code);
    }

    /**
     * 연속 패배 횟수 업데이트
     * @param $prev_battle_result
     */
    private function updateLoseInARow($prev_battle_result)
    {
        if ($prev_battle_result === -1) {
            $this->loseInARow++;
        } else {
            $this->loseInARow = 0;
        }
    }

    /**
     * 시계 반대 방향의 손모양으로 변경
     * 시계 방향: R-P-S
     * @param $my_prev_hand_code
     * @return int
     */
    private function shiftToReverseClockwise($my_prev_hand_code)
    {
        switch ($my_prev_hand_code) {
            case Hand::CODE_ROCK:
                return Hand::CODE_SCISSORS;
                break;
            case Hand::CODE_PAPER:
                return Hand::CODE_ROCK;
                break;
            case Hand::CODE_SCISSORS:
                return Hand::CODE_PAPER;
                break;
        }
    }
}

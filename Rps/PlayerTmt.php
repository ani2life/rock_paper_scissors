<?php

namespace Rps;

/**
 * 한번 지면 생각이 많아지는 TMT 아저씨
 */
class PlayerTmt implements Player
{
    private $timesIChangedMyMind = 0;

    public function fireHand(
        int $prev_round,
        int $my_prev_hand_code,
        int $rival_prev_hand_code,
        int $prev_battle_result
    ): int
    {

        if ($prev_battle_result === Arena::BATTLE_WIN ||
            $rival_prev_hand_code === Hand::CODE_MISS
        ) {
            return rand(1, 3);
        }

        $heOrSheMayChooseAgain = $rival_prev_hand_code;

        return $this->letMeThink($heOrSheMayChooseAgain);
    }

    private function letMeThink($rivalsChoice)
    {
        return $this->trampoline(
            function () use ($rivalsChoice) {
                return $this->thenIWillChoose($rivalsChoice);
            }
        );
    }

    private function trampoline($function)
    {
        $result = function () use ($function) {
            return $function();
        };
        while (is_callable($result)) {
            $result = $result();
        }
        return $result;
    }

    private function thenIWillChoose($rivalsChoice)
    {
        $myNewChoice = $this->winningStrategy($rivalsChoice);

        $this->timesIChangedMyMind++;

        if ($this->timesIChangedMyMind > 10000000) return $man = Hand::CODE_ROCK;

        return function () use ($myNewChoice) {
            return $this->thenHeOrSheMayChoose($myNewChoice);
        };
    }

    private function thenHeOrSheMayChoose($myNewChoice)
    {
        $rivalsChoice = $this->winningStrategy($myNewChoice);

        return function () use ($rivalsChoice) {
            return $this->thenIWillChoose($rivalsChoice);
        };
    }

    private function winningStrategy($rivalsChoice)
    {
        switch ($rivalsChoice) {
            case Hand::CODE_ROCK:
                return Hand::CODE_PAPER;
            case Hand::CODE_PAPER:
                return Hand::CODE_SCISSORS;
            case Hand::CODE_SCISSORS:
                return Hand::CODE_ROCK;
        }
    }
}

<?php
namespace Rps;

/**
 * 손
 */
class Hand
{
    /** @var int 코드 - 실수 */
    public const CODE_MISS = 0;
    /** @var int 코드 - 주먹 */
    public const CODE_ROCK = 1;
    /** @var int 코드 - 보 */
    public const CODE_PAPER = 2;
    /** @var int 코드 - 가위 */
    public const CODE_SCISSORS = 3;

    /** @var int 코드별 라벨 */
    public const LABEL_BY_CODE = [
        self::CODE_MISS => '실수',
        self::CODE_ROCK => '주먹',
        self::CODE_PAPER => '보',
        self::CODE_SCISSORS => '가위',
    ];

    /**
     * 코드 비교
     * @param int $code1 코드1
     * @param int $code2 코드2
     * @return int
     *     -1: 코드1(패) 코드2(승)
     *      1: 코드1(승) 코드2(패)
     *      0: 무승부
     */
    public static function codeComparison(int $code1, int $code2): int
    {
        $fn_code_correction = function (int $code): int {
            if ($code < self::CODE_ROCK || $code > self::CODE_SCISSORS) {
                $code = self::CODE_MISS;
            }
            return $code;
        };

        $code1 = $fn_code_correction($code1);
        $code2 = $fn_code_correction($code2);

        if ($code1 == self::CODE_MISS && $code2 == self::CODE_MISS) {
            return 0;
        } elseif ($code1 == self::CODE_MISS) {
            return -1;
        } elseif ($code2 == self::CODE_MISS) {
            return 1;
        }

        $result = $code1 - $code2;

        if ($result == 0) {
            return $result;
        }

        if (abs($result) == 1) {
            return $result;
        }

        if (abs($result) == 2) {
            return $result / 2 * -1;
        }
    }
}

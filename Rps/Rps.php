<?php
namespace Rps;

/**
 * 가위-바위-보
 */
class Rps
{
    /**
     * 이름으로 플레이어 생성
     * @param string $player_name 플레이어 이름
     * @return Player
     */
    public static function createPlayerByName(string $player_name): Player
    {
        $player_class = __NAMESPACE__ . '\Player' . ucfirst(strtolower($player_name));
        return (new \ReflectionClass($player_class))->newInstance();
    }
}

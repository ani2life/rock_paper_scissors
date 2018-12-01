<?php
/**
 * 여기는 귀찮아서 대충 코딩했습니다.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../vendor/autoload.php';

$player1_name = $_GET['player1_name'] ?? "eva" ?: "eva";
$player2_name = $_GET['player2_name'] ?? "rand" ?: "rand";
$round_count = (int)($_GET['round_count'] ?? 10 ?: 10);

$player1 = \Rps\Rps::createPlayerByName($player1_name);
$player2 = \Rps\Rps::createPlayerByName($player2_name);

$arena = new \Rps\Arena($player1, $player2);
$battle_log = $arena->battle($round_count);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>가위-바위-보</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<link rel="stylesheet" type="text/css" href="./style.css">
</head>
<body>

<form action="." method="get">
    <label>
        플레이어1
        <input type="text" name="player1_name" size="12" value="<?=htmlspecialchars($player1_name)?>">
    </label>
    <label>
        플레이어2
        <input type="text" name="player2_name" size="12" value="<?=htmlspecialchars($player2_name)?>">
    </label>
    <label>
        경기 횟수
        <input type="number" name="round_count" style="width: 4em;" value="<?=$round_count?>">
    </label>
    <button>설정하기</button>
</form>

<button class="battle">BATTLE START</button>

<div class="main">
    <div class="area">
        <div class="player one">
            <p class="name">
                <?=strtoupper($player1_name)?><br>
                [ <span class="point">0</span> ]
            </p>
            <img src="./img/hand_0.png" alt="">
        </div>

        <b class="vs">VS</b>

        <div class="player two">
            <p class="name">
                <?=strtoupper($player2_name)?><br>
                [ <span class="point">0</span> ]
            </p>
            <img src="./img/hand_0.png" alt="">
        </div>
    </div>

    <textarea class="log" autocomplete="off"></textarea>
</div>

<script>
let battleLog = <?=json_encode($battle_log)?>;
let roundCount = 0;
let maxRoundCount = <?=$round_count?>;
let lockBattle = false;

let $player1Img = $('.player.one img');
let $player2Img = $('.player.two img');
let $player1Point = $('.player.one .point');
let $player2Point = $('.player.two .point');
let $battleLog = $('.main .log');

function readyBattle() {
    if (roundCount >= maxRoundCount) {
        return;
    }

    if (lockBattle) {
        return;
    }

    lockBattle = true;

    let frame = 0;

    let loop = () => {
        if (frame > 11) {
            runBattle();
            lockBattle = false;
            return;
        }

        let code = frame % 3 + 1;

        $player1Img.attr('src', `./img/hand_${code}.png`);
        $player2Img.attr('src', `./img/hand_${code}.png`);

        ++frame;

        setTimeout(loop, 50);
    }

    loop();
}

function runBattle() {
    if (roundCount >= maxRoundCount) {
        return;
    }

    if (!lockBattle) {
        return;
    }

    let log = battleLog[roundCount];

    $player1Img.attr('src', `./img/hand_${log.p1_hand_code}.png`);
    $player2Img.attr('src', `./img/hand_${log.p2_hand_code}.png`);

    $player1Point.text(log.p1_win_point);
    $player2Point.text(log.p2_win_point);

    $battleLog.val(
        $battleLog.val() + [
            log.round,
            log.p1_hand_label,
            log.p2_hand_label,
            log.p1_win_point,
            log.p2_win_point,
            log.win_player_no
        ].join(',') + "\n"
    );

    ++roundCount;

    if (roundCount >= maxRoundCount) {
        alert('경기 종료');
    }
}

$('.battle').click(() => {
    readyBattle();
});
</script>

</body>
</html>

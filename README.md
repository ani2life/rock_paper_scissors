# 가위-바위-보 코딩 대결

## 개요

[Modern PHP User Group](https://www.facebook.com/groups/655071604594451/)의 2018년 송년회를 위한 코딩 대결 게임 입니다.

## 게임 참여 방법

* \Rps\Player 인터페이스 구현한 클래스 제작

* 클래스명 규칙

    * Player + Name(첫글자만 대문자)

    * 예) PlayerDiablo

* 송년회 당일 개발한 클래스의 코드를 제출

* 예제 파일 참고

    * ./Rps/PlayerEva.php

    * ./Rps/PlayerRand.php

* 제출 방법

    * USB 메모리, 온라인 다운로드, 즉석 코딩 등 5분 안에 모든 방법을 동원하여 제출

## 게임 실행 방법

1. 내가 만든 클래스를 ./Rps 디렉토리에 추가

1. PHP 컴포저 설치

    ```bash
    $ composer install
    ```

1. 도커 컨테이너 실행

    ```bash
    $ docker-compose up -d
    ```

1. 브라우저 접속

    [http://127.0.0.1:8080](http://127.0.0.1:8080)

## 게임 실행 트러블 슈팅

꼭 굳이 힘들게 게임을 실행하시지 않으셔도 됩니다.
대회 당일 \Rps\Player 인터페이스를 구현한 클래스의 코드만 제출하시면 됩니다.

## 가위-바위-보 이미지 출처

http://www.polyesterstudio.com/rock-paper-scissors/

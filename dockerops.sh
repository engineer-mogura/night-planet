#!/bin/bash

up () {
  IMAGES=$(docker ps -q | wc -l)
  if [ "${IMAGES}" -ge 1 ]; then
    echo "現在起動しているコンテナを停止します..."
    docker kill $(docker ps -q)
  fi
  echo "コンテナを起動します..."
  docker-compose up -d
}

build() {
  IMAGES=$(docker ps -q | wc -l)
  if [ "${IMAGES}" -ge 1 ]; then
  echo "現在起動しているコンテナを停止します..."
  docker kill $(docker ps -q)
  fi
  echo "コンテナを作り直します..."
  # 環境設定ファイルをコピーする
  echo "環境設定ファイルをチェックします..."
  if [ ! -e './.env_'$exe_env ];then
    echo ".env_${exe_env} が存在しません。"
    exit 1
  else
    echo ".env_${exe_env} 環境でデプロイします。"
  fi
  echo "ファイル名を[.env_${exe_env}] ⇒ [.env]に変更してコピーします..."
  cp './.env_'${exe_env} ./.env
  echo "[.env]を[./config]ディレクトリにコピーします..."
  cp './.env' ./config/.env

  # Google Cloud サービスアカウント資格情報ファイルをコピーする
  echo "Google Cloud サービスアカウント資格情報ファイルをコピーします..."
  if [ ! -e './service-account-credentials.json' ];then
    echo "service-account-credentials.json が存在しません。"
    exit 1
  fi
  cp ./service-account-credentials.json ./config/googles
  docker-compose build
  echo "コンテナを起動します..."
  docker-compose up -d
}

clean () {
  IMAGES=$(docker images | awk '/docker_/ {print $1}' | wc -l)
  if [ "${IMAGES}" -ge 1 ]; then
    echo "コンテナとして使用できないイメージを削除します..."
    docker image prune -f
    echo "コンテナを停止します..."
    docker kill $(docker ps -q)
    echo "コンテナを削除します..."
    docker rm -f $(docker ps -q -a)
    echo "イメージを削除します..."
    docker rmi -f $(docker images | awk '/docker_/ {print $1}')
  fi
}

usage () {
echo $1
cat <<_EOF_
Usage:
$(basename $0) [OPTION]

Description:
"$(pwd)" のDockerのオペレーション用スクリプトです。

Options:
-u upを実行します。現在起動しているコンテナを停止して、"$(pwd)"にあるdocker-composeを起動します。
-b buildを実行します。コンテナのイメージの作り直しをします。Dockerfileを更新した場合はこちら。
-c cleanを実行します。コンテナのイメージを削除します。
-r cleanを実行してからupを実行します。なにかトラブルシュートなどできれいにしたい場合はこちら。
-h ヘルプを表示します。
-pb build 時に実行環境(本番環境)を指定します。
-wb build 時に実行環境(開発環境)を指定します。
-lb build 時に実行環境(ローカル環境)を指定します。

_EOF_

exit 0
}

#実行環境
exe_env="local"

while getopts :ubcrhpwl OPT
do
case $OPT in
u ) up;;
b ) build;;
c ) clean;;
r ) clean ; up;;
h ) usage;;
p ) exe_env='prod';;
w ) exe_env='work';;
l ) exe_env='local';;
:|\? ) usage;;
esac
done
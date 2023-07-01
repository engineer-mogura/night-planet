#!/bin/bash

#night-planet コンテナIDを抽出する
target () {
  containers=$(docker ps --filter name=night-planet --format "{{.Names}}")
  echo "night-planet コンテナを抽出します..."
  for c in $containers; do
    echo $c
  done
}

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
  target
  IMAGES=$(docker ps -q | wc -l)
  if [ "${IMAGES}" -ge 1 ]; then
    echo -e "現在起動しているコンテナを停止します...\n"
    docker kill $(docker ps --filter name=night-planet --format "{{.Names}}")
  fi
  echo -e "コンテナを作り直します...\n"

  # 環境設定ファイルをコピーする
  echo -e "環境設定ファイルをチェックします...\n"
  if [ ! -e ${WORK_DIR}'.env_'$EXE_ENV ];then
    echo "${WORK_DIR}'.env_${EXE_ENV} が存在しません。"
    exit 1
  else
    echo "${WORK_DIR}'.env_${EXE_ENV} 環境でデプロイします。"
  fi
  echo "ファイル名を[.env_${EXE_ENV}] ⇒ [.env]に変更してコピーします..."
  cp ${WORK_DIR}'.env_'${EXE_ENV} ./.env
  echo -e "[.env]を[./config]ディレクトリにコピーします...\n"
  cp './.env' ./config/.env

  # Nginxの設定ファイルをコピーする
  echo -e "Nginxの設定ファイルをチェックします...\n"
  SSL_PATH=./docker/web/ssl/
  SERVER_CRT=server.crt
  SERVER_KEY=server.key
  ENIGX_FILE=./docker/web/default.conf
  enigx_file_tmp=./docker/web/default_nonssl.conf

  if [[ $EXE_ENV =~ ^prod$|^work$ ]];then
    enigx_file_tmp=./docker/web/default_ssl.conf
    echo -e "[${WORK_DIR}${SERVER_CRT}]を[${SSL_PATH}${SERVER_CRT}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}${SERVER_CRT} ];then
      echo "${WORK_DIR}${SERVER_CRT} が存在しません。"
      exit 1
    fi
    echo -e "[${WORK_DIR}${SERVER_KEY}]を[${SSL_PATH}${SERVER_KEY}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}${SERVER_KEY} ];then
      echo "${WORK_DIR}${SERVER_KEY} が存在しません。"
      exit 1
    fi
    cp ${WORK_DIR}${SERVER_CRT} ${SSL_PATH}${SERVER_CRT}
    cp ${WORK_DIR}${SERVER_KEY} ${SSL_PATH}${SERVER_KEY}
  fi
  echo -e "[$enigx_file_tmp]を[${ENIGX_FILE}]に置換します...\n"
  if [ ! -e ${enigx_file_tmp} ];then
    echo "${enigx_file_tmp} が存在しません。"
    exit 1
  fi
  cp ${enigx_file_tmp} ${ENIGX_FILE}

  # css 内部のURLを変更する
  REPLACE_URL=`grep -w AWS_URL_HOST ./.env | sed -r 's/AWS_URL_HOST=([^ ]*).*$/\1/'`
  BASE_URL=http://127.0.0.1:9090
  CSS_FILE=./webroot/css/okiyoru.css
  CSS_FILE_TMP=./webroot/css/okiyoru_tmp.css
  echo -e "[cssファイル]内部のURL[$BASE_URL]を[${REPLACE_URL}]に置換します...\n"
  if [ ! -e ${CSS_FILE} ];then
    echo "${CSS_FILE} が存在しません。"
    exit 1
  fi
  sed -e "s@$BASE_URL@$REPLACE_URL@g" ${CSS_FILE} > ${CSS_FILE_TMP}
  rm ${CSS_FILE}
  mv ${CSS_FILE_TMP} ${CSS_FILE}

  # Google Cloud サービスアカウント資格情報ファイルをコピーする
  echo -e "Google Cloud サービスアカウント資格情報ファイルをコピーします...\n"
  if [ ! -e ${WORK_DIR}"service-account-credentials.json" ];then
    echo ${WORK_DIR}"service-account-credentials.json が存在しません。"
    exit 1
  fi
  cp ${WORK_DIR}"service-account-credentials.json" ./config/googles

  docker-compose build $(docker ps --filter name=night-planet --format "{{.Names}}")
  echo "コンテナを起動します..."
  docker-compose up -d $(docker ps --filter name=night-planet --format "{{.Names}}")

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
EXE_ENV="local"
#作業フォルダ
WORK_DIR="./work_dir/NightPlanet/env/"

while getopts :ubcrhpwl OPT
do
case $OPT in
u ) up;;
b ) build;;
c ) clean;;
r ) clean ; up;;
h ) usage;;
p ) EXE_ENV='prod';;
w ) EXE_ENV='work';;
l ) EXE_ENV='local';;
:|\? ) usage;;
esac
done
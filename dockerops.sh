#!/bin/bash

#night-planet コンテナIDを抽出する
target () {
  containers=$(docker ps --filter name=${SERVICE_NAME}-${EXE_ENV} --format "{{.Names}}")
  echo "${SERVICE_NAME}-${EXE_ENV} コンテナを抽出します..."
  for c in $containers; do
    echo $c
  done
}

#night-planet コンテナ、ボリュームを停止後、削除する
delete () {

  # 本番環境の場合は実施するか確認する
  if [ $EXE_ENV = prod ];then
    read -n1 -p "ok? (y/N): " yn
    if [[ $yn -ne [yY] ]]; then
      exit 1
    fi
  fi

  target
  echo "コンテナを停止後、削除し、関連ボリュームも削除します..."
  docker rm -f $(docker ps --filter name=${SERVICE_NAME}-${EXE_ENV} --format "{{.Names}}")
  echo "以下、コンテナが削除された事を確認してください、何も表示されない場合は削除完了です"
  docker ps --filter name=${SERVICE_NAME}-${EXE_ENV} --format "{{.Names}}"
  echo "\n"
  if [ $EXE_ENV = prod ] || [ $EXE_ENV = work ];then
    docker volume rm ${SERVICE_NAME}-${EXE_ENV}_mysql-volume
  else
    docker volume rm ${SERVICE_NAME}-${EXE_ENV}_mysql-volume ${SERVICE_NAME}-${EXE_ENV}_maildir
  fi
  echo "以下、ボリュームが削除された事を確認してください、何も表示されない場合は削除完了です"
  docker volume ls -f name=${SERVICE_NAME}
  echo "\n"
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

#night-planet コンテナをビルドし起動する
build() {
  target
  IMAGES=$(docker ps -q | wc -l)
  if [ "${IMAGES}" -ge 1 ]; then
    echo -e "現在起動しているコンテナを停止します...\n"
    docker kill $(docker ps --filter name=${SERVICE_NAME}-${EXE_ENV} --format "{{.Names}}")
  fi
  echo -e "コンテナを作り直します...\n"

  # 環境設定ファイルをコピーする
  echo -e "環境設定ファイルをチェックします...\n"
  if [ ! -e ${WORK_DIR}/${EXE_ENV}/'.env_'$EXE_ENV ];then
    echo "${WORK_DIR}/${EXE_ENV}/'.env_${EXE_ENV} が存在しません。"
    exit 1
  fi
  echo "${WORK_DIR}/${EXE_ENV}/'.env_${EXE_ENV} 環境でデプロイします。"
  echo "ファイル名を[.env_${EXE_ENV}] ⇒ [.env]に変更してコピーします..."
  cp ${WORK_DIR}/${EXE_ENV}/'.env_'${EXE_ENV} ./.env
  echo -e "[.env]を[./config]ディレクトリにコピーします...\n"
  cp './.env' ./config/.env

  # Nginxの設定ファイルをコピーする
  echo -e "環境毎のファイルを設定します...\n"
  # nginx
  SSL_PATH=./docker/web/ssl/
  # public ssl
  SERVER_PUBLIC_CRT_ENV=server_public_${EXE_ENV}.crt
  SERVER_PUBLIC_KEY_ENV=server_public_${EXE_ENV}.key
  SERVER_PUBLIC_PASSFILE_ENV=server_public_${EXE_ENV}.passfile
  SERVER_PUBLIC_CRT=server_public.crt
  SERVER_PUBLIC_KEY=server_public.key
  SERVER_PUBLIC_PASSFILE=server_public.passfile
  # admin ssl
  SERVER_ADMIN_CRT_ENV=server_admin_${EXE_ENV}.crt
  SERVER_ADMIN_KEY_ENV=server_admin_${EXE_ENV}.key
  SERVER_ADMIN_PASSFILE_ENV=server_admin_${EXE_ENV}.passfile
  SERVER_ADMIN_CRT=server_admin.crt
  SERVER_ADMIN_KEY=server_admin.key
  SERVER_ADMIN_PASSFILE=server_admin.passfile

  ENIGX_FILE=./docker/web/default.conf
  enigx_file_tmp=./docker/web/default_${EXE_ENV}.conf

  # docker
  DOCKER_COMPOSE_FILE=./docker-compose.yml
  docker_compose_file_tmp=./docker-compose_${EXE_ENV}.yml
  DOCKER_FILE=./docker/web/Dockerfile
  docker_file_tmp=./docker/web/Dockerfile_${EXE_ENV}
  # google croud account 認証
  GOOGLE_CLOUD_CREDENTIALS=service-account-credentials.json
  # css
  REPLACE_URL=`grep -w AWS_URL_HOST ./.env | sed -r 's/AWS_URL_HOST=([^ ]*).*$/\1/'`
  CSS_NIGHT_PLANET_FILE=./webroot/css/night-planet.css
  CSS_NIGHT_PLANET_FILE_TMP=./webroot/css/night-planet_tmp.css
  CSS_RATEIT_FILE=./webroot/css/rateit.css
  CSS_RATEIT_FILE_TMP=./webroot/css/rateit_tmp.css
  CSS_INSTAGRAM_FILE=./webroot/css/instagram.css
  CSS_INSTAGRAM_FILE_TMP=./webroot/css/instagram_tmp.css
  css_base_url=http://night-planet.local:9090

  # パーミッション変更
  # chmod -R 0777 ./logs
  # chmod -R 0777 ./tmp
  # chmod 0777 ./bin/cake ./bin/cake.bat ./bin/cake.php

  # 本番・開発環境の場合
  if [ $EXE_ENV = prod ] || [ $EXE_ENV = work ];then
    # PUBLIC SSL認証ファイルを環境毎に名称変更
    enigx_file_tmp=./docker/web/default_${EXE_ENV}.conf
    echo -e "[${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_CRT_ENV}]を[${SSL_PATH}${SERVER_PUBLIC_CRT}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_CRT_ENV} ];then
      echo "${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_CRT_ENV} が存在しません。"
      exit 1
    fi
    echo -e "[${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_KEY_ENV}]を[${SSL_PATH}${SERVER_PUBLIC_KEY}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_KEY_ENV} ];then
      echo "${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_KEY_ENV} が存在しません。"
      exit 1
    fi
    echo -e "[${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_PASSFILE_ENV}]を[${SSL_PATH}${SERVER_PUBLIC_PASSFILE}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_PASSFILE_ENV} ];then
      echo "${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_PASSFILE_ENV} が存在しません。"
      exit 1
    fi
    # PUBLIC SSL認証ファイルをコピー
    cp ${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_CRT_ENV} ${SSL_PATH}${SERVER_PUBLIC_CRT}
    cp ${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_KEY_ENV} ${SSL_PATH}${SERVER_PUBLIC_KEY}
    cp ${WORK_DIR}/${EXE_ENV}/${SERVER_PUBLIC_PASSFILE_ENV} ${SSL_PATH}${SERVER_PUBLIC_PASSFILE}

    # ADMIN SSL認証ファイルを環境毎に名称変更
    enigx_file_tmp=./docker/web/default_${EXE_ENV}.conf
    echo -e "[${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_CRT_ENV}]を[${SSL_PATH}${SERVER_ADMIN_CRT}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_CRT_ENV} ];then
      echo "${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_CRT_ENV} が存在しません。"
      exit 1
    fi
    echo -e "[${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_KEY_ENV}]を[${SSL_PATH}${SERVER_ADMIN_KEY}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_KEY_ENV} ];then
      echo "${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_KEY_ENV} が存在しません。"
      exit 1
    fi
    echo -e "[${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_PASSFILE_ENV}]を[${SSL_PATH}${SERVER_ADMIN_PASSFILE}]にコピーします...\n"
    if [ ! -e ${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_PASSFILE_ENV} ];then
      echo "${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_PASSFILE_ENV} が存在しません。"
      exit 1
    fi
    # ADMIN SSL認証ファイルをコピー
    cp ${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_CRT_ENV} ${SSL_PATH}${SERVER_ADMIN_CRT}
    cp ${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_KEY_ENV} ${SSL_PATH}${SERVER_ADMIN_KEY}
    cp ${WORK_DIR}/${EXE_ENV}/${SERVER_ADMIN_PASSFILE_ENV} ${SSL_PATH}${SERVER_ADMIN_PASSFILE}

    # nginx  を環境毎に名称変更
    enigx_file_tmp=./docker/web/default_${EXE_ENV}.conf
    # docker-compose.yml を環境毎に名称変更
    docker_compose_file_tmp=./docker-compose_${EXE_ENV}.yml
    # Dockerfile を環境毎に名称変更
    docker_file_tmp=./docker/web/Dockerfile_${EXE_ENV}
    # css ファイルの変更部分を環境毎に変更
    css_base_url=${css_base_url}/${SERVICE_NAME}
  fi

  # default.conf コピー
  echo -e "[$enigx_file_tmp]を[${ENIGX_FILE}]にコピーします...\n"
  if [ ! -e ${enigx_file_tmp} ];then
    echo "${enigx_file_tmp} が存在しません。"
    exit 1
  fi
  cp ${enigx_file_tmp} ${ENIGX_FILE}

  # docker-compose.yml コピー
  echo -e "[${docker_compose_file_tmp}]を[${DOCKER_COMPOSE_FILE}]にコピーします...\n"
  if [ ! -e ${docker_compose_file_tmp} ];then
    echo "${docker_compose_file_tmp} が存在しません。"
    exit 1
  fi
  cp ${docker_compose_file_tmp} ${DOCKER_COMPOSE_FILE}

  # Dockerfile コピー
  echo -e "[${docker_file_tmp}]を[${DOCKER_FILE}]にコピーします...\n"
  if [ ! -e ${docker_file_tmp} ];then
    echo "${docker_file_tmp} が存在しません。"
    exit 1
  fi
  cp ${docker_file_tmp} ${DOCKER_FILE}

  # night-planet.css 内部のURLを変更する
  echo -e "[${CSS_NIGHT_PLANET_FILE} ファイル]内部のURL[$css_base_url]を[${REPLACE_URL}]に置換します...\n"
  if [ ! -e ${CSS_NIGHT_PLANET_FILE} ];then
    echo "${CSS_NIGHT_PLANET_FILE} が存在しません。"
    exit 1
  fi
  sed -e "s@$css_base_url@$REPLACE_URL@g" ${CSS_NIGHT_PLANET_FILE} > ${CSS_NIGHT_PLANET_FILE_TMP}
  rm ${CSS_NIGHT_PLANET_FILE}
  mv ${CSS_NIGHT_PLANET_FILE_TMP} ${CSS_NIGHT_PLANET_FILE}

  # instagram.css 内部のURLを変更する
  echo -e "[${CSS_INSTAGRAM_FILE} ファイル]内部のURL[$css_base_url]を[${REPLACE_URL}]に置換します...\n"
  if [ ! -e ${CSS_INSTAGRAM_FILE} ];then
    echo "${CSS_INSTAGRAM_FILE} が存在しません。"
    exit 1
  fi
  sed -e "s@$css_base_url@$REPLACE_URL@g" ${CSS_INSTAGRAM_FILE} > ${CSS_INSTAGRAM_FILE_TMP}
  rm ${CSS_INSTAGRAM_FILE}
  mv ${CSS_INSTAGRAM_FILE_TMP} ${CSS_INSTAGRAM_FILE}

  # rateit.css 内部のURLを変更する
  echo -e "[${CSS_RATEIT_FILE} ファイル]内部のURL[$css_base_url]を[${REPLACE_URL}]に置換します...\n"
  if [ ! -e ${CSS_RATEIT_FILE} ];then
    echo "${CSS_RATEIT_FILE} が存在しません。"
    exit 1
  fi
  sed -e "s@$css_base_url@$REPLACE_URL@g" ${CSS_RATEIT_FILE} > ${CSS_RATEIT_FILE_TMP}
  rm ${CSS_RATEIT_FILE}
  mv ${CSS_RATEIT_FILE_TMP} ${CSS_RATEIT_FILE}

  # Google Cloud サービスアカウント資格情報ファイルをコピーする
  echo -e "[${WORK_DIR}/${GOOGLE_CLOUD_CREDENTIALS}]を[./config/googles/${GOOGLE_CLOUD_CREDENTIALS}]にコピーします...\n"
  if [ ! -e ${WORK_DIR}/${GOOGLE_CLOUD_CREDENTIALS} ];then
    echo "${WORK_DIR}/${GOOGLE_CLOUD_CREDENTIALS} が存在しません。"
    exit 1
  fi
  cp ${WORK_DIR}/${GOOGLE_CLOUD_CREDENTIALS} ./config/googles

  docker-compose build $(docker ps --filter name=${SERVICE_NAME}-${EXE_ENV} --format "{{.Names}}")
  echo "コンテナを起動します..."
  docker-compose up -d $(docker ps --filter name=${SERVICE_NAME}-${EXE_ENV} --format "{{.Names}}")

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
-d deleteを実行します。コンテナ、関連ボリュームを削除します。
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
WORK_DIR="./work_dir/NightPlanet/env"
#サービスネーム
SERVICE_NAME="night-planet"

while getopts :ubcdrhpwl OPT
do
case $OPT in
u ) up;;
b ) build;;
c ) clean;;
d ) delete;;
r ) clean ; up;;
h ) usage;;
p ) EXE_ENV='prod';;
w ) EXE_ENV='work';;
l ) EXE_ENV='local';;
:|\? ) usage;;
esac
done
#!/bin/sh

docker stop docs_web
docker rm docs_web
docker rmi docs_web

docker build -t docs_web .

# 引数でログをマウントするディレクトリを指定する
docker run -v $1:/var/log/nginx -p 3000:80 -e TZ=Asia/Tokyo -u root --name docs_web -d --restart always -it docs_web

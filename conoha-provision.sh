#!/bin/bash

# conoha api reference
# https://www.conoha.jp/docs/

# TODO: jq コマンドを事前導入すること
# https://jqlang.github.io/jq/
# https://zenn.dev/easy_easy/articles/e47b37b04dd1153d5b29

ENV_FILE=./conoha-api-env.txt

source $ENV_FILE

# $TOKENを取得し、ENV_FILE に書き込む
createToken () {
	RES=$(
		curl -s POST \
		-H "Accept: application/json" \
		-d'{"auth":{"passwordCredentials":{"username":"'$USER_NAME'","password":"'$PASSWORD'"},"tenantId":"'$TENANT_ID'"}}' \
		"https://identity.tyo3.conoha.io/v2.0/tokens"
	)
	# env に書き込みファイルを再読み込みする
	if [ ! "$(cat $ENV_FILE | grep TOKEN= )" ] ;then
		echo TOKEN=$(echo $RES | jq ".access.token.id" -r) >> $ENV_FILE
	else
		sed -i 's/TOKEN.*$/'TOKEN=$(echo $RES | jq ".access.token.id" -r)'/g' $ENV_FILE
	fi
	source $ENV_FILE
	echo new token: $TOKEN
}
# 参照するイメージIDを取得し、ENV_FILE に書き込む
getRefImageId () {
	IMAGE_ID=$(
		curl -s GET \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		"https://image-service.tyo3.conoha.io/v2/images" \
		| jq '.images[] | select(.name | contains("'$IMAGE_TAG_NAME'")) | .id' -r
	)
	# env に書き込みファイルを再読み込みする
	if [ ! "$(cat $ENV_FILE | grep IMAGE_REF_ID= )" ] ;then
		echo IMAGE_REF_ID=${IMAGE_ID} >> $ENV_FILE
	else
		sed -i 's/IMAGE_REF_ID.*$/'IMAGE_REF_ID=${IMAGE_ID}'/g' $ENV_FILE
	fi
	source $ENV_FILE
	echo ref image id: $IMAGE_REF_ID
}

getVmPlans () {
	RES=$(
		curl -s GET \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		https://compute.tyo3.conoha.io/v2/"$TENANT_ID"/flavors \
	| jq '.flavors[]| [.name, .id]'
	)
	echo vm plans: "$RES"
}
# 開発環境 vm id を取得し、ENV_FILE に書き込む
getVmId () {
	createToken
	CURRENT_VM_ID=$(
		curl -s GET \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		https://compute.tyo3.conoha.io/v2/"$TENANT_ID"/servers/detail \
		| jq '.servers[] | select(.metadata.instance_name_tag | test("^vps.*work$")) | .id' -r
	)
	echo current vm id: "$CURRENT_VM_ID"
	# env に書き込みファイルを再読み込みする
	if [ ! "$(cat $ENV_FILE | grep VM_ID= )" ] ;then
		echo VM_ID=${CURRENT_VM_ID} >> $ENV_FILE
	else
		sed -i 's/VM_ID.*$/'VM_ID=${CURRENT_VM_ID}'/g' $ENV_FILE
	fi
	source $ENV_FILE
	echo current vm id: ${VM_ID}
}

################## VM アクション一覧 ######################
vmActoin () {

	createToken

	echo vps-$(echo $DATE)-work
	# createToken
	# 起動 or シャットダウン
	if [ $VM_ACTION_TYPE = start ] || [ $VM_ACTION_TYPE = stop ];then
		echo start or stop vm id: ${VM_ID}
		curl -i -X POST \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		-d '{"os-'$VM_ACTION_TYPE'": null}' \
		https://compute.tyo3.conoha.io/v2/"$TENANT_ID"/servers/${VM_ID}/action \

	# SOFT or HARD 通常停止からの起動(SOFT) or 強制停止からの起動(HARD)
	elif [ $VM_ACTION_TYPE = reboot ];then
		echo reboot vm id: ${VM_ID}
		curl -i -X POST \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		-d '{"reboot": {"type": "SOFT"}}' \
		https://compute.tyo3.conoha.io/v2/"$TENANT_ID"/servers/${VM_ID}/action \

	# 削除
	elif [ $VM_ACTION_TYPE = delete ];then
    read -n1 -p "VMサーバー開発環境を削除しようとしています。実行しますか? (y/N): " yn
    if [[ $yn != [yY] ]]; then
      echo "\n"
      echo "キャンセルしました。"
      exit 1
    fi
		echo delete vm id: ${VM_ID}
		curl -i -X DELETE \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		https://compute.tyo3.conoha.io/v2/"$TENANT_ID"/servers/${VM_ID} \

	# 追加
	elif [ $VM_ACTION_TYPE = add ];then
    read -n1 -p "VMサーバー開発環境を追加しようとしています。実行しますか? (y/N): " yn
    if [[ $yn != [yY] ]]; then
      echo "\n"
      echo "キャンセルしました。"
      exit 1
    fi

		getRefImageId

		NEW_VM_ID=$(
			curl -s POST \
			-H "Accept: application/json" \
			-H "X-Auth-Token: "$TOKEN"" \
			-d '{
						"server":
						{
							"imageRef":	"'$IMAGE_REF_ID'",
							"flavorRef": "'$FLAVOR_REF'",
							"security_groups": [
								{ "name": "gncs-ipv4-all" }
							],
							"metadata": {
								"instance_name_tag": "vps-'$(echo $DATE)'-work"
							}
						}
					}' \
			https://compute.tyo3.conoha.io/v2/"$TENANT_ID"/servers \
			| jq '.server.id' -r
		)
		# env に書き込みファイルを再読み込みする
		if [ ! "$(cat $ENV_FILE | grep VM_ID= )" ] ;then
			echo VM_ID=$(echo $NEW_VM_ID) >> $ENV_FILE
		else
			sed -i 's/VM_ID.*$/'VM_ID=$(echo $NEW_VM_ID)'/g' $ENV_FILE
		fi
		source $ENV_FILE
		echo new vm id: ${VM_ID}

		# VM が起動されるまで待つ
		sleep 15
		setDmainIpAddr

	else
		echo "type not found."
	fi
}

getVmIpAddr () {
	# createToken
	NEW_VM_IP_ADDR=$(
		curl -s POST \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		https://compute.tyo3.conoha.io/v2/"$TENANT_ID"/servers/${VM_ID} \
		| jq '.server.addresses[] | .[]
			| select(.addr | test("^[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}$")) | .addr' -r
	)

	# env に書き込みファイルを再読み込みする
	if [ ! "$(cat $ENV_FILE | grep VM_IP_ADDR= )" ] ;then
		echo VM_IP_ADDR=$(echo $NEW_VM_IP_ADDR) >> $ENV_FILE
	else
		sed -i 's/VM_IP_ADDR.*$/'VM_IP_ADDR=$(echo $NEW_VM_IP_ADDR)'/g' $ENV_FILE
	fi
	source $ENV_FILE
	echo use vm ip address: ${VM_IP_ADDR}
}

setDmainIpAddr () {

	getVmIpAddr

	domainId=$(
		curl -s GET \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		https://dns-service.tyo3.conoha.io/v1/domains \
		| jq '.domains[] | select(.name | contains("'$TARGET_DOMAIN'")) | .id' -r
	)
	echo target domain id: ${domainId}

	domainrecordIds=$(
		curl -s GET \
		-H "Accept: application/json" \
		-H "X-Auth-Token: "$TOKEN"" \
		https://dns-service.tyo3.conoha.io/v1/domains/${domainId}/records \
		| jq -r '.records[] | select(.ttl != null) | select (.ttl | contains(60))
		| [.id] | @csv' --raw-output
	)
	echo target domain record id: "$domainrecordIds"
	domainrecordIds=(${domainrecordIds//,/ })
	for v in "${domainrecordIds[@]}"
	do
		id=$(echo $v | jq '.' -r)
		curl --include https://dns-service.tyo3.conoha.io/v1/domains/"${domainId}"/records/"${id}"\
			-X PUT \
			-H "Accept: application/json" \
			-H "Content-Type: application/json" \
			-H "X-Auth-Token: "$TOKEN"" \
			-d '{"data": "'$VM_IP_ADDR'"}'
	done
}

usage () {
echo $1
cat <<_EOF_
Usage:
$(basename $0) [OPTION]

Description:
"$(pwd)" のconoha API用プロビジョンスクリプトです。

Options:
-s setDmainIpAddr を実行します。VM追加時にタイミングによっては、domain にIPアドレスが更新されない場合がある。更新されない場合はこちら。
-v vmActoin を実行します。引数によって VM の start, stop, reboot, add を実行します。
-h ヘルプを表示します。
-pb build 時に実行環境(本番環境)を指定します。
-wb build 時に実行環境(開発環境)を指定します。
-lb build 時に実行環境(ローカル環境)を指定します。

_EOF_

exit 0
}

DATE=`date +'%Y-%m-%d-%H-%M'`

#サーバー性能タイプ("g-c2m1d100","ab7b9b6d-108c-4487-90a4-2da604ad6a92") 1GB 1,064 円/月 CPU 2Core SSD 100GB
FLAVOR_REF='ab7b9b6d-108c-4487-90a4-2da604ad6a92'
#保存イメージタグ名
IMAGE_TAG_NAME=20230816
#VMアクションタイプ
VM_ACTION_TYPE=
#対象ドメイン
TARGET_DOMAIN="night-planet.work"

while getopts :sv:h OPT
do
case $OPT in
	s ) setDmainIpAddr;;
	v )
			VM_ACTION_TYPE=$(echo $OPTARG)
		  vmActoin;;
	h ) usage;;
	p ) EXE_ENV='prod';;
	w ) EXE_ENV='work';;
	l ) EXE_ENV='local';;
	:|\? ) usage;;
esac
done
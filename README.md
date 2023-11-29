# Night Planet (ナイトプラネット)

## 概要
- ナイト情報提供ポータルサイト
[本番サイトはこちら](https://night-planet.com/)
- ナイトプラネットは、沖縄県の飲み屋街の活性化を目的とポータルサイトです。

## 事前準備
### Composer インストール
[Composer 公式サイト](https://getcomposer.org/)
- インストール確認
```
composer -V
```
### Docker インストール
[Docker 公式サイト](https://www.docker.com/products/docker-desktop/)
- インストール確認
```
docker --version
```
## インストール手順
ターミナルにて操作

- クローンするディクレトリ作成
```
mkdir apps
```
- GitHub からプロジェクトをクローン
```
git clone https://github.com/engineer-mogura/night-planet.git night-planet
```

- コンポーサーをインストール ※composer.json の動階層で実行
```
composer install
```

注) ビルド前に必要な設定ファイル、各初期データをプロジェクトマネージャーから連携してください。<br>
- Docker コンテナビルド ※シェル内部で自動実行します
```
sh dockerops.sh -lb
```
- ローカル環境アクセス
[http://night-planet.local/](http://night-planet.local/)


## デバッグ環境
- VS Code 拡張プラグイン Xdebugで構築済です
- apps 直下に night-planet.code-workspace がありますので、ローカルにPHPをインストールし実行環境を整えてください。
- バージョンはPHP 7.4 系を推奨します。
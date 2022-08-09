# About

## ローカル開発前提

  **以下のコマンドはserver/配下に実施します**

* Docker コンテナを準備する
  ```
  make build
  ```

## 開発

### vendorにPackageインストール
```
make composer-install

### サーバーを立ち上げる
```
make upd
```

docker-compose.yml で build target が debug になっているので、すぐに vscode で debug を実行することができるようになっています。

### サーバーの停止
```
make down
```

## IDE によるコード補完についての導入メモ

### 導入した時のコマンド

```shell script
$ composer require --dev barryvdh/laravel-ide-helper
$ composer require --dev doctrine/dbal
```

### Facade の補完

```shell script
$ php artisan ide-helper:generate
```

`server` ディレクトリ直下に `_ide_helper.php` が生成された。

### Model の補完

全部に適用するときは、

```shell script
$ php artisan ide-helper:model
```

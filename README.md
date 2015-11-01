# Test
## 準備

* データベース作成
```sh
$> vagrant up
```

* ライブラリインストール
```sh
$> composer install
```

* コンソールからMySQL接続
```sh
$> mysql -h 192.168.0.206 --port 3306 -u mysql -p
```

* コンソールからPostgreSQL接続
```sh
$> psql -h 192.168.0.206 -U postgres sandbox
```

## PHPUnit
```sh
$> vendor/bin/phpunit Test/hoge.php

```

## Phing
```sh
$> vendor/bin/phing -f Test/build.xml
```

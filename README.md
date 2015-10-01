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
$> mysql -h 192.168.0.205 --port 3306 -u mysql -p
```

* コンソールからPostgreSQL接続
```sh
TODO
```

## PHPUnit
```sh
$> vendor/phpunit/phpunit/phpunit Test/hoge.php

```

## Phing
```sh
$> vendor/phing/phing/bin/phing -f Test/build.xml
```

# imageを指定
FROM php:7.2-fpm
# fileのcopy。local => container。
COPY php.ini /usr/local/etc/php/

# cmdの実行
# apt-get => Debian系(Ubuntuなど)のpackage管理cmd。
# インストール可能なpackageのリストを更新する(あくまでリストの更新。packageの更新ではない)。
RUN apt-get update \
  # packageのinstall
  # -y => 問い合わせがあった場合はすべて「yes」とする。これにより処理が止めず実行できる。
  && apt-get install -y \
  less \
  zip \
  unzip \
  # fileの圧縮関連のライブラリ
  zlib1g-dev \
  # dbクライアント
  mariadb-client \
  # lessの日本語文字化けを抑止
  && echo "export LESSCHARSET=utf-8" >> ~/.bashrc \
  # PDOをinstall
  # PDO(PHP Data Objects) => データベース抽象化レイヤ。phpとdbの仲介役。
  && docker-php-ext-install zip pdo_mysql

# Composer install
# dockerのmulti-stage buildsを使用。docker version >=17.05 が必須。
# dockerのcomposer(latest) imageから /usr/bin/composer だけをcopyし、containerに配置する。
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 環境変数のdefault値を指定。
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# dirの移動。imageの生成はコンテナの停止と起動が繰り返されるので、cdでは階層を保持できない。
WORKDIR /var/www

# Laravelインストーラをダウンロード
RUN composer global require "laravel/installer"

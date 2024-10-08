# アプリケーション名
Atte - 勤務時間管理システム

[トップ画像](https://github.com/thankschiemi/atte0729/blob/main/atte.png)
atte.png

## 作成した目的
従業員の勤怠管理をシンプルに行うためのWebアプリケーションです。

## アプリケーションURL
[http://3.107.96.14](http://3.107.96.14)

## 使用技術（実行環境）
- Laravel 8.x
- PHP 7.4
- MySQL 8.x
- Nginx
- Node.js 14.x or higher
- Composer 2.x
- Amazon Linux 2023

## 機能一覧
- ユーザー登録、ログイン
- 勤務開始/終了の打刻
- 休憩開始/終了の打刻
- 勤務時間の表示と集計

## テーブル設計

[テーブル設計](https://github.com/thankschiemi/atte0729/blob/main/image.png)

## ER図

[ER図](https://github.com/thankschiemi/atte0729/blob/main/index.drawio.png)
index.drawio.png

## 環境構築手順
他の人でもプロジェクトを実行できるようにするためのコマンドや構成ファイルを記載
1. リポジトリをクローンする
2. `.env`ファイルを設定する
3. `php artisan migrate` を実行してデータベースを構築

## テスト結果について
一部の機能に対して自動テストが失敗していますが、これらは主にテスト環境のモックに関連する問題です。
実際のブラウザでの動作確認はすべて正常に行われ、主要な機能（会員登録、ログイン、認証メール、打刻機能など）はすべて動作しています。

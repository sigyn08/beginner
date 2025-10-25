# フリマアプリ
<h2>環境構築</h2>
<h3>Dockerビルド</h3>
<h4>・git clone git@github.com:sigyn08/beginner.git</h4>
<h4>・docker-compose up -d --build</h4>
<h3>Laravel環境構築</h3>
<h4>docker-compose exec php bash</h4>
<h4>composer install</h4>
<h4>cp .env.example .env</h4>
<h4>php artisan key:generate</h4>
<h4>php artisan migrate</h4>
<h4>php artisandb:seed</h4>
<h2>使用技術（実行環境）</h2>
<H4>Laravel 8.83.29</H4>
<h4>PHP 8.2.29</h4>
<h4>MySQL 8.0.26</h4>
<h4>nginx 1.21.1</h4>
<h2>開発環境</h2>
<h4>トップ画面：http://localhost/</h4>
<h4>phpMyAdmin：http://localhost:8080/index.php</h4>
<h3>ダミーアカウント</h3>
<h4>name:テストユーザー</h4>
<h4>email:test@example.com</h4>
<h4>password:password</h4>

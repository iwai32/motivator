<?php
//関数読み込み
require('./functions.php');
debug('「「「「「「「「「');
debug('トップページ');
debug('」」」」」」」」」');
debugLogStart();

if (!empty($_POST)) {
  //postチェック
  debug('POST送信があります' . print_r($_POST, true));

  $name = escape($_POST['name']);
  $email = escape($_POST['email']);
  $password = escape($_POST['password']);
  //バリデーション
  debug('バリデーション開始');
  //name
  validateMaxLength($name, 'name');

  //email
  validateRequired($email, 'email');
  validateTypeEmail($email, 'email');
  validateMaxLength($email, 'email');
  validateDuplicateEmail($email, 'email');

  //password
  validateRequired($password, 'password');
  validateHalf($password, 'password');
  validateMaxLength($password, 'password');
  validateMinLength($password, 'password');

  var_dump($err_msg);

  if (empty($err_msg)) {
    debug('バリデーション成功');
    debug('ユーザー登録開始');
    try {
      $dbh = dbConnect();
      $sql = 'INSERT INTO users (name, email, password, created_at) values(:name, :email, :password, :date)';
      $data = [
        ':name' => $name,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT), //bcryptアルゴリズムによるhash化
        ':date' => date("Y-m-d H:i:s")
      ];

      $stmt = queryPost($dbh, $sql, $data);

      if($stmt) {
        debug('ユーザー登録完了');
        //ログイン扱いにする(ログイン時間をタイムスタンプで格納)
        $_SESSION['login_date'] = time();
        //ログインの有効期限を設定※1ヶ月
        $_SESSION['login_limit'] = 60 * 60 * 24 *30;
        $_SESSION['user_id'] = $dbh->lastInsertId();

        debug('セッションの中身:' . print_r($_SESSION, true));
        
        header('location:index.php');
        exit();
      }

    } catch (Exception $e) {
      debug('エラー発生' . $e->getMessage());
      $err_msg['common'] = SYS01;
    }
  }
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Motivatorへようこそ</title>
</head>

<body>
  <div class="top-wrapper">
    <div class="top-inner">
      <div class="top-title">
        <h1 class="welcome-to-history-bag">Motivator<span>へようこそ</span></h1>
        <p class="history-bag-details">日々の学習を記録し、見える化します。あなたのモチベーションを応援します。</p>
      </div>

      <div class="signup-wrapper">
        <form class="normal-signup-form" action="" method="post">
          <div class="form-group">
            <label class="form-group__label" for="user_name">ユーザ名
              <input class="form-group__input" id="user_name" name="name" type="text">
            </label>
          </div>

          <div class="form-group">
            <label class="form-group__label" for="email">メールアドレス
              <input class="form-group__input" id="email" name="email" type="text" required>
            </label>
          </div>

          <div class="form-group">
            <label class="form-group__label" for="password">パスワード
              <input class="form-group__input" id="password" name="password" type="password" required>
            </label>
          </div>

          <div class="normal-signup-form__btn-area">
            <button class="btn">登録する</button>
          </div>
        </form>
      </div>

      <p class="top-signin">既に登録済みの方はこちらで<a class="top-signin__link" href="./login.php">サインイン</a>してください</p>
    </div>
  </div>
  <!--.top-wrapper-->
</body>

</html>
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
      <form class="normal-signup-form" action="{{ route('user.signup') }}" method="post">
        <div class="form-group">
          <label class="form-group__label" for="user_name">ユーザ名</label>
          <input class="form-group__input" id="user_name" name="name" type="text" required>
        </div>

        <div class="form-group">
          <label class="form-group__label" for="email">メールアドレス</label>
          <input class="form-group__input" id="email" name="email" type="email" required>
        </div>

        <div class="form-group">
          <label class="form-group__label" for="password">パスワード</label>
          <input class="form-group__input" id="password" name="password" type="password" required>
        </div>

        <div class="normal-signup-form__btn-area">
          <button class="btn">登録する</button>
        </div>
      </form>
    </div>
    
    <p class="top-signin">既に登録済みの方はこちらで<a class="top-signin__link" href="{{ route('user.signinPage') }}">サインイン</a>してください</p>
    </div>
  </div><!--.top-wrapper-->
</body>
</html>
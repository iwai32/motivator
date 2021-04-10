<?php
if(!empty($_SESSION['login_date'])) {
  if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()) {
    debug('有効期限が切れています。');
    session_destroy();
    header('Location:login.php');
    exit;
  } else {
    debug('有効期限内ユーザーです。');
    $_SESSION['login_date'] = time();
    if(basename($_SERVER['PHP_SELF']) === 'login.php') {
      header('Location:mypage.php');
      exit;
    }
  }
} else {
  debug('未ログインユーザーです');
  if(basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header('Location:login.php');
    exit;
  }
}
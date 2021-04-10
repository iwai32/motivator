<?php
//ログを取得
ini_set('log_errors', 'on');
//ログの出力ファイルを指定
ini_set('error_log', 'php.log');


//ログの出力フラグ
$debug_flg = true;
function debug($str)
{
  global $debug_flg;

  if ($debug_flg) {
    error_log('デバッグ:' . $str);
  }
}
//セッションの設定
//セッションの有効期限変更のため、保存先を変更する
session_save_path('/var/tmp/');
//セッションの有効期限を1ヶ月後に設定
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
//ブラウザを閉じてもセッションを削除しない。またcookieも同様に有効期限を1ヶ月後に設定
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
//セッション開始
session_start();
//セッションidの再生成(なりすまし防止)
session_regenerate_id();

function debugLogStart()
{
  debug('>>>>>>>>>>>>>>画面表示開始');
  debug('セッションid:' . session_id());
  debug('セッションの中身:' . print_r($_SESSION, true));
  debug('現在日時のタイムスタンプ' . time());

  //ログイン済みなら有効期限を表示する
  if (!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])) {
    debug('有効期限タイムスタンプ' . ($_SESSION['login_date'] + $_SESSION['login_limit']));
  }
}

//バリデーション
//エラーメッセージ格納用配列
$err_msg = [];
//メッセージ定数
define('MSG01', '入力必須です');
define('MSG02', 'Email形式で入力してください');
define('MSG03', '半角英数字で入力してください');
define('MSG04', '文字以内で入力してください');
define('MSG05', '文字以上で入力してください');
define('MSG06', '既にEmailが登録されています');
define('SYS01', 'システムエラーがおきました、再度時間を置いてからお試しください');
//ルール
//入力必須
function validateRequired($str, $key)
{
  //todo 数値に使用し、0の場合どうするか考える
  if (empty($str)) {
    global $err_msg;
    $err_msg[$key] = MSG01;
  }
}

//email形式チェック
function validateTypeEmail($str, $key)
{
  if (!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $str)) {
    global $err_msg;
    $err_msg[$key] = MSG02;
  }
}

//半角英数字
function validateHalf($str, $key)
{
  if (!preg_match('/^[a-zA-Z0-9]+$/', $str)) {
    global $err_msg;
    $err_msg[$key] = MSG03;
  }
}

//最大文字数
function validateMaxLength($str, $key, $max = 255)
{
  if (mb_strlen($str, 'UTF-8') > $max) {
    global $err_msg;
    $err_msg[$key] = $max . MSG04;
  }
}

//最小文字数
function validateMinLength($str, $key, $min = 8)
{
  if (mb_strlen($str, 'UTF-8') < $min) {
    global $err_msg;
    $err_msg[$key] = $min . MSG05;
  }
}


//Eメール重複チェック
function validateDuplicateEmail($str, $key)
{
  global $err_msg;

  try {
    $dbh = dbConnect();
    $sql = 'SELECT count(*) as count FROM users WHERE deleted_at IS NULL AND email = :email';
    $data = [
      ':email' => $str
    ];

    $stmt = queryPost($dbh, $sql, $data);
    $result = $stmt->fetch();

    //emailが既に登録されているならエラーメッセージを格納
    if (!empty(array_shift($result))) {
      $err_msg[$key] = MSG06;
    }
  } catch (PDOException $e) {
    debug('db接続エラー' . $e->getMessage());
    $err_msg['common'] = SYS01;
  }
}

//DB接続
function dbConnect()
{
  try {
    $dsn = 'mysql:dbname=motivator;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = 'root';
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
    ];

    return $pdo = new PDO($dsn, $user, $password, $options);
  } catch (PDOException $e) {
    debug('db接続エラー' . $e->getMessage());
    global $err_msg;
    $err_msg['common'] = SYS01;
  }
}

//SQL実行
function queryPost($dbh, $sql, $data = [])
{
  //トランザクション処理をする
  //$dbh->beginTransaction();
  //$dbh->commit();
  //$dbh->rollBack();
  $stmt = $dbh->prepare($sql);
  //ERRMODE_SILENTにしてるので、execute時、真偽値で接続の確認をする必要がある。
  if (!$stmt->execute($data)) {
    debug('sqlの実行に失敗しました、実行SQL:' . $sql);
    global $err_msg;
    $err_msg['common'] = SYS01;
    return 0;
  }

  return $stmt;
}

//フォーム入力データを保持する
function getFormData()
{

}

//XSS防止処理
function escape($str)
{
  return htmlspecialchars($str, ENT_QUOTES);
}

#### ユーザテーブル(users)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | ユーザid   |  id  |  integer  |  ×  |    |    | 
|  2  |  ユーザ名  |  name  |  varchar  |  ○  |    |    | 
|  3  |  メールアドレス  |  email  |  varchar  |  ×  |    |    | 
|  4  |  パスワード  |  password  |  varchar  |  ×  |   |    | 
|  5  |  プロフィール画像  |  my_icon  |  varchar  |  ○  |  |    | 
|  6  |  メッセージ  |  message  |  text  |  ○  |   |    | 
|  7  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  8  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  9  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>

#### カテゴリテーブル(categories)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | カテゴリid   |  id  |  integer  |  ×  |    |    | 
|  2  |  カテゴリ名  |  name  |  varchar  |  ×  |    |    | 
|  3  |  イメージ色  |  image_color  |  varchar  |  ×  |    |    | 
|  4  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  5  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  6  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>

#### レポートテーブル(reports)

|  #  |  論理名  |  物理名  |  データ型  |  NULL  |  デフォルト値  |  コメント | 
| ---- | ---- | ---- | ---- | ---- | ---- | ---- | 
|  1  | レポートid   |  id  |  integer  |  ×  |    |    | 
|  2  |  ユーザid  |  user_id  |  integer  |  ×  |    |    | 
|  3  |  カテゴリid  |  category_id  |  integer  |  ×  |    |    | 
|  4  | ポイント   |  point  |  varchar  |  ×  |    |    | 
|  5  |  投稿日  |  posted_date  |  datetime  |  ×  |    |    | 
|  6  |  学習時間  |  study_time  |  integer  |  ×  |    |  時間をミリ秒で格納  | 
|  7  |  削除日  |  deleted_at  |  timestamp  |  ○  |    |    | 
|  8  |  作成日  |  created_at  |  timestamp  |  ○  |    |    | 
|  9  |  更新日  |  updated_at  |  timestamp  |  ○  |    |    | 

<br>
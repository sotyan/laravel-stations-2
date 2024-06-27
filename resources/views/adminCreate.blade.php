<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    <h1>新規登録画面</h1>
    <form action="/admin/movies/store" method="post">
        @csrf
        <div>
            <label for="title">映画タイトル：</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="image_url">画像URL：</label>
            <input type="text" name="image_url" id="image_url"> 
        </div>
        <div>
            <label for="published_year">公開年：</label>
            <input type="num" name="published_year" id="published_year">
        </div>
        <div>
            <label for="is_showing">公開中かどうか：</label>
            <input type="hidden" name="is_showing" value="0">
            <input type="checkbox" name="is_showing" id="is_showing" value="1">
            <!-- チェックボックスが入ってない時は０、入ってたら１を返す
            booleanはtrue,false,0,1で受け取るから、初期のチェックボックスではonが返される（dd()で送信内容確認）  -->
        </div>
        <div>
            <label for="description">概要：</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <label for="genre">ジャンル：</label>
            <input type="text" name="genre" id="genre">
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>
    @if(session('err_msg'))
	<div>
		{{ session('err_msg') }}
	</div>
@endif
</body>
</html>
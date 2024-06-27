<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
    <link rel="stylesheet" href="/css/index.css" type="text/css">
</head>
<body>
    <h1>映画作品リスト</h1>
    <form action="/movies" method="get">
        <div class="keyword">
            <label for="keyword">キーワード</label>
            <input type="text" name="keyword" id="keyword" value="{{ $keyword ?? '' }}">
        </div>
        <div class="is_showing"> 
            <label for="all">全て</label>
            <input type="radio" name="is_showing" id="all" value="2" {{ $is_showing == 2 ? 'checked' : ''}}>    
            <label for="upcoming">公開予定</label>
            <input type="radio" name="is_showing" id="upcoming" value="0" {{ $is_showing == 0 ? 'checked' : ''}}>
            <label for="showing">公開中</label>
            <input type="radio" name="is_showing" id="showing" value="1" {{ $is_showing == 1 ? 'checked' : ''}}>
        </div>
        <button type="submit">検索</button>
    </form>

    <ul>
    @foreach($movies as $movie)
        <li>映画タイトル：{{ $movie->title }}</li>
        <li>画像URL:{{ $movie->image_url }}</li>
    @endforeach
    </ul>
    <div class="pagination">
        {{ $movies->links() }}
    </div>
</body>
</html>
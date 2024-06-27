<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>adminEdit</title>
</head>
<body>
    <h1>映画一覧</h1>
    <button><a href="/admin/movies/create">追加</a></button>
    <button><a href="/admin/schedules">スケジュール一覧</a></button>
    <table border="1">
        <tr>
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>ジャンル</th>
            <th>編集</th>
            <th>削除</th>
            <th>詳細</th>
            <th>管理者詳細</th>
        </tr>
        @foreach($movies as $movie)
            <tr>
                <td>{{ $movie->title }}</td>
                <td>{{ $movie->image_url }}</td>
                <td>{{ $movie->published_year }}</td>
                @if ($movie->is_showing) <td>上映中</td>
                @else<td>上映予定</td>
                @endif
                <td>{{ $movie->description }}</td>
                <td>
                   {{$movie->genre->name}}
                   <!-- {{ $movie->genre_id}} -->
                </td>
                <!-- <td>{{ $movie->genre_id }}</td> -->
                <!-- 以下の部分でidを取得する -->
                <td><a href="{{route('edit',['id' => $movie->id])}}">編集</a></td>
                <td>
                    <!-- 削除するときはaタグではだめ、formを使う -->
                    <form action="{{route('destroy',['id' => $movie->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="削除" onclick='return confirm("OK")'>
                    </form>
                </td>
                <td><a href="{{route('detail',['id' => $movie->id])}}">詳細</a></td>
                <td><a href="{{route('adminDetail',['id' => $movie->id])}}">管理者詳細</a></td>
                
            </tr>
        @endforeach
    </table>
    @if(session('err_msg'))
	<div>
		{{ session('err_msg') }}
	</div>
    @endif
</body>
</html>
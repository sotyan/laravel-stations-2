<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>adminEdit</title>
</head>
<body>
    <h1>映画詳細</h1>
    <p>タイトル：{{ $movie->title }}</p>
    <p>ID：{{ $movie->id }}</p>
    <img src="{{ $movie->image_url }}">
    <p>公開年：{{ $movie->published_year }}</p>
    <p>公開中？：{{ $movie->is_showing ? '公開中' : '未公開'}}</p>
    <p>概要：{{ $movie->description }}</p>
    <p>作成日時：{{ $movie->created_at }}</p>
    <p>更新日時：{{ $movie->updated_at }}</p>
    <p>ジャンル：{{ $movie->genre->name }}</p>
    <p>上映スケジュール</p>

    @foreach ($schedules as $schedule)
        <p>{{ $schedule->start_time}} ~ {{ $schedule->end_time }}</p>
        <a href="{{ route('movieSheet', ['movie_id' => $movie->id , 'schedule_id' => $schedule->id ]). '?date=' . $schedule->start_time->format('Y-m-d') }}">座席を予約する</a>
        </p>
    @endforeach

    
</body>
</html>
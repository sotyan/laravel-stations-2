<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>adminEdit</title>
</head>
<body>
    <h1>スケジュール一覧</h1>
    @foreach ($movies as $movie)
        <h2>{{ $movie->id }}:{{ $movie->title }}</h2>
        @foreach ($movie->schedules as $schedule)
            <li>
                <a href="{{route('schedulesshow', ['id' => $movie->id])}}">{{$schedule->start_time}} ~ {{ $schedule->end_time }}</a>
            </li>
        @endforeach
    @endforeach
        
</body>
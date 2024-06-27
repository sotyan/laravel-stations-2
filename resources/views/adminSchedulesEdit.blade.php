<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>adminEdit</title>
</head>
<body>
    <h1>スケジュールの更新</h1>
    現在のスケジュール
    {{ $schedules->start_time }} ~ {{ $schedules->end_time }}

    <form action="{{ route('adminUpdateSchedules', ['id' => $schedules->id]) }}" method="post">
    @csrf
    @method('patch')
    <div>
        <label for="movie_id">映画ID:</label>
        <!-- // rendoryで変更できないよう -->
        <input type="text" name="movie_id" value="{{ $schedules->movie_id }}" readonly>
    </div>
    <div>
        <label for="start_time_date">開始日付:</label>
        <input type="date" id="start_time_date" name="start_time_date" value="{{ $schedules->start_time }}">
    </div>
    <div>
        <label for="start_time_time">開始時間:</label>
        <input type="time" id="start_time_time" name="start_time_time" value="{{ $schedules->start_time }}">
    </div>

    <div>
        <label for="end_time_date">終了日付:</label>
        <input type="date" id="end_time_date" name="end_time_date" value="{{ $schedules->end_time }}">
    </div>
    <div>
        <label for="end_time_time">終了時間時間:</label>
        <input type="time" id="end_time_time" name="end_time_time" value="{{ $schedules->end_time }}">
    </div>
    <div>
        <button type="submit">変更</button>
     </div>
    </form>
</body>


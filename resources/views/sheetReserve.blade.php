<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>

<body>
    <h1>座席予約</h1>

    <form action="/admin/movies/{id}/schedules/store" method="post">
        @csrf
        <div>
            <label for="name">予約者名:</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="email">メールアドレス:</label>
            <input type="email" id="email" name="email">
        </div>
        <p>予約内容</p>
        <div>
            <label for="schedule_id">スケジュールID:</label>
            <input type="text" id="schedule_id" name="schedule_id" value="{{ $schedule->id }}" readonly>
        </div>
        <div>
            <label for="sheet_id">座席ID:</label>
            <input type="text" id="sheet_id" name="sheet_id" value="{{ $sheet }}" readonly>
        </div>
        <div>
            <label for="date">日時:</label>
            <input type="date" id="date" name="start_time_time" value="{{ $date }}" readonly>
        </div>
        <div>
            <button type="submit">登録</button>
        </div>
    </form>
</body>
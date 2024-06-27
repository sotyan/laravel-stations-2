<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>adminEdit</title>
</head>
<body>
    <h1>スケジュール</h1>
    <a href="{{route('adminSchedulesCreate', ['id' => $movie->id])}}">スケジュールの追加</a><br>
    




    <table border="1">
        <tr>
            <th>スケジュールID</th>
            <th>開始時刻</th>
            <th>終了時刻</th>
            <th>作成日時</th>
            <th>更新日時</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
        @foreach ($schedules as $schedule)
            <tr>
                <td>{{ $schedule->id }}</td>
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                <td>{{ $schedule->created_at }}</td>
                <td>{{ $schedule->updated_at }}</td>
                <td><a href="{{route('adminSchedulesEdit', ['id' => $schedule->id])}}">編集</a></td>
                <td>
                    <form action="{{route('destroySchedules',['id' => $schedule->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" value="削除" onclick='return confirm("OK")'>
                    </form>
                </td>
                
            </tr>
        @endforeach
    </table>



    
    
                </td>
    
</body>
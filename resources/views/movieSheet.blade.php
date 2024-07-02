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
<h1>座席表</h1>
<table border="1">
    <tbody>
        @foreach($sheets as $sheet)
        <tr>
            <td>{{ $sheet->id }}</td>
            <td><a href="{{ route('sheetReserve', ['movie_id' => $movie->id , 'schedule_id' => $schedule->id]) . '?date=' . $date . '&sheet_id=' . $sheet->id}}">{{ $sheet->row }}-{{ $sheet->column }}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
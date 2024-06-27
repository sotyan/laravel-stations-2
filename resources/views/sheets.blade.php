<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>座席表</h1>


    <table border="1">
        <tbody>
            @foreach($sheets as $sheet)
            <tr>
                <td>{{ $sheet->id }}</td>
                <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
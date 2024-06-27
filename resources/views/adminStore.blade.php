<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice</title>
</head>
<body>
    <h1>adminStore</h1>
    <li>タイトル: {{ $inputs['title'] }}</li>
    <li>画像URL：: {{ $inputs['image_url'] }}</li>
    <li>公開年：: {{ $inputs['published_year'] }}</li>
    <li>公開中かどうか：: {{ $inputs['is_showing'] }}</li>
    <li>概要：: {{ $inputs['description'] }}</li>
    
</body>
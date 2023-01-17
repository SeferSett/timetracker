<?php
use App\TimeTracker\Actions;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тайм трекер </title>
</head>
<body>
    @foreach($user as $us)
    @endforeach
    <p>Логин Пользователя: {{$us->name}}</p>
    <p>Почта пользователя: {{$us->email}}</p>
<form action="/user" method="post">
    <button type="submit" name="action" value="start">СТАРТ</button>
    <button type="submit" name="action" value="pause">ПАУЗА</button>
    <button type="submit" name="action" value="stop">СТОП</button>
    <br>
    @if (!is_null($timetrack))
        <table border="1">
            <tr>
            <th>ID пользователя</td>
            <th>Время начала</th>
            <th>Время окончания</th>
            <th>Время работы</th>
            </tr>
    @foreach($timetrack as $time)
            <tr>
            <td>ID пользователя: {{$time->user_id}}</td>
            <td>Время начала: {{date('H:i:s', $time->start_time)}}</td>
                @if (!empty($time->finish_time))
            <td>Время окончания: {{date('H:i:s', $time->finish_time)}}</td>
                @else
            <td>В данный момент вы работаете</td>
                @endif
                @if (!empty($time->finish_time))
            <td>Вы проработали:{{Actions::secondsToTime( $time->finish_time - $time->start_time)}}</td>
                @else
            <td>Таймер активен</td>
                @endif
            </tr>
    @endforeach
        </table>
    @endif
</form>
</body>
</html>


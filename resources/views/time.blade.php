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
    @if (!isset($user))
    @else
    @foreach($user as $us)
    @endforeach
    @endif
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
            <td>{{$time->user_id}}</td>
            <td>{{date('H:i:s', $time->start_time)}}</td>
                @if (!empty($time->finish_time))
            <td>{{date('H:i:s', $time->finish_time)}}</td>
                @else
            <td>В данный момент вы работаете</td>
                @endif
                @if (!empty($time->finish_time))
            <td>{{Actions::secondsToTime( $time->finish_time - $time->start_time)}}</td>
                @else
            <td>Таймер активен</td>
                @endif
            </tr>
    @endforeach
        </table>
    @endif
    @if (!is_null($work))
    <table  cellspacing="10" cellpadding="1" border="1" align="right">
                <tr>
                    <th>Сколько проработал</th>
                </tr>
                <th>Дата</th>
                <th>Время</th>
                @foreach($work as $value)
                    <tr>
                        <td>{{$value->dt}}</td>
                        <td>{{Actions::secondsTotime($value->time)}}</td>
                    </tr>
        @endforeach
    @endif

</form>
</body>
</html>


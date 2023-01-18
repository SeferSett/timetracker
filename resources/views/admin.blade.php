<?php
use App\TimeTracker\Actions;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика: Тайм трекер </title>
</head>
<body>
    @if (!isset($user))
    @else
    <table border="1">
        <tr><th>Данные о пользователях</th></tr>
        <tr>
            <th>Id пользователелей</th>
            <th>Имя пользователей</th>
            <th>Эмейл пользователей</th>
            <th>Cоздан</th>
            <th>Обновлен</th>

        </tr>
    @foreach($user as $us)
        <tr>
            <td>{{$us->id}}</td>
            <td>{{$us->name}}</td>
            <td>{{$us->email}}</td>
            <td>{{$us->created_at}}</td>
            <td>{{$us->updated_at}}</td>
        </tr>
    @endforeach
        </table>
    @endif
        <br>
    @if (!is_null($result))
    <table border="1">
        <tr>
        <th>Таблица статистики Всех </th>
        </tr>
        <tr>
            <th>Логин работника </th>
            <th>Айди работника</th>
            <th>Начальное время работы</th>
            <th>Пауза</th>
            <th>Окончательное время работы</th>
            <th>Сколько работал</th>
        </tr>
    @foreach($result as $elem)
        <tr>
            <td>{{$elem->name}}</td>
            <td>{{$elem->user_id}}</td>
            @if (!empty($elem->start_time))
                <td>{{date('H:i:s', $elem->start_time)}}</td>
            @else
                <td>{{null}}</td>
            @endif
            @if (!isset($elem->is_paused))
                <td>{{null}}</td>
            @else
                <td> {{$elem->is_paused}} </td>
            @endif
            @if (!empty($elem->finish_time))
                <td>finish_time:{{date('H:i:s', $elem->finish_time)}}</td>
            @else
                <td>В данный момент работает</td>
            @endif
            @if (!empty($elem->finish_time))
                <td>{{Actions::secondsToTime( $elem->finish_time - $elem->start_time)}}</td>
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
            <th>User</th>
            <th>Дата</th>
            <th>Время</th>
    @foreach($work as $value)
            <tr>
                <td>{{$value->user_id}}</td>
                <td>{{$value->dt}}</td>
                <td>{{Actions::secondsTotime($value->time)}}</td>
            </tr>
    @endforeach
        </table>
    @endif
</body>
</html>

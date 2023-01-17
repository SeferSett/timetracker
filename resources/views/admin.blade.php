<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика: Тайм трекер </title>
</head>
<body>
<th>Данные о пользователях</th>
    @foreach($user as $us)
        <table border="1">
            <tr>
                <td>Id пользователелей: {{$us->id}}</td>
                <td>Имя пользователей: {{$us->name}}</td>
                <td>Эмейл пользователей: {{$us->email}}</td>
                <td>Cоздан:  {{$us->created_at}}</td>
                <td>Обновлен: {{$us->updated_at}}</td>
            </tr>
    @endforeach
        </table>
        <br>
<table border="1">
    <th>Таблица статистики Всех :</th>
    @foreach($result as $elem)
        <tr>
            <td>user_id : {{$elem->id}}</td>
            <td>name : {{$elem->name}}</td>
            <td>user_id :{{$elem->user_id}}</td>
            <td>start_time: {{$elem->start_time}}</td>
            <td>is_paused: {{$elem->is_paused}}</td>
            <td>finish_time: {{$elem->finish_time}}</td>
            <td>next_id: {{$elem->next_id}}</td>
            <td>prev_id: {{$elem->prev_id}}</td>
            <td>Сколько проработал : {{date('H:m:s', $timeresult = $elem->finish_time - $elem->start_time)}}</td>
        </tr>
    @endforeach
</table>
</body>
</html>

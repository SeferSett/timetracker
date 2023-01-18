<?php

namespace App\Http\Controllers;
use App\TimeTracker\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TimeTracker\Actions AS TimeTrackerActions;

class TimeTrackingController extends Controller
{
    public function userPage()
    {
        $user_id = Auth::id();
        $obj = new TimeTrackerActions(DB::connection()->getPdo());
        if (!$obj->isStarted($user_id)){
        } else {
         //   echo 'Номер таймера:' . $obj->isStarted($user_id);
        }
        $timetrack = Actions::getTimetrack($user_id);
        $user = Actions::getUserInfo($user_id);

        $work = Actions::howDayWork($user_id);


        return view('time', [
        'user_id' => $user_id,
        'timetrack' => $timetrack,
        'user' => $user,
        'work' => $work,
    ]);
    }
    public function userAction()
    {
        $user_id = Auth::id();
        $action = filter_input(INPUT_POST, 'action');
        $track = new TimeTrackerActions(DB::connection()->getPdo());

        switch ($action){
            case 'start':
                $track->start($user_id);
                break;
            case 'pause':
                $track->pause($user_id);
                break;
            case 'stop':
                $track->stop($user_id);
                break;
            default:
                die('Неверное имя кнопки');
        }

        return redirect('/user');
    }
}

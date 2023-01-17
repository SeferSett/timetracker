<?php

namespace App\Http\Controllers;
use App\TimeTracker\Actions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function Admin()
    {
        $user_id = Auth::id();
        $user = Actions::Allusers();
        $admin = Actions::getAdmin($user_id);
        if (!empty($admin)) {

            $result = Actions::allTimersWithUser();
            return view('admin', [
                'result' => $result,
                'user' => $user,
            ]);
        }
       return  redirect('/dashboard' );
    }
}

// $admin = DB::select('SELECT user_id FROM admins a LEFT JOIN users u ON a.user_id=u.id');

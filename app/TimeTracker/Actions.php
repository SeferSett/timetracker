<?php

namespace App\TimeTracker;
use Illuminate\Support\Facades\DB;
class Actions
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function start($user_id)
    {
        $this->pdo->beginTransaction();
        if (!$this->isStarted($user_id)) {
            $prev_id = $this->isPaused($user_id);
            $stmt = $this->pdo->prepare('INSERT INTO timetrack (user_id, start_time, prev_id) VALUES (?,?,?)');
            $stmt->execute([$user_id, time(), $prev_id?:null]);
            if ($prev_id) {
                $id = $this->pdo->lastInsertId();
                $stmt = $this->pdo->prepare('UPDATE timetrack SET next_id=? WHERE id=?');
                $stmt->execute([$id, $prev_id]);
            }
        }
        $this->pdo->commit();
    }
    public function pause($user_id)
    {
        $stmt = $this->pdo->prepare('UPDATE timetrack SET finish_time=?, is_paused=1 WHERE user_id=? AND finish_time IS NULL');
        $stmt->execute([time(), $user_id]);
        return $stmt->fetchColumn();
    }
    public function stop($user_id)
    {
        $this->pdo->beginTransaction();
        $paused_id = $this->isPaused($user_id);
        if ($paused_id) {
            $stmt = $this->pdo->prepare('UPDATE  timetrack SET  is_paused=null WHERE id=?');
            $stmt->execute([$paused_id]);
        } else {
            $stmt = $this->pdo->prepare('UPDATE  timetrack SET  finish_time=? WHERE user_id=? AND finish_time IS NULL');
            $stmt->execute([time(), $user_id]);
        }
        $this->pdo->commit();
    }
    public function isStarted($user_id)
    {
        $stmt = $this->pdo->prepare('SELECT id  FROM timetrack WHERE user_id=? AND finish_time IS NULL');
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }
    public function isPaused($user_id)
    {
        $stmt = $this->pdo->prepare('SELECT id  FROM timetrack WHERE user_id=? AND is_paused AND next_id IS NULL');
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }
    public static function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }
    public static function getUserInfo($user_id)
    {
        return  DB::select('SELECT name, email FROM users WHERE id=?', [$user_id]);
    }
    public static function getTimetrack($user_id)
    {
        return DB::select('SELECT * FROM timetrack WHERE user_id=? ORDER BY start_time DESC', [$user_id]);
    }
    public static function getAdmin($user_id)
    {
       return DB::select('SELECT user_id FROM admins WHERE user_id=?', [$user_id]);
    }
    public static function Allusers()
    {
        return DB::select('SELECT * FROM users ');
    }
    public static function allTimersWithUser()
    {
        return DB::select('SELECT * FROM timetrack t LEFT JOIN users u ON t.user_id=u.id');
    }
    public static function getTodaySum($start_time, $user_id)
    {
        return DB::select('SELECT sum(finish_time-start_time) FROM timetrack WHERE start_time>=? AND user_id=?', [$start_time, $user_id]);
    }
}

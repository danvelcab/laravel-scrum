<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model {

	protected $table = 'sprints';
	public $timestamps = true;

	public function taks()
	{
		return $this->hasMany('Task');
	}

	public static function getDays($sprint){
        $startDate = new Carbon($sprint->start_date);
        $endDate = new Carbon($sprint->end_date);
        $days = $endDate->diffInDays($startDate);
        return $days + 1;

    }
    public static function getDayLabels($sprint, $days){
        $result = array();
        for ($i = 0; $i <= $days; $i++){
            $date = new \DateTime($sprint->start_date);
            $date = Carbon::createFromTimestamp($date->getTimestamp());
            $date->addDays($i);
            if($date->dayOfWeek != Carbon::SATURDAY && $date->dayOfWeek != Carbon::SUNDAY){
                array_push($result, $date->toDateString());
            }
        }
        return $result;
    }

}
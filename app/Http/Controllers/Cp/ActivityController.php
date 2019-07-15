<?php

namespace App\Http\Controllers\Cp;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\User;

use App\Filters\ProcessFilterRule;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class ActivityController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // allow creating through admin only
    }

    public function index()
    {
    	return view('cp.activities.index');
    }

    public function list(Request $request)
    {
		return QueryBuilder::for(Activity::class)
			->leftJoin('users', 'activity_log.causer_id', 'users.id')
    		->select('activity_log.*', 'users.name as users.name')
    		->orderBy('activity_log.created_at', 'desc')
			->allowedFilters(
				(new ProcessFilterRule($request))->get()
			)
			->ezPaginate();

    }

    public function listModelActivityNames()
    {
    	$modelActivityNames = Activity::distinct('properties')->get(['properties']);

    	$modelActivities = [];
    	foreach ($modelActivityNames as $modelActivityName) {
    		$properties = collect(json_decode($modelActivityName->properties));
    		$modelActivities[] = $properties;
    	}
    	return $modelActivities;
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * Set the activity user performed on specific model
    */
    public static function logActivity($model, $action, $modelName = null)
    {
        $modelName = is_null($modelName) ? $model->getModelName() : $modelName;

        activity()->causedBy(\Auth::user())
        ->performedOn($model)
        ->withProperties(['model_activity_name' => $modelName])
        ->log($action);
    }

    public function saveAttachment($request, $model, $fieldName = 'attachment')
    {
        if ($request->hasFile($fieldName)) {

            $model->clearMediaCollection();

            $model->addMedia($request[$fieldName])
            ->preservingOriginal()
            ->toMediaCollection();
        }
    }
}


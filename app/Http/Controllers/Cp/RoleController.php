<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use App\Http\Requests\Roles\StoreRole;
use App\Http\Requests\Roles\UpdateRole;

class RoleController extends Controller
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
    
    public function index(Request $request)
    {
      return view('cp.auth.roles');
    }

    public function list()
    {
      return Role::all();
    }

    public function insert(StoreRole $request)
    {
      $role = Role::create(['name' => $request->name]);

      activity()->causedBy(\Auth::user())
                ->performedOn($role)
                ->withProperties(['model_activity_name' => 'Roles'])
                ->log('create');

    	return ezReturnSuccessMessage('Role inserted successfully!', $role);
    }

    public function update(UpdateRole $request)
    {
      $role = Role::findOrFail($request->id);
    	$role->name = $request->name;
    	$role->save();

      activity()->causedBy(\Auth::user())
                ->performedOn($role)
                ->withProperties(['model_activity_name' => 'Roles'])
                ->log('update');

      return ezReturnSuccessMessage('Role updated');
    }

    public function destroy(Request $request)
    {
      $role = Role::findOrFail($request->id);

      activity()->causedBy(\Auth::user())
                ->performedOn($role)
                ->withProperties(['model_activity_name' => 'Roles'])
                ->log('destroy');
      
      $role->delete();

      return ezReturnSuccessMessage('Role deleted');
    }
}

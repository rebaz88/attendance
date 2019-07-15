<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
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
    $role = Role::where('name', $request->role_name)->firstOrFail();
    $roleOldPermissions = collect($role->permissions()->pluck('name')->all());
    return view('cp.auth.permissions')->with('permissions', $roleOldPermissions)
                                   ->with('role', $role);
  }

  public function list(Request $request, $role_id)
  {
    $role = Role::findOrFail($role_id);
    return collect($role->permissions()->pluck('name')->all());
  }

  public function save(Request $request, $role_id)
  {

    $role = Role::findOrFail($role_id);
    $permissions = $request->except(['_token']);

    if(sizeof($permissions) == 0)
      return ezReturnErrorMessage('Please select some permissions');

    collect($permissions)->keys()->each(function($permission, $key) {
      Permission::firstOrCreate(['name' => $permission]);
    });

    $role->syncPermissions(collect($permissions)->keys()->all());

    return ezReturnSuccessMessage('Updated successfully!');
  }

}

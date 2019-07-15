<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

use App\Http\Requests\Users\StoreUser;
use App\Http\Requests\Users\UpdateUser;

use App\Filters\ProcessFilterRule;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the creation of new users as well as their
    | validation and creation throw admin panel.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
    	return view('cp.auth.index');
    }

    public function list(Request $request)
    {
    	$filters = (new ProcessFilterRule($request))->exclude('roles')->get();

        $query = QueryBuilder::for(User::class)
            ->with(['roles'])
            ->orderBy('name')
            ->allowedFilters($filters);

            if($request->filters()->has('roles')) {
                $roles = Role::where('name', 'like', $request->filters()->get("roles") . "%")->get();
                if($roles->count() > 0) {
                    $query->role($roles);
                } else {
                    return [];
                }
            }

            return $query->ezPaginate();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(StoreUser $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
            'is_staff' => 1,
        ]);

        $user->syncRoles($request->role);

        activity()->causedBy(\Auth::user())
                  ->performedOn($user)
                  ->withProperties(['model_activity_name' => 'Users'])
                  ->log('create');

        return ezReturnSuccessMessage('User created successfully!');
    }

    public function update(UpdateUser $request)
    {
    	$user = User::findOrFail($request->id);

    	$user->name = $request->name;
    	$user->email = $request->email;

    	$user->save();

    	$user->syncRoles($request->role);

      activity()->causedBy(\Auth::user())
                ->performedOn($user)
                ->withProperties(['model_activity_name' => 'Users'])
                ->log('edit');

      return ezReturnSuccessMessage('User created successfully!');
    }

    public function destroy(Request $request)
    {

    	$user = User::findOrFail($request->id);

    	$user->delete();

        activity()->causedBy(\Auth::user())
                  ->performedOn($user)
                  ->withProperties(['model_activity_name' => 'Users'])
                  ->log('delete');

    	return ezReturnSuccessMessage('User removed successfully!');

    }

    public function toggleStatus(Request $request)
    {

    	$user = User::findOrFail($request->id);

    	$user->status = ($user->status == 'Enabled') ? 'Disabled' : 'Enabled';

    	$user->save();

        activity()->causedBy(\Auth::user())
                  ->performedOn($user)
                  ->withProperties(['model_activity_name' => 'Users'])
                  ->log('Changed the user status to ' . $user->status);

    	return ezReturnSuccessMessage('User staus changed successfully!');

    }

    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->password = Hash::make($user->email);
        $user->save();
        return ezReturnSuccessMessage('Password reset successfully!');
    }


}

<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\Role as EnumsRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.sign-up');
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(SignupRequest $request)
    {
        $data = $request->safe();
        
        $u = explode(" ", $data['name']);
        $username = strtolower(join(".", $u));

        $user = User::make([
            'name' => $data['name'],
            'username' => $username,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Add new team

        $team = Team::create([]);
        $user->team()->associate($team);
        $user->save();

        // Add permissions

        $team_class = class_basename(Team::class);

        $operations = ['view', 'create', 'edit', 'delete'];
        $super_user_permissions = [];

        foreach ($operations as $operation) {
            $super_user_permissions[] = Permission::where('slug', $operation . '_' . $team_class)->pluck('id')->first();
        }

        $all_permissions_without_super_user = Permission::whereNotIn('id', $super_user_permissions)->pluck('id');
        $user->permissions()->sync($all_permissions_without_super_user);
        $user->save();

        // Add role

        $roleAdmin = Role::where('name', EnumsRole::Admin)->firstOrFail();
        $user->roles()->save($roleAdmin);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}

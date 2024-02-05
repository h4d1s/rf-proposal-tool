<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $team_id = $request->user()->team->id;
        $query = User::query();
        $query = $query->forTeam($team_id);
        $query = $query->allWithoutCurrent($request->user()->id);

        if (
            $request->filled('user') &&
            $request->filled('action') &&
            $request->query('action') === 'delete'
        ) {
            $ids = $request->query('client');
            User::whereIn('id', $ids)->each(function($user) {
                $user->delete();
            });
            $request->request->remove('user');

            $users = $query
                ->all()
                ->paginate(10)
                ->withQueryString();

            return back()
                ->with('users', compact('users'))
                ->with('status', __('Users deleted!'));
        }

        if ($request->filled('search')) {
            $q = $request->query('search');
            $query = $query->where('name', 'LIKE', '%'.$q.'%');
        }

        if ($request->filled(['order', 'orderby'])) {
            $order = $request->query('order');
            $orderby = $request->query('orderby');
            $query = $query->orderBy($orderby, $order);
        }

        $users = $query
            ->paginate(10)
            ->withQueryString();

        return view('settings.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('settings.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $current_user = $request->user();
        $user_data = $request->safe()->except(
            'password',
            'password_confirmation',
            'avatar',
        );
        $validated = $request->safe();

        $u = explode(" ", $user_data['name']);
        $username = strtolower(join(".", $u));

        $user = User::make([
            "name" => $user_data["name"],
            "email" => $user_data["email"],
            "username" => $username
        ]);
        
        // Password

        if($request->filled("password")) {
            $user->password = Hash::make($validated["password"]);
        }

        // Team

        $user->team()->associate($current_user->team);
        $user->save();

        // Avatar

        if($request->hasFile('avatar')) {
            $image_path = $request->file('avatar')->store('public/images/avatars');
            $file_basename = pathinfo($image_path, PATHINFO_BASENAME);
            $user->avatar()->create([
                "path" => "avatars/{$file_basename}"
            ]);
        }

        // Roles

        if($request->filled("role")) {
            $user->roles()->sync($validated["role"]);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('status', __('User created!'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = Role::all();
        return view('settings.users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('settings.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user_data = $request->safe()->except(
            'password',
            'password_confirmation',
            'avatar',
        );
        $validated = $request->safe();
        $user->update($user_data);

        // Password

        if($request->filled("password")) {
            $user->update([
                "password" => Hash::make($validated["password"])
            ]);
        }

        // Avatar

        if($request->hasFile('avatar')) {
            $image_path = $request->file('avatar')->store('public/images/avatars');
            $file_basename = pathinfo($image_path, PATHINFO_BASENAME);
            $user->avatar()->update([
                "path" => "avatars/{$file_basename}"
            ]);
        }

        // Role

        if($request->filled("role")) {
            $user->roles()->sync($validated["role"]);
            $user->save();
        }

        return back()
            ->with('status', __('User updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('status', __('User deleted!'));
    }

    public function profile(Request $request)
    {
        $this->authorize('update', $request->user());
        $user = $request->user();
        $roles = Role::all();

        return view('settings.users.edit', compact('user', 'roles'));
    }
}

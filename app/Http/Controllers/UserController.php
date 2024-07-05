<?php

namespace App\Http\Controllers;

use App\Models\{Batch, Course, Role, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Jambasangsang\Flash\Facades\LaravelFlash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $group)
    {
        $filterByBatch = $request->has('batch_filter');
        $filterByCourse = $request->get('course') ?? 'all';

        $course = $filterByCourse !== 'all' ? Course::firstWhere('slug', $filterByCourse) : $filterByCourse;

        $batch = Batch::when($filterByBatch, function (Builder $query) {
            $query->where('slug', getActiveBatch()->slug);
        })->first();


        return view('jambasangsang.backend.users.index', compact(['group', 'course', 'filterByBatch']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string $group
     * @return \Illuminate\Http\Response
     */
    public function create($group)
    {
        $variables = collect([
            'type' => 'users',
            'title' => 'Create',
            'size' => 'xl',
            'file' => 'backend.users.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'group'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $group
     * @param  \Illuminate\Http\StoreUserRequest  $request
     * @param  \App\Module\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store($group, StoreUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $image = null;

            if ($request->hasFile('image')) {
                $image  = uploadOrUpdateFile($request->file('image'), '', \constPath::UserImage);
            }

            $user = User::create(array_merge(
                $request->only([
                    'name', 'lname', 'email', 'phone', 'username', 'designation', 'dob', 'country_id', 'address', 'city', 'gender', 'status', 'calendar_id'
                ]),
                ['image' => $image]
            ));

            // sync user roles
            $roles = Role::where('id', $request->get('role'))->get();
            $user->roles()->sync($roles);

            $selected_permissions = $request->get('permissions');

            // sync user permissions
            $permissions = $group === 'student' ? Permission::where('name', 'view_courses')->get() : (isset($selected_permissions) ? Permission::whereIn('id', $selected_permissions)->get() : []);
            if (isset($permissions)) {
                $user->permissions()->sync($permissions);
            };

            DB::commit();

            LaravelFlash::withSuccess('User Created Successfully');

            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            LaravelFlash::withError($th->getMessage());

            return back();
        }
    }

    /**
     * Show a resource in storage.
     *
     * @param  string $group
     * @param  \App\Module\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $group, User $user)
    {
        $view = $request->get('v') ?? 'bio';
        $courses = [];

        if ($request->get('v') === 'record' && $user->hasRole('Student')) {
            $courses = $user->courses()->where('batch_id', getActiveBatch()->id)->latest('batch_users.created_at')->paginate(10)->withQueryString();
        }

        return view('jambasangsang.backend.users.show', compact('group', 'user', 'view', 'courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $group
     * @param  \App\Module\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($group, User $user)
    {
        $variables = collect([
            'type' => 'users',
            'title' => 'Edit',
            'size' => 'xl',
            'file' => 'backend.users.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'user', 'group'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $group
     * @param  \App\Module\User  $user
     * @param  \App\Http\UpdateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update($group, UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $new_image  = uploadOrUpdateFile($request->file('image'), $user->image, \constPath::UserImage);
                $request->request->set('image', $new_image);
            }

            if ($request->get('password')) {
                $request->request->set('password', Hash::make($request->get('password')));
            } else {
                $request->request->remove('password');
            }

            // remove unique columns if they are not being updated
            if ($request->get('email') === $user->email) {
                $request->request->remove('email');
            }

            if ($request->get('username') === $user->username) {
                $request->request->remove('username');
            }

            $roles = $request->get('role');
            $selected_permissions = $request->get('permissions');

            $request->request->remove('role');
            $request->request->remove('permissions');

            $user->update($request->all());

            // sync user roles
            $selected_roles = Role::where('id', $roles)->get();
            $user->roles()->sync($selected_roles);

            // sync user permissions
            $permissions = $group === 'student' ? Permission::where('name', 'view_courses')->get() : (isset($selected_permissions) ? Permission::whereIn('id', $selected_permissions)->get() : []);

            if (isset($permissions)) {
                $user->permissions()->sync($permissions);
            };

            DB::commit();

            LaravelFlash::withSuccess('User Updated Successfully');

            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            LaravelFlash::withError($th->getMessage());

            return back();
        }
    }
}

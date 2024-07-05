<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserRequest;

class UserAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function index(){

        $data['attendances'] = Attendance::all();
        return view('jambasangsang.backend.attendance.index', $data);
    }
   /* public function index()
    {
        return view('jambasangsang.backend.attendance.index', ['users' => User::role(['Admin'])->get()]);
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jambasangsang.backend.attendance.create', ['roles' => Role::where('name', '!=', 'User')->get('name', 'id')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        Gate::authorize('view_users');
        return view('jambasangsang.backend.students.show', ['student' => User::with('courses', 'courses.course', 'courses.course.lessons', 'courses.course.instructor')->whereSlug($slug)->first()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //$data['User'] = User::find($slug);
        // return $data['User'];

        // return view('jambasangsang.backend.categories.edit', ['singleCategory' => $category, 'categories' => Category::whereNull('parent_id')->get()]);
        return view('jambasangsang.backend.users.create', ['roles' => Role::where('name', '!=', 'Student')->get('name', 'id'), 'user' => User::whereSlug($slug)->firstOrFail()]);
    }

    public function updateRequest(Request $request, $id){

        return view('jambasangsang.backend.users.edit', ['roles' => Role::where('name', '!=', 'Student')->get('name', 'id'), 'user' => User::where('email',$id) -> first()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

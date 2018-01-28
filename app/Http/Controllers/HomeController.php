<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Permission;
use App\User;
use App\Role;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    public function attachUserRole($userId, $role){
        $user = User::find($userId);
        $roleId = Role::where('name', $role)->first();
        $user->roles()->attach($roleId);
        return $user;
    }

    public function getUserRole($userId){
      return User::find($userId)->roles;
    }

    //Add a permission to a role.
    public function attachPermission(Request $request){
      $parameters = $request->only('permission', 'role');
      $permissionParam = $parameters['permission'];
      //var_dump($permissionParam);
      $roleParam = $parameters['role'];
      //var_dump($roleParam);
      $role = Role::where('name', $roleParam)->first();
      //var_dump($role);
      $permission = Permission::where('name', $permissionParam)->first();
      //var_dump($permission);
      $role->attachPermission($permission);
      return $this->response->created();
      //return $role->permissions;
    }

    // Get all permissions related to a role
    public function getPermissions($roleParam){
      $role = Role::where('name', $roleParam)->first();
      //var_dump($role);
      return $this->response->array($role->perms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Auth;
use Illuminate\Support\Facades\DB;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;

class RolesController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::orderBy('id', 'ASC')->paginate(15);//Get all roles
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      //
      $permissions = Permission::pluck('name', 'id');//Get all permissions
      return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //Validate name and permissions field
    
        $this->validate($request, [
            'name'=>'required|unique:roles|max:10',
            'permissions' =>'required|array',
        ]);
      
        $perms = $request['permissions'];

        $name = $request['name'];
        dd($perms, $name); 
        //$role = new Role();
        //$role->name = $name;
        //$role->save();
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));
    
        // Looping thru selected permissions
        //foreach ($perms as $permission) 
        //{
        //   $p = Permission::where('id', '=', $permission)->firstOrFail(); 
        // Fetch the newly created role and assign permission
        //    $role = Role::where('name', '=', $name)->first(); 
        //    $role->givePermissionTo($p);
        //}

        return redirect()->route('roles.index')
            ->with('flash_message',
            'Role'. $role->name.' added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::where('id', $id)->first();
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
                          ->where('role_has_permissions.role_id',$id)
                          ->get();
      
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::findOrFail($id);

       // $permissions = Permission::pluck('name', 'id');
        //Get all permissions
        $excludePerms = ['view', 'create','edit','update' ];
        $permissions = Permission::whereNotIn('name',$excludePerms)->pluck('name', 'id'); 

        $rolePermissions = DB::table('role_has_permissions')
              ->where('role_has_permissions.role_id', $id)
              ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
              ->all();
      
          return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
        //dd($role, $permissions);
        //return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'=>'required',
            'permissions' =>'required|array|between:1,70',
        ]);
          
        $role = Role::findOrFail($id);//Get role with the given id
          
        $curPerms = $role->permissions;
        $curPermId = [];
        foreach($curPerms as $row)
        {
            $curPermId[] = $row->id;
        }
          
        $permSelected = $request['permissions'];    
        $diffPerms = array_diff($permSelected, $curPermId);
        $permNames = Permission::whereIn('id', $diffPerms)->pluck('name');
        //dd($role, $curPerms, $permNames);
        $role->givePermissionTo($permNames); 
        $newSyncedPerms = $role->permissions;
        //dd($curPermId, $permSelected, $diffPerms, $permNames, $newSyncedPerms);
         
        return redirect()->route('group-roles.index')
              ->with('flash_message',
               'Role'. $role->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
  
        return redirect()->route('roles.index')
              ->with('flash_message',
               'Role deleted!');
    }
}

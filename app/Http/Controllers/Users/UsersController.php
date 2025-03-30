<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exclude = [1,2];
        $users = User::whereNotIn('id', $exclude)->get();
        //dd($users);
        foreach($users as $user)
        {
            $user->role = $user->getRoleNames();
            $user->permsDirect = $user->getDirectPermissions();
            $user->permsRoles = $user->getPermissionsViaRoles();
            $user->permsAll = $user->getAllPermissions();
        }
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      if( Auth::user()->hasAnyRole('pisg') )
      {
        if($this->getTenantUserCountByPlan())
        {
            $exclude = ['supadmin', 'pisg'];
            //$roles = Role::where('name','<>', 'supadmin')->where('name','<>', 'pisg')->pluck('name', 'id');
            $roles = Role::whereNotIn('name', $exclude)->pluck('name', 'id');
            //dd($roles);
            return view('users.create', ['roles' => $roles]);
        }
        else {
            return redirect()->route('error.error10010');
        }
      }
      else {
        return redirect()->route('error.error10000');
      }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      if( Auth::user()->hasAnyRole('pisg', 'supadmin') )
      {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required'
        ]);
        
        $roles = $request['roles']; //Retrieving the roles field

        $roleArray = ['researcher', 'technician', 'collaborator', 'guest'];

        if(in_array($role, $roleArray))
        {
          $user = User::create([
                          'name' => $request->name,
                          'email' => $request->email,
                          'password' => Hash::make($request->password),
                      ]);

          $user->syncRoles($request->roles);

          return redirect('/group-users')->with('status','User created successfully with roles');
        }
        else {
          return redirect()->route('error.error10000');
        }
      }
      else {
        return redirect()->route('error.error10000');
      }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //Get user with specified id		
        $user = User::with(['roles'])->where('id', $id)->first(); 

        // get all inherited permissions for that user
        $permsUser = $user->getAllPermissions();
        
        //Get all roles
        $excludeRolesNames = ['supadmin','pisg'];
        $roles = Role::whereNotIn('name',$excludeRolesNames)->pluck('name', 'id'); 
        
        //Get all permissions
        $excludePerms = ['global', 'view', 'create','edit','update' ];
        $perms = Permission::whereNotIn('name',$excludePerms)->pluck('name', 'id'); 
        
        //pass user and roles data to view
        return view('users.edit', compact('user', 'roles', 'perms','permsUser')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if(!empty($request->password)){
            $data += [
                'password' => Hash::make($request->password),
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/group-users')->with('status','User Updated Successfully with roles');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($userId);
        //$user->delete();
        return redirect('/group-users')->with('status','User Delete Successfully');
    }
}

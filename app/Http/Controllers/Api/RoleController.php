<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    public function index()
    {
        return response()->json(['roles' => Role::all()]);
    }


    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name
        ]);
        if ($role)
        {
            return response()->json(['role' => $role], 200);
        }
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
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        if ($role)
        {
            return  response()->json(['role' => $role], 200);
        }
    }

    public function destroy($id)
    {
        $role = Role::find($id)->delete();
        return response()->json(['role' => $role], 200);
    }
}

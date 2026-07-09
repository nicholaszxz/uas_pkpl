<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.member.daftaruser', [
            'level' => auth()->user()->level,
            'id' => User::incrementId(),
            'user' => User::with('userLevel')->get(),
            'userlevel' => UserLevel::all(),
            'sideTitle' => 'user'
        ]);
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
        $user = new User;
        $user->id = User::incrementId();
        $user->level = $request->level;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();
        return redirect('/daftar-user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $kode)
    {
        $data = $user->with('userLevel')->find(['id' => $kode]);
        if ($data->count() > 0) {
            return response()->json([
                'message' => 'success',
                'user' => $data
            ]);
        } else {
            return response()->json([
                'message' => 'failed'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->where('id', $request->id_edit)
            ->update([
                'level' => $request->level_modal,
                'email' => $request->email_modal,
                'name' => $request->name_modal,
                'no_hp' => $request->no_hp_modal
            ]);
        if ($user) {
            return redirect('/daftar-user');
        } else {
            return redirect('/daftar-user');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user, $kode)
    {
        if ($user->where('id', $kode)->delete()) {
            return response()->json([
                'message' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'failed'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function _repassword(Request $request, User $user)
    {
        $user->where('id', $request->id_password)
            ->update([
                'password' => Hash::make($request->new_password),
            ]);
        if ($user) {
            return redirect('/daftar-user');
        } else {
            return redirect('/daftar-user');
        }
    }
}

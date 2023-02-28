<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {
        $user = User::query()->get();

        return response()->json([
            "status" => true,
            "message" => "list user",
            "data" => $user
        ]);
    }

    function show($id)
    {
        $user = User::query()
            ->where("id", $id)
            ->first();

        if (!isset($user)) {
            return response()->json([
                "status" => false,
                "message" => "data kosong",
                "data" => null
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "nyoh",
            "data" => $user
        ]);
    }


    function store(Request $request)
    {
        $payload = $request->all();
        if (!isset($payload['name'])) {
            return response()->json([
                "status" => false,
                "message" => "input tidak lengkap",
                "data" => null
            ]);
        }

        $count = User::where('email', '=', $payload['email'])->count();

        if ($count > 0) {
            return response()->json([
                "status" => false,
                "message" => "email sudah terdaftar",
                "data" => 'email'
            ]);
        }

        $user = User::query()->create($payload);
        return response()->json([
            "status" => true,
            "message" => "data ".$user['name']." tersimpan",
            "data" => $user
        ]);
    }

    function update(Request $request, $id)
    {
        $user = User::query()->where("id", $id)->first();
        if (!isset($user)) {
            return response()->json([
                "status" => false,
                "message" => "data kosong",
                "data" => null
            ]);
        }

        $payload = $request->all();

        $user->fill($payload);
        $user->save();

        return response()->json([
            "status" => true,
            "message" => "perubahan data tersimpan",
            "data" => $user
        ]);
    }

    function destroy($id)
    {
        $user = User::query()->where("id", $id)->first();
        if (!isset($user)) {
            return response()->json([
                "status" => false,
                "message" => "data kosong",
                "data" => null
            ]);
        }

        $user->delete();

        return response()->json([
            "status" => true,
            "message" => "Data Terhapus",
            "data" => $user
        ]);
    }

}

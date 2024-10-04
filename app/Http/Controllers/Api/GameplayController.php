<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gameplay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameplayController extends Controller
{
    /**
    * Display a listing of the resource.
     */
    public function index()
    {
        //get all character with relasi on table characters, levels and users
        $gameplays = Gameplay::with(['character','level','user']) ->latest()->paginate(5);


        //response
        $response = [
            'message'   => 'List all gameplays',
            'data'      => $gameplays,
        ];


        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi data
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'character_id' => 'required|integer',
            'level_id' => 'required|integer',
            'score' => 'required|integer',
        ]);


        //jika validasi gagal
        if ($validator->fails()) {
        return response()->json([
            'message' => 'Invalid field',
            'errors' => $validator->errors()
        ],422);
        }


        //jika validasi sukses masukan data level ke database
        $gameplay = Gameplay::create([
            'user_id' => $request->user_id,
            'character_id' => $request->character_id,
            'level_id' => $request->level_id,
            'score' => $request->score,
        ]);


        //response
        $response = [
            'success'   => 'Add gameplay success',
            'data'      => $gameplay,
        ];


        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find Gameplay by ID
        $character = Gameplay::with(['character','level','user'])->find($id);


        //response
        $response = [
             'success'   => 'Detail Gameplay',
             'data'      => $character,
        ];


        return response()->json($response, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find gameplay by ID
        $gameplay = Gameplay::find($id);
        if (isset($gameplay)) {

            //delete post
            $gameplay->delete();


            $response = [
                'success'   => 'Delete gameplay Success',
            ];
            return response()->json($response, 200);


        } else {
            //jika data gameplay tidak ditemukan
            $response = [
                'success'   => 'Data gameplay Not Found',
            ];


            return response()->json($response, 404);
        }

    }
}

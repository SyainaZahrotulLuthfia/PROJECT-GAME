<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all level
        $levels =  Level::latest()->paginate(5);

        //response
        $response = [
            'message' => 'list all level',
            'data' => $levels,
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
            'level_name' => 'required',
            'number_of_enemies' => 'required|integer',
            'heal_point' => 'required|integer',
            'times' => 'required',
        ]);


        //jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ],422);
        }


        //jika validasi sukses masukan data level ke database
        $level = Level::create([
            'level_name' => $request->level_name,
            'number_of_enemies' => $request->number_of_enemies,
            'heal_point' => $request->heal_point,
            'times' => $request->times,
        ]);


        //response
        $response = [
            'success'   => 'Add level success',
            'data'      => $level,
        ];


        return response()->json($response, 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find Level by ID
        $level = Level::find($id);


        //response
        $response = [
            'success'   => 'Detail Level',
            'data'      => $level,
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
        //define validation rules
        $validator = Validator::make($request->all(), [
            'level_name' => 'required',
            'number_of_enemies' => 'required|integer',
            'heal_point' => 'required|integer',
            'times' => 'required',
        ]);


        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //find level by ID
        $level = Level::find($id);


        $level->update([
            'level_name' => $request->level_name,
            'number_of_enemies' => $request->number_of_enemies,
            'heal_point' => $request->heal_point,
            'times' => $request->times,
        ]);


        //response
        $response = [
            'success'   => 'Update level success',
            'data'      => $level,
        ];


        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //find level by ID
        $level = Level::find($id)->delete();
        $response = [
            'success'   => 'Delete Level Success',
        ];
        return response()->json($response, 200);

    }
}

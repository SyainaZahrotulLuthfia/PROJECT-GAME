<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all character
        $characters =  Character::latest()->paginate(5);

        //response
        $response = [
            'message' => 'list all character',
            'data' => $characters,
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
                    'name' => 'required|min:3',
                    'power' => 'required|integer',
                    'image' => 'required',
                ]);


                //jika validasi gagal
                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'Invalid field',
                        'errors' => $validator->errors()
                    ],422);
                }


                //upload image character to storage
                $image = $request->file('image');
                $image->storeAs('public/character', $image->hashName());


                //insert character to database
                $character = Character::create([
                    'name' => $request->name,
                    'power' => $request->power,
                    'image'     => $image->hashName(),
                ]);


                //response
                $response = [
                    'success'   => 'Add character success',
                    'data'      => $character,
                ];


                return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         //find character by ID
         $character = Character::find($id);


         //response
         $response = [
             'success'   => 'Detail character',
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
        //validasi data
        $validator = Validator::make($request->all(),[
        'name' => 'required|min:3',
        'power' => 'required|integer',
        'image' => 'required',
    ]);


    //jika validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Invalid field',
            'errors' => $validator->errors()
        ],422);
    }


    //find character by ID
    $character = Character::find($id);


    //check if image is not empty
    if ($request->hasFile('image')) {


        //upload image
        $image = $request->file('image');
        $image->storeAs('public/character', $image->hashName());


        //delete old image
        Storage::delete('public/character/' . basename($character->image));


        //update post with new image
        $character->update([
            'name' => $request->name,
            'power' => $request->power,
            'image'     => $image->hashName(),
        ]);

    } else {
        //update post without image
        $character->update([
            'name' => $request->name,
            'power' => $request->power,
        ]);
    }


    //response
    $response = [
        'success'   => 'Update character success',
        'data'      => $character,
    ];


    return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         //find character by ID
         $character = Character::find($id);

         if (isset($character)) {
             //jika data ditemukan delete image from storage
             Storage::delete('public/character/'.basename($character->image));


             //delete post
             $character->delete();


             $response = [
                 'success'   => 'Delete Charater Success',
             ];
             return response()->json($response, 200);


         } else {
             //jika data tidak ditemukan
             $response = [
                 'success'   => 'Data Charater Not Found',
             ];


             return response()->json($response, 404);


         }

    }
}

<?php

namespace App\Http\Controllers\Api;
use App\Models\User;//llll
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Exception;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => 'Display a listing of the resouce',
            '$data' => $users 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if($validator->fails()){
         return response()->json([
             'success' => false,
             'errors' => $validator->errors()
            ], 401);
        }
        try{
            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

             return response()->json([
                    'success' => true,
                    'message' => "User Save successfully",
                    'data' => $users
                   
            ],200);
        }
        catch(Exception $e){
             return response()->json([
                'success' => 'false',
                'message' => 'Something wrong!'
            ], 400);
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
        try{
        User::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Remove the specified resource from storage',
            'data' => User::find($id)
        ]);
    } catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong!',
        ]);
     }

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
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if($validator->fails()){
         return response()->json([
             'success' => false,
             'errors' => $validator->errors()
            ], 401);
        }
        try{
            $users = User::findOrFail($id);

            $users->name = $request->name;
            $users->emai = $request->email;
            $users->password = $request->password;
            $users->save();
             return response()->json([
                    'success' => true,
                    'message' => "User Data Update successfully",
                    'data' => $users
            ],200);
        }
        catch(Exception $e){
             return response()->json([
                'success' => 'false',
                'message' => 'Something wrong!'
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            User::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Remove the specified resource from storage',
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
            ]);
        }
       
    }
}

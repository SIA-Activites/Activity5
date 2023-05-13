<?php

namespace App\Http\Controllers;


use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


Class UserController extends Controller {

    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function getUsers()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
        
        //return $this->successResponse($users);
    }

    public function index()
    {
        $users = User::all();
        
        return $this->successResponse($users);
    }

    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request,$rules);

        $users = User::create($request->all());
        return $this->successResponse($users, Response::HTTP_CREATED);
        //return response()->json($user, 200);
    }


    public function show($id)
    {
        $users =  User::findOrFail($id);
        return $this->successResponse($users);
        
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male, Female',
        ];

        $this->validate($request, $rules);
        $users = User::where('userID', $id)->firstOrFail();
        $users->fill($request->all());

        if ($users->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $users->save();
        return $users;
    }

    public function deleteUser($id)
    {
        $users = User::findOrFail($id);
        //$users = User::where('userID', $id)->delete();
        $users->delete();
        //$users->successResponse('Data delete');
        return $this -> successresponse('delet na dol');
        
    }


}



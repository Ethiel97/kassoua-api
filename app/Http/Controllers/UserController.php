<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(User::withCount('products')->get());
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*if ($user = User::findOrFail($id)) {
             return $user::withCount('products')->first();
          }*/

        return User::findOrFail($id)->toArray();
//        return User::withCount('products')->with('products')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'photo' => 'nullable|image|mimes:jpeg,jpg,bmp,png|max:2500',
            'job' => 'nullable',
            'email' => 'required',
            'lname' => 'required',
            'fname' => 'required',
            'gender' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'country' => 'required',
            'enterprise' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->all()]);
        }

        if ($user = User::find($id)) {
            $user->update($request->except('photo'));
            /*    $user->lname = $request->lname;
                $user->fname = $request->fname;
                $user->gender = $request->gender;
                $user->job = $request->job;
                $user->address = $request->address;
                $user->phone = $request->phone;
                $user->country = $request->country;
                $user->email = $request->email;
                $user->enterprise = $request->enterprise;*/

            if ($request->hasFile('photo')) {
                $filename = $request->file('photo')->store('photos');
                $user->photo = $filename;
            }
            $user->save();
//            $user->update($request->all());
//            $user->password = (new BcryptHasher)->make($this->input('password'));

            return response()->json(['error' => false, 'message' => ["Vos informations ont ete bien mises a jour !\n"], 'user' => $user]);
        } else
            return response()->json(['error' => true, 'message' => ['User not exist']]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

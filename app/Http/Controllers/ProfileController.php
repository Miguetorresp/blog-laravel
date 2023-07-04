<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('suscriber.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $user = Auth::user();

        if($request->hasFile('photo')){
            //Eliminar foto anterior
            File::delete(public_path('storage/'.$profile->photo));
            //Asignar nueva foto
            $photo = $request['photo']->store('profiles');
        }else{
            $photo = $user->profile->photo;
        }

        //Asignar nombre y correo
        $user->full_name = $request->full_name;
        $user->email = $request->email;

        //Asignar la foto (el profile es otra tabla por eso se asigna asi)
        $user->profile->photo = $photo;

        //Guardar campos de usuario
        $user->save();

        //Guardar campos de Perfil
        $user->profile->save();

        return redirect()->route('profiles.edit', $user->profile->id);
    }
}

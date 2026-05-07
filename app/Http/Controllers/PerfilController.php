<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function edit()
    {
        return view('perfil.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'alias'  => 'nullable|string|max:50',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = ['alias' => $request->alias ?: null];

        if ($request->hasFile('avatar')) {
            $file     = $request->file('avatar');
            $mime     = $file->getMimeType();
            $base64   = base64_encode(file_get_contents($file->getRealPath()));
            $data['avatar'] = 'data:' . $mime . ';base64,' . $base64;
        }

        if ($request->boolean('remove_avatar')) {
            $data['avatar'] = null;
        }

        $user->update($data);

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
    }
}

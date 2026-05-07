<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            // Borrar avatar anterior
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->boolean('remove_avatar') && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = null;
        }

        $user->update($data);

        return redirect()->route('perfil.edit')->with('success', 'Perfil actualizado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?: new Profile();
        
        // Ensure user_id is set for new profiles
        if (!$profile->exists) {
            $profile->user_id = $user->id;
        }

        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->bio = $request->bio;

        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::delete('public/' . $profile->photo);
            }
            $profile->photo = $request->file('photo')->store('profile_photos', 'public');
        }

        $profile->save();

        return redirect()->route('profile.show')
            ->with('mensaje', 'El perfil se actualizó correctamente')
            ->with('icono', 'success');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CharacterAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterAttributeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'strength' => 'required|integer',
            'dexterity' => 'required|integer',
            'constitution' => 'required|integer',
            'intelligence' => 'required|integer',
            'wisdom' => 'required|integer',
            'charisma' => 'required|integer',
        ]);

        CharacterAttribute::create([
            'character_id' => Auth::id(),
            'strength' => $request->strength,
            'dexterity' => $request->dexterity,
            'constitution' => $request->constitution,
            'intelligence' => $request->intelligence,
            'wisdom' => $request->wisdom,
            'charisma' => $request->charisma,
        ]);

        return redirect()->back()->with('success', 'Атрибуты сохранены!');
    }

}

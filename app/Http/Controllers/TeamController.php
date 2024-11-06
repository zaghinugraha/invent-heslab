<?php
namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
        ]);

        Team::create([
            'name' => $request->input('team_name'),
            'user_id' => auth()->id(), // Assuming the team is created by the authenticated user
            'personal_team' => false, // Default value for personal_team
        ]);

        return redirect()->route('users.index');
    }
}
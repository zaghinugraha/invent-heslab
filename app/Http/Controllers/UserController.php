<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $teams = Team::all();
        $selectedTeam = $request->input('team_id');
        
        $users = User::with('currentTeam')
            ->when($selectedTeam, function ($query, $teamId) {
                return $query->whereHas('currentTeam', function ($query) use ($teamId) {
                    $query->where('id', $teamId);
                });
            })
            ->get();

        return view('dashboard-admin-users', compact('users', 'teams', 'selectedTeam'));
    }

    public function promote(User $user)
    {
        // Logic to promote the user
        return redirect()->back();
    }

    public function demote(User $user)
    {
        // Logic to demote the user
        return redirect()->back();
    }

    public function ban(User $user)
    {
        // Logic to ban the user
        return redirect()->back();
    }
}
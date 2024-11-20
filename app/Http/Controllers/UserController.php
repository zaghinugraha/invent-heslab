<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $teams = ['Admin', 'Dosen', 'Koordinator', 'Research Group', 'Study Group'];
        $selectedTeam = $request->input('team_id');

        $users = User::with('currentTeam')
            ->when($selectedTeam, function ($query, $teamName) {
                return $query->whereHas('currentTeam', function ($query) use ($teamName) {
                    $query->where('name', $teamName);
                });
            })
            ->paginate(10); // Using pagination

        return view('dashboard-admin-users', compact('users', 'teams', 'selectedTeam'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:Admin,Dosen,Koordinator,Research Group,Study Group,Regular',
        ]);

        $teamName = $request->input('role');

        // Assign a default user (e.g., Admin) as the owner of role teams
        $defaultOwner = Auth::user(); // Ensure the admin is authenticated

        // Find or create the team with the given name and assign user_id
        $team = Team::firstOrCreate(
            ['name' => $teamName],
            [
                'user_id' => $defaultOwner->id,
                'personal_team' => false,
            ]
        );

        // Assign the team to the user
        $user->current_team_id = $team->id;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    public function ban(User $user)
    {
        // Logic to ban the user
        return redirect()->back();
    }
}

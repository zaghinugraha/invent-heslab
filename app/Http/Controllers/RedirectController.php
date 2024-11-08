<?php
// app/Http/Controllers/RedirectController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->currentTeam && $user->currentTeam->name === 'Admin') {
            return redirect('/admin/items');
        } else {
            return redirect('/reg/items');
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ThemeController extends Controller
{
    public function changeTheme(Request $request)
    {
      
      if (Auth::check()) {

        $user = Auth::user();
    
        if ($user->theme_mode == 'light') {
                $user->update(['theme_mode' => 'dark']);
            } else {
                $user->update(['theme_mode' => 'light']);
            }
       }

      return redirect()->back();
    }
}

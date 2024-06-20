<?php

namespace App\Http\Controllers;

use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        $pageOptions = [
            'title' => 'Dashboard',
        ];
        return view('pages.dashboards.index',$pageOptions);
    }

    public function profile()
    {
        $user = Auth::user();
        $pageOptions = [
            'title' => 'Profile Update',
            'actionUrl' => route('profileUpdate'),
            'method' => 'POST',
            'breadcrumbs' => Breadcrumbs::render('profile'),
            'user' => $user,
        ];
        return view('pages.dashboards.profile',$pageOptions);
    }

    public function profileUpdate()
    {
        $password = request()->get('password');
        if ($password) {
            request()->merge(['password' => bcrypt($password)]);
        } else {
            request()->request->remove('password');
        }
        $user = Auth::user();
        $user->update(request()->all());
        return redirect()->route('profile');
    }
    
}

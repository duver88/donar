<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\User;
use App\Models\BloodRequest;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stats = [
            'total_donors' => Pet::where('donor_status', 'approved')->count(),
            'total_veterinarians' => User::where('role', 'veterinarian')->where('status', 'approved')->count(),
            'active_requests' => BloodRequest::where('status', 'active')->count(),
            'total_tutors' => User::where('role', 'tutor')->count(),
        ];

        return view('home', compact('stats'));
    }
}
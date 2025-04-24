<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('employers.home');
    }

    public function tasks()
    {
        return view('employers.tasks');
    }
}
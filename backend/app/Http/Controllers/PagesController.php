<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show the index page
     */
    public function index()
    {
        $activities = [
            ['name' => 'Активност 1', 'desc' => 'Описание на активност 1'],
            ['name' => 'Активност 2', 'desc' => 'Описание на активност 2'],
            ['name' => 'Активност 3', 'desc' => 'Описание на активност 3'],
        ];
        return view('index', ['activities' => $activities]);
    }

    /**
     * Show the about us page
     */
    public function aboutus()
    {
        return view('aboutus');
    }

    /**
     * Show the activities page
     */
    public function activities()
    {
        return view('activities');
    }

    /**
     * Show the contact page
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Show the soopstenija page
     */
    public function soopstenija()
    {
        return view('soopstenija');
    }

    /**
     * Show the izrabotki page
     */
    public function izrabotki()
    {
        return view('izrabotki');
    }

    /**
     * Show the gallery page
     */
    public function gallery()
    {
        return view('gallery');
    }
}

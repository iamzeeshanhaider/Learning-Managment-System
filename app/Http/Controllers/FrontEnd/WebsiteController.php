<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\{Category, Course, Event, Slider, User};
use Illuminate\Http\Request;

class WebsiteController extends Controller
{

    public function website()
    {

        return view(
            'welcome',
            [
                'categories' => Category::where('status', 'Enabled')->get(['id', 'name', 'image', 'slug']),
                'instructor' => User::Instructor()->where('status', 'Enabled')->get(),
                'courses' => Course::with('instructor:id,name,image,slug', 'students:id')->where('status', 'Enabled')->get(),
                'sliders' => Slider::where('status', 'Enabled')->get(),
                'events' => Event::where('status', 'Enabled')->get(),
            ]
        );
    }
}

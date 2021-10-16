<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Scoreboard;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = DB::table('scoreboards')
            ->join('users', 'users.id', '=', 'scoreboards.user_id')
            ->where('user_id', Auth()->user()->id)
            ->orderBy('scoreboards.id', 'DESC')
            ->get();

        $sun_number_score = Scoreboard::where('user_id', Auth()->user()->id)->sum('number_score');
        // dd($sun_number_score);
        return view('home', compact('data', 'sun_number_score'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'distance' => 'required',
            'date' => 'required',
            'file_image' => 'required|mimes:jpg,jpeg,png',
        ]);

        //         //เข้ารหัสรูป
        // dd(Auth()->user()->id);
        $image = $request->file('file_image');

        // generate
        $name_gen = hexdec(uniqid());

        $img_ext = strtolower($image->getClientOriginalExtension()); //นามสกุล file

        $img_name = $name_gen . '.' . $img_ext; // commit image with lastname

        // //upload
        $upload_location = 'image/Scoreboard/';
        $full_path = $upload_location . $img_name;

        // dd($request->all());
        //up load image

        Scoreboard::insert([
            'number_score' => $request->distance,
            'user_id' => Auth()->user()->id,
            'date_at' => Carbon::parse($request->date),
            'image' => $full_path,
            'created_at' => Carbon::now(),
        ]);

        $image->move(public_path($upload_location), $img_name);

        return redirect()
            ->back()
            ->with('success', 'save successfully!');
    }
}

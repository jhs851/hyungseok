<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * 리소스 목록을 표시합니다.
     *
     * @return View
     */
    public function index() : View
    {
        $usersCount = User::count();
        $monthliesCount = User::monthlies()->count();
        $incremental = parseFloat($monthliesCount / $usersCount * 100);
        $countsByDays = User::countsByDays()->get();
        $activeUsersCount = User::whereNotNull('email_verified_at')->count();
        $unactiveUsersCount = User::whereNull('email_verified_at')->count();

        return view('admin.users.index', compact('usersCount', 'monthliesCount', 'incremental', 'countsByDays', 'activeUsersCount', 'unactiveUsersCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

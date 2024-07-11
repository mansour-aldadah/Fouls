<?php

namespace App\Http\Controllers;

use App\Models\LogFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logFiles = LogFile::all();
        return view('log_files.index', ['logFiles' => $logFiles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(LogFile $logFile)
    {
        return view('log_files.show', ['logFile' => $logFile]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogFile $logFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogFile $logFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogFile $logFile)
    {
        //
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::with(['provider','category'])->get();
    }

    public function show($id)
    {
        return Service::with(['provider','category'])->findOrFail($id);
    }
}

<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Services\Admin\ServiceService;
use Illuminate\Http\Request;

class CustomerServiceController extends Controller
{
    public function __construct(protected ServiceService $serviceService) {}

    public function index(Request $request)
    {
        return $this->serviceService->filterForCustomer($request);
    }

    public function show($id)
    {
        return $this->serviceService->show($id); // تأكدي إنو في ميثود show بالـ ServiceService
    }
}
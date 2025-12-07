<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerProviderSearchService;
use Illuminate\Http\Request;

class CustomerProviderSearchController extends Controller
{
    public function __construct(protected CustomerProviderSearchService $searchService) {}

    public function search(Request $request)
    {
        return $this->searchService->searchProviders($request);
    }
}

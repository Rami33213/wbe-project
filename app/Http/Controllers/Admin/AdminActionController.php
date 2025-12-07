<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Requests\Admin\AddServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Services\Admin\UserService;
use App\Services\Admin\CategoryService;
use App\Services\Admin\ServiceService;
use App\Services\Admin\BookingService;
use App\Services\Admin\ReviewService;

class AdminActionController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected CategoryService $categoryService,
        protected ServiceService $serviceService,
        protected BookingService $bookingService,
        protected ReviewService $reviewService
    ) {}

    // Users
    public function users() { return $this->userService->all(); }
    public function toggleUserStatus($id) { return $this->userService->toggleStatus($id); }

    // Providers
    public function providers() { return $this->userService->providers(); }
    public function toggleProviderStatus($id) { return $this->userService->toggleProviderStatus($id); }
    public function deleteProvider($id) { return $this->userService->deleteProvider($id); }

    // Categories
    public function categories() { return $this->categoryService->all(); }
    public function addCategory(AddCategoryRequest $request) { return $this->categoryService->create($request->validated()); }
    public function updateCategory(UpdateCategoryRequest $request, $id) { return $this->categoryService->update($id, $request->validated()); }
    public function deleteCategory($id) { return $this->categoryService->delete($id); }

    // Services
    public function services() { return $this->serviceService->all(); }
    public function addService(AddServiceRequest $request) { return $this->serviceService->create($request->validated()); }
    public function updateService(UpdateServiceRequest $request, $id) { return $this->serviceService->update($id, $request->validated()); }
    public function deleteService($id) { return $this->serviceService->delete($id); }

    // Bookings
    public function bookingReports() { return $this->bookingService->report(); }

    // Reviews
    public function reviews() { return $this->reviewService->all(); }
    public function deleteReview($id) { return $this->reviewService->delete($id); }
}
<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\Service;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function index(): View
    {
        return view('company-profile', [
            'services' => Service::query()->orderByDesc('featured')->orderBy('price')->get(),
            'gallery' => GalleryImage::query()->latest()->take(6)->get(),
        ]);
    }
}
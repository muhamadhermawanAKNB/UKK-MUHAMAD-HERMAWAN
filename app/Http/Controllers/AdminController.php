<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.index', [
            'services' => Service::query()->orderBy('name')->get(),
            'gallery' => GalleryImage::query()->latest()->get(),
            'subscriptions' => Subscription::query()->with(['user', 'service'])->latest()->get(),
        ]);
    }

    public function storeService(Request $request): RedirectResponse
    {
        Service::create($this->validateService($request));

        return back()->with('status', 'Layanan berhasil ditambahkan.');
    }

    public function updateService(Request $request, Service $service): RedirectResponse
    {
        $service->update($this->validateService($request));

        return back()->with('status', 'Layanan berhasil diperbarui.');
    }

    public function destroyService(Service $service): RedirectResponse
    {
        $service->delete();

        return back()->with('status', 'Layanan berhasil dihapus.');
    }

    public function storeGalleryImage(Request $request): RedirectResponse
    {
        GalleryImage::create($this->validateGalleryImage($request));

        return back()->with('status', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function updateGalleryImage(Request $request, GalleryImage $galleryImage): RedirectResponse
    {
        $galleryImage->update($this->validateGalleryImage($request));

        return back()->with('status', 'Foto galeri berhasil diperbarui.');
    }

    public function destroyGalleryImage(GalleryImage $galleryImage): RedirectResponse
    {
        $galleryImage->delete();

        return back()->with('status', 'Foto berhasil dihapus dari galeri.');
    }

    private function validateService(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:60'],
            'description' => ['required', 'string', 'max:500'],
            'speed' => ['required', 'string', 'max:40'],
            'price' => ['required', 'integer', 'min:0'],
            'featured' => ['nullable', 'boolean'],
        ]) + ['featured' => $request->boolean('featured')];
    }

    private function validateGalleryImage(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'image_url' => ['required', 'url', 'max:2048'],
            'category' => ['required', 'string', 'max:60'],
        ]);
    }
}
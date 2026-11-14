<?php

namespace Tests\Feature;

use App\Models\GalleryImage;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_registration_creates_a_regular_customer_account(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Nadia Putri',
            'email' => 'nadia@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'nadia@example.com', 'is_admin' => false]);
    }

    public function test_customers_can_submit_a_subscription_request(): void
    {
        $customer = User::factory()->create();
        $service = Service::create([
            'name' => 'Fiber 100',
            'category' => 'Internet fiber',
            'description' => 'Koneksi rumah.',
            'speed' => '100 Mbps',
            'price' => 289000,
        ]);

        $response = $this->actingAs($customer)->post(route('subscriptions.store'), [
            'service_id' => $service->id,
            'notes' => 'Mohon hubungi sore hari.',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);
    }

    public function test_only_admins_can_manage_services_and_gallery(): void
    {
        $customer = User::factory()->create();
        $this->actingAs($customer)->get(route('admin.index'))->assertForbidden();

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)->get(route('admin.index'))->assertOk();
        $this->actingAs($admin)->post(route('admin.services.store'), [
            'name' => 'Jaringan Kantor',
            'category' => 'Solusi bisnis',
            'description' => 'Instalasi dan pemeliharaan jaringan kantor.',
            'speed' => 'Sesuai kebutuhan',
            'price' => 500000,
            'featured' => '1',
        ])->assertSessionHasNoErrors();

        $service = Service::where('name', 'Jaringan Kantor')->firstOrFail();
        $this->assertTrue($service->featured);
        $this->actingAs($admin)->put(route('admin.services.update', $service), [
            'name' => 'Jaringan Kantor Pro',
            'category' => 'Solusi bisnis',
            'description' => 'Paket jaringan terkelola.',
            'speed' => 'Sesuai kebutuhan',
            'price' => 650000,
        ])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('services', ['id' => $service->id, 'name' => 'Jaringan Kantor Pro', 'featured' => false]);
        $this->actingAs($admin)->delete(route('admin.services.destroy', $service))->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('services', ['id' => $service->id]);

        $this->actingAs($admin)->post(route('admin.gallery.store'), [
            'title' => 'Tim teknis',
            'category' => 'Instalasi',
            'image_url' => 'https://example.com/team.jpg',
        ])->assertSessionHasNoErrors();
        $image = GalleryImage::where('title', 'Tim teknis')->firstOrFail();
        $this->actingAs($admin)->put(route('admin.gallery.update', $image), [
            'title' => 'Tim teknis lapangan',
            'category' => 'Tim',
            'image_url' => 'https://example.com/team.jpg',
        ])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('gallery_images', ['id' => $image->id, 'title' => 'Tim teknis lapangan']);
        $this->actingAs($admin)->delete(route('admin.gallery.destroy', $image))->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('gallery_images', ['id' => $image->id]);
    }
}

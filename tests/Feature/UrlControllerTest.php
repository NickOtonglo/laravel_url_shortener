<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Url;
use App\Http\Controllers\Api\UrlController;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testEncode() {
        $response = $this->postJson('/api/encode', ['url' => 'https://example.com']);

        $response->assertStatus(200);
        $response->assertJsonStructure(['short_url']);
    }

    public function testDecode() {
        $url = Url::create([
            'original_url' => 'http://example.test',
            'hash' => 'hashexample',
            'short_url' => env('APP_URL').'/hashexample',
            'ip_address' => '127.0.0.1'
        ]);

        $response = $this->postJson('/api/decode', ['url' => env('APP_URL').'/hashexample']);

        $response->assertStatus(200);
        $response->assertJson(['original_url' => 'http://example.test']);
    }

    public function testDecodeNotFound() {
        $response = $this->postJson('/api/decode', ['url' => 'http://short.lnk/nonexistent']);

        $response->assertStatus(404);
        $response->assertJson(['error' => 'URL not found']);
    }

    public function testGenerateUrlHash() {
        $urlController = new UrlController();
        $hash = $urlController->generateUrlHash(8);

        $this->assertIsString($hash);
        $this->assertEquals(8, strlen($hash));
    }

    public function testRedirect() {
        $url = Url::create([
            'original_url' => 'http://example.test',
            'hash' => 'hashexample',
            'short_url' => env('APP_URL').'/hashexample',
            'ip_address' => '127.0.0.1'
        ]);

        $response = $this->get('/hashexample');

        $response->assertStatus(302);
        $response->assertRedirect('http://example.test');
    }

    public function testRedirectNotFound() {
        $response = $this->get('/nonexistent');

        $response->assertStatus(302);
        $response->assertSessionHas('error', 'URL not found');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function encode(Request $request)
    {
        $url = $request->input('url');
        return response()->json(['short_url' => $this->shorten($url)]);
    }

    public function decode(Request $request)
    {
        $data = Url::where('short_url', $request->url)->first();

        if (!$data) {
            return response()->json(['error' => 'URL not found'], 404);
        }

        return response()->json(['original_url' => $data->original_url]);
    }

    public function shorten($url)
    {
        // Convert the string to base64
        $base64String = base64_encode($url);
        
        // Remove padding characters and replace unsafe characters for URLs
        $hash = str_replace(['+', '/', '='], ['-', '_', ''], $base64String);

        // Generate a random string to use as the short URL
        $newUrl = env('APP_URL').'/'.$this->generateUrlHash(rand(5, 8));

        // Save URL to database
        $data = new Url();
        $data->original_url = $url;
        $data->hash = $hash;
        $data->short_url = $newUrl;
        $data->ip_address = request()->ip();
        $data->save();
        
        return $newUrl;
    }

    public function unshorten($url) {
        // Add back the padding characters and restore original base64 characters
        $base64String = str_replace(['-', '_'], ['+', '/'], $url);
        
        // Calculate and add padding if necessary
        $paddingLength = strlen($base64String) % 4;
        if ($paddingLength) {
            $base64String .= str_repeat('=', 4 - $paddingLength);
        }

        // Decode back to original string
        return base64_decode($base64String);
    }

    public function generateUrlHash($length = 8) {
        // Define the characters to use (alphanumeric)
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $length = min($length, 8);
        
        // total number of available characters
        $charLength = strlen($characters);
        
        // Initialise string
        $randomString = '';
        
        // Generate random string
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charLength - 1)];
        }
        
        return $randomString;
    }

    public function redirect($randomString){
        $data = Url::where('short_url', env('APP_URL').'/'.$randomString)->first();
    
        if (!$data) {
            return redirect('/')->with('error', 'URL not found');
        }

    
        return redirect($data->original_url);
    }
}

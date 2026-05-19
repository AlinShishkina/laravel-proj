<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ApiRecord;

class FetchApiData extends Command
{
    protected $signature = 'fetch:api-data';
    protected $description = 'Fetch data from public API and store in database';

    public function handle()
    {
        $this->info('Fetching data from API...');

        try {
            // Используем публичный API SpaceX 
            $response = Http::get('https://api.spacexdata.com/v4/dragons/5e9d058759b1ff74a7ad5f8f');
            
            if ($response->successful()) {
                $data = $response->json();
                
                ApiRecord::create([
                    'type' => $data['type'] ?? 'dragon',
                    'name' => $data['name'] ?? 'Crew Dragon',
                    'description' => $data['description'] ?? 'A spacecraft designed to carry humans',
                    'active' => $data['active'] ?? true,
                    'crew_capacity' => $data['crew_capacity'] ?? 7,
                    'api_response' => json_encode($data),
                ]);

                $this->info('Data successfully saved!');
            } else {
                $this->error('API request failed with status: ' . $response->status());
            }

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
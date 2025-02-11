<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CricketLiveService
{
    protected $apiKey;
    protected $baseUrl;
    
    public function __construct()
    {
        $this->apiKey = env('CRICAPI_KEY');
        $this->baseUrl = 'https://api.cricapi.com/v1';
    }
    
    public function getLiveMatches()
    {
        try {
            $response = Http::get("{$this->baseUrl}/currentMatches", [
                'apikey' => $this->apiKey,
                'offset' => 0
            ]);
            
            if ($response->successful()) {
                info('Live Matches Response: ' . $response->body());
                return $response->json()['data'];
            }
            
            throw new \Exception('Failed to fetch live matches');
        } catch (\Exception $e) {
            Log::error('Cricket API Error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function getMatchDetails($matchId)
    {
        try {
            $response = Http::get("{$this->baseUrl}/match_info", [
                'apikey' => $this->apiKey,
                'id' => $matchId
            ]);
            
            if ($response->successful()) {
                return $response->json()['data'];
            }
            
            throw new \Exception('Failed to fetch match details');
        } catch (\Exception $e) {
            Log::error('Match Details Error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function getPlayerStats($playerId)
    {
        try {
            $response = Http::get("{$this->baseUrl}/players_info", [
                'apikey' => $this->apiKey,
                'id' => $playerId
            ]);
            
            if ($response->successful()) {
                return $response->json()['data'];
            }
            
            throw new \Exception('Failed to fetch player stats');
        } catch (\Exception $e) {
            Log::error('Player Stats Error: ' . $e->getMessage());
            throw $e;
        }
    }
}





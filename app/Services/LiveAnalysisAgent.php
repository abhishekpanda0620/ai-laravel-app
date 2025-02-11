<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use GeminiAPI\Client;
use GeminiAPI\Resources\ModelName;
use GeminiAPI\Resources\Parts\TextPart;

class LiveAnalysisAgent
{
    protected $cricketService;

    public function __construct(CricketLiveService $cricketService)
    {
        $this->cricketService = $cricketService;
    }

    public function analyzeLiveMatch($matchId)
    {

        try {
            info('Analyzing live match: ' . $matchId);
            // Get match details
            $matchData = $this->cricketService->getMatchDetails($matchId);
            // Generate analysis using Gemini
            $analysis = $this->generateLiveAnalysis($matchData);
            dd($analysis);

            // Get predictions
            $predictions = $this->generatePredictions($matchData);

            return [
                'match_data' => $matchData,
                'analysis' => $analysis,
                'predictions' => $predictions
            ];
        } catch (\Exception $e) {
            Log::error('Live Analysis Error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function generateLiveAnalysis($matchData)
    {
        info('Generating live analysis...');
        info('Match Data: ' . json_encode($matchData));
        $prompt = "As a cricket analyst, analyze this live match situation:
                   Match Data: " . json_encode($matchData) . "
                   
                   Provide:
                   1. Current match situation analysis
                   2. Key moments so far
                   3. Player performances
                   4. Strategic recommendations
                   5. Critical factors affecting the game";

        $client = new Client(env('GEMINI_API_KEY'));
        $response = $client->generativeModel(ModelName::GEMINI_PRO)->generateContent(
            new TextPart($prompt),
        );
        $generatedText = $response->text();
        return $generatedText;
    }

    private function generatePredictions($matchData)
    {
        $prompt = "Based on current match situation, predict:
                   Match Data: " . json_encode($matchData) . "
                   
                   Provide:
                   1. Projected final score
                   2. Win probability
                   3. Key players to watch
                   4. Potential game-changing moments
                   5. Risk factors";

        return Gemini::geminiPro()->generateContent($prompt)->text();
    }
}

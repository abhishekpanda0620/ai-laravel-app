<?php

namespace App\Http\Controllers;

use App\Services\CricketLiveService;
use App\Services\LiveAnalysisAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// Controller
class LiveCricketController extends Controller
{
    protected $liveService;
    protected $analysisAgent;

    public function __construct(CricketLiveService $liveService, LiveAnalysisAgent $analysisAgent)
    {
        $this->liveService = $liveService;
        $this->analysisAgent = $analysisAgent;
    }

    public function getLiveMatches()
    {
        try {
            // Cache live matches for 1 minute
            $matches = Cache::remember('live_matches', 60, function () {
                return $this->liveService->getLiveMatches();
            });

            return response()->json([
                'success' => true,
                'matches' => $matches
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch live matches'
            ], 500);
        }
    }

    public function getMatchAnalysis($matchId)
    {
        try {
            info('getMatchAnalysis: ' . $matchId);
            // Cache analysis for 2 minutes
            $analysis = Cache::remember("match_analysis_{$matchId}", 120, function () use ($matchId) {
                return $this->analysisAgent->analyzeLiveMatch($matchId);
            });

            return response()->json([
                'success' => true,
                'analysis' => $analysis
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Analysis failed'
            ], 500);
        }
    }
}

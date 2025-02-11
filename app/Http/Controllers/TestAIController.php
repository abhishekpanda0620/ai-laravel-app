<?php

namespace App\Http\Controllers;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;

class TestAIController extends Controller
{
    public function index()
    {
        $result = Gemini::geminiPro()->generateContent('Hello');

        $result->text(); // Hello! How can I assist you today?
    }
}

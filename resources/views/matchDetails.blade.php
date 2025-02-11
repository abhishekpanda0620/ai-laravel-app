@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Match Analysis</h1>
    <div id="analysis-container">
        <p>Loading match analysis...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Retrieve the matchId passed from the route.
    const matchId = "{{ $matchId }}";
    
    // Fetch match analysis from the API endpoint
    fetch('api/cricket/match-analysis/' + matchId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const analysisData = data.analysis;
                // Build HTML output using the match data and analysis details
                let html = `
                    <h2>${analysisData.match_data.t1} vs ${analysisData.match_data.t2}</h2>
                    <p>Status: ${analysisData.match_data.status}</p>
                    <p>Series: ${analysisData.match_data.series}</p>
                    <hr>
                    <h3>Live Analysis</h3>
                    <p>${analysisData.analysis}</p>
                    <hr>
                    <h3>Predictions</h3>
                    <p>${analysisData.predictions}</p>
                `;
                document.getElementById('analysis-container').innerHTML = html;
            } else {
                document.getElementById('analysis-container').innerHTML = "<p>Failed to load match analysis.</p>";
            }
        })
        .catch(error => {
            console.error('Error fetching analysis:', error);
            document.getElementById('analysis-container').innerHTML = "<p>Error fetching analysis.</p>";
        });
});
</script>
@endsection

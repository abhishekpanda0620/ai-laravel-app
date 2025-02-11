@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Current Cricket Matches</h1>
    <div id="matches-container">
        <ul class="list-group" id="matches-list">
            <!-- The matches will be injected here -->
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Fetch the current matches from the API endpoint
    fetch('api/cricket/live-matches')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const matches = data.matches;
                const list = document.getElementById('matches-list');
                matches.forEach(match => {
                    // Create a list item for each match. When clicked, it will take the user to the match details page.
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    
                    li.innerHTML = `
                        <a href="/match-details/${match.id}" style="text-decoration: none; color: inherit;">
                            <div class="d-flex align-items-center">
                                <img src="${match.t1img}" alt="${match.t1}" class="me-2" style="width: 48px;">
                                <strong>${match.t1}</strong>
                                <span class="mx-2">vs</span>
                                <img src="${match.t2img}" alt="${match.t2}" class="me-2" style="width: 48px;">
                                <strong>${match.t2}</strong>
                            </div>
                            <div>
                                <small>${match.status} | ${match.series}</small>
                            </div>
                        </a>
                    `;
                    list.appendChild(li);
                });
            } else {
                document.getElementById('matches-container').innerHTML = "<p>No matches available at the moment.</p>";
            }
        })
        .catch(error => {
            console.error('Error fetching matches:', error);
            document.getElementById('matches-container').innerHTML = "<p>Error fetching matches.</p>";
        });
});
</script>
@endsection

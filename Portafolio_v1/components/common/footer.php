<footer class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-nav">
                    <a href="#">About</a>
                    <a href="#">Education</a>
                    <a href="#">Experience</a>
                    <a href="#">Projects</a>
                    <a href="#">Curriculum</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="spotify-section">
                    <h5><i class="fab fa-spotify"></i> Recently Played</h5>
                    <div id="spotifyRecentlyPlayed">
                        <!-- Spotify recently played tracks will be dynamically inserted here -->
                        <p>Loading recently played tracks...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    // Placeholder function for Spotify API integration
    function loadSpotifyRecentlyPlayed() {
            // This is where you'd normally fetch data from the Spotify API
            // For now, we'll just simulate it with some dummy data
            const recentlyPlayed = [
                { title: "Song 1", artist: "Artist 1" },
                { title: "Song 2", artist: "Artist 2" },
                { title: "Song 3", artist: "Artist 3" }
            ];

            const spotifyContainer = document.getElementById('spotifyRecentlyPlayed');
            spotifyContainer.innerHTML = recentlyPlayed.map(track => `
                <p><strong>${track.title}</strong> by ${track.artist}</p>
            `).join('');
        }

        // Load Spotify data (placeholder)
        loadSpotifyRecentlyPlayed();
</script>
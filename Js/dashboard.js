document.addEventListener("DOMContentLoaded", function() {
    // Handle total players and total games played
    const totalPlayers = document.getElementById("total-players");
    const totalPlayed = document.getElementById("total-played");

    // Ensure these elements exist in the DOM before interacting with them
    if (totalPlayers && totalPlayed) {
        // Sample data
        totalPlayers.innerText = 150; // Replace with server-side data
        totalPlayed.innerText = 300;  // Replace with server-side data
    }

    // Handle Play button click
    const playButton = document.querySelector('.play-btn');
    if (playButton) {
        playButton.addEventListener('click', function() {
            alert("Play button clicked");
            // Add navigation to the game play section
        });
    }

    // Handle Create button click
    const createButton = document.querySelector('.create-btn');
    if (createButton) {
        createButton.addEventListener('click', function() {
            alert("Create button clicked");
            // Add logic for creating a maze
        });
    }

    // Get the elements for user profile icon and popup menu
    const userIcon = document.getElementById('user-icon');
    const popupMenu = document.getElementById('popup-menu');

    if (userIcon && popupMenu) {
        // Toggle popup visibility when user icon is clicked
        userIcon.addEventListener('click', function() {
            popupMenu.style.display = (popupMenu.style.display === 'block') ? 'none' : 'block';
        });

        // Close the popup if clicking outside of it
        document.addEventListener('click', function(event) {
            if (!userIcon.contains(event.target) && !popupMenu.contains(event.target)) {
                popupMenu.style.display = 'none';
            }
        });
    }

    
});

// // Sidebar toggle functionality
// document.addEventListener("DOMContentLoaded", function() {
//     const toggleSidebarIcon = document.getElementById('toggle-sidebar');
//     const sidebar = document.getElementById('sidebar');
//     const mainContent = document.querySelector('.main-content');

//     if (toggleSidebarIcon && sidebar && mainContent) {
//         toggleSidebarIcon.addEventListener('click', function() {
//             // Toggle the collapsed class for both sidebar and main content
//             sidebar.classList.toggle('sidebar-collapsed');
//             mainContent.classList.toggle('main-content-collapsed');
//         });
//     } else {
//         console.error('Sidebar or main content elements not found');
//     }
// });


document.addEventListener("DOMContentLoaded", function () {
    const compareButton = document.querySelector(".compare-button");
    const changeButton = document.querySelector(".change-button");
    const searchContainer = document.querySelector(".search-container");
    const changeContainer = document.querySelector(".change-container");

    // Compare button functionality
    compareButton.addEventListener("click", function (event) {
        event.preventDefault();
        toggleVisibility(searchContainer);
    });

    // Change button functionality
    changeButton.addEventListener("click", function (event) {
        event.preventDefault();
        toggleVisibility(changeContainer);
    });

    // Function to toggle visibility of containers
    function toggleVisibility(container) {
        if (container.style.display === "block") {
            container.style.display = "none";
        } else {
            container.style.display = "block";
        }
    }

    // Event listener for hiding dropdown when input loses focus
    document.getElementById("search-input").addEventListener("blur", function () {
        setTimeout(function () {
            document.getElementById("search-suggestions-dropdown").style.display = "none";
        }, 200);
    });

    document.getElementById("change-input").addEventListener("blur", function () {
        setTimeout(function () {
            document.getElementById("change-suggestions-dropdown").style.display = "none";
        }, 200);
    });
});

// Function to fetch search suggestions for the "Compare to..." input
function searchSuggestions() {
    let query = document.getElementById("search-input").value;
    let dropdown = document.getElementById("search-suggestions-dropdown");
    let currentId = new URLSearchParams(window.location.search).get('id'); // Get id1 from URL

    // Ensure minimum query length
    if (query.length > 2) {
        fetch(`../functions/search_suggestions.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(results => {
                dropdown.innerHTML = ""; // Clear previous suggestions

                if (results.length > 0) {
                    results.forEach(result => {
                        let suggestion = document.createElement("a");
                        suggestion.href = `../view/comparison.php?id1=${currentId}&id2=${result.gadget_id}`;
                        suggestion.textContent = result.name;
                        dropdown.appendChild(suggestion);
                    });
                    dropdown.style.display = "block";
                } else {
                    dropdown.style.display = "none";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                dropdown.style.display = "none";
            });
    } else {
        dropdown.style.display = "none";
    }
}

// Function to fetch search suggestions for the "Change to..." input
function change() {
    let query = document.getElementById("change-input").value;
    let dropdown = document.getElementById("change-suggestions-dropdown");
    let currentId = new URLSearchParams(window.location.search).get('id'); // Get id1 from URL

    // Ensure minimum query length
    if (query.length > 2) {
        fetch(`../functions/search_suggestions.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(results => {
                dropdown.innerHTML = ""; // Clear previous suggestions

                if (results.length > 0) {
                    results.forEach(result => {
                        let suggestion = document.createElement("a");
                        suggestion.href = `../view/compare.php?id=${result.gadget_id}`;
                        suggestion.textContent = result.name;
                        dropdown.appendChild(suggestion);
                    });
                    dropdown.style.display = "block";
                } else {
                    dropdown.style.display = "none";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                dropdown.style.display = "none";
            });
    } else {
        dropdown.style.display = "none";
    }

   
}
 // Function to add navigation functionality to a parent div
 function addNavigationFunctionality(parentDiv) {
    const navLinks = parentDiv.querySelectorAll(".navigation-buttons a");
    const sections = parentDiv.querySelectorAll(".section-content");

    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            
            // Highlight active link
            navLinks.forEach(nav => {
                nav.querySelector('button').classList.remove("active");
            });
            this.querySelector('button').classList.add("active");
            
            // Show corresponding section
            sections.forEach(section => {
                section.classList.remove("active");
            });
            
            const targetId = this.getAttribute("href").substring(1);
            const targetSection = parentDiv.querySelector(`#${targetId}`);
            targetSection.classList.add("active");
        });

        // Set initial active button
        if (link.getAttribute("href").includes("specs")) {
            link.querySelector('button').classList.add("active");
        }
    });
}
 // Add navigation functionality to the original parent
 addNavigationFunctionality(document.querySelector('.parent'));



window.addEventListener("scroll", function() {
    const header = document.querySelector(".header");
    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});

    document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".bg-slide");
    let currentIndex = 0;

    function showNextSlide() {
    slides[currentIndex].classList.remove("active");
    currentIndex = (currentIndex + 1) % slides.length;
    slides[currentIndex].classList.add("active");
    }

    // Change slide every 5 seconds
    setInterval(showNextSlide, 5000);
 });

 function searchSuggestions() {
    let query = document.getElementById("search-input").value;
    let dropdown = document.getElementById("suggestions-dropdown");

    // Ensure minimum query length
    if (query.length > 2) {
        fetch(`../functions/search_suggestions.php?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
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

document.getElementById("search-input").addEventListener("blur", function() {
    // Hide the dropdown if the input loses focus
    setTimeout(function() {
        document.getElementById("suggestions-dropdown").style.display = "none";
    }, 200);
});

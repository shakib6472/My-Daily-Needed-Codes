<script>
// Step 1: Get percentage from URL and parse to integer
function getPercentageFromURL() {
    // Get query string
    const urlParams = new URLSearchParams(window.location.search);
    // Get 'mark' parameter value and parse to integer
    const percentage = parseInt(parseFloat(urlParams.get('mark'))); 
    return isNaN(percentage) ? 0 : percentage;
}

// Step 2: Update all .percentage h2 innerText
function updatePercentageText(percentage) {
    const percentageElements = document.querySelectorAll('.percentage h2');
    percentageElements.forEach(el => {
        el.innerText = percentage + '%';
    });
}


// Step 4: Show section based on percentage
function showSectionByPercentage(percentage) {
    // Hide all first
    const sections = ['percent100', 'percent70-99', 'percent51-69', 'percent50'];
    sections.forEach(id => {
        const section = document.getElementById(id);
        if (section) section.style.display = "none";
    });

    let showId;
    if (percentage > 99) showId = 'percent100';
    else if (percentage >= 70 && percentage <= 99) showId = 'percent70-99';
    else if (percentage >= 51 && percentage <= 69) showId = 'percent51-69';
    else showId = 'percent50';

    const sectionToShow = document.getElementById(showId);
    if (sectionToShow) sectionToShow.style.display = "flex";
}

// Main function to call everything
(function() {
    const percentage = getPercentageFromURL();
    updatePercentageText(percentage);
 
    showSectionByPercentage(percentage);
})();
</script>

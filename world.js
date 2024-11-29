document.addEventListener("DOMContentLoaded", function() {
    const lookupButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");

    // Lookup button
    lookupButton.addEventListener("click", function() {
        const country = document.getElementById("country").value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}`;

        // Clear previous results
        resultDiv.innerHTML = "";

        // Fetch the data from world.php 
        fetch(url)
            .then(response => response.text())  // Parse the response
            .then(data => {
                resultDiv.innerHTML = data;  // Insert the table into the result div
            })
            .catch(error => {
                resultDiv.innerHTML = `<p>An error occurred while fetching the data. Please try again.</p>`;
                console.error('Fetch error:', error);
            });
    });

    // Lookup Cities button
    lookupCitiesButton.addEventListener("click", function() {
        const country = document.getElementById("country").value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}&lookup=cities`;

        // Clear previous results
        resultDiv.innerHTML = "";

        // Fetch the data from world.php 
        fetch(url)
            .then(response => response.text())  // Parse the response
            .then(data => {
                resultDiv.innerHTML = data;  // Insert the table into the result div
            })
            .catch(error => {
                resultDiv.innerHTML = `<p>An error occurred while fetching the data. Please try again.</p>`;
                console.error('Fetch error:', error);
            });
    });
});

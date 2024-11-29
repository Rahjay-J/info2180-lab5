document.addEventListener("DOMContentLoaded", function() {
    const lookupButton = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");

    // Listen for click on "Lookup" button
    lookupButton.addEventListener("click", function() {
        const country = document.getElementById("country").value.trim();
        const url = `world.php?country=${encodeURIComponent(country)}`;

        // Clear previous results
        resultDiv.innerHTML = "";

        // Fetch the data from world.php
        fetch(url)
            .then(response => response.json())  // Parse the JSON response
            .then(data => {
                if (data.success) {
                    // If the search is successful, create and display the table
                    let tableHTML = `
                        <table border="1" cellpadding="10" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Country Name</th>
                                    <th>Continent</th>
                                    <th>Independence Year</th>
                                    <th>Head of State</th>
                                </tr>
                            </thead>
                            <tbody>`;

                    // Loop through the data and create rows for the table
                    data.data.forEach(country => {
                        tableHTML += `
                            <tr>
                                <td>${country.name}</td>
                                <td>${country.continent}</td>
                                <td>${country.independence_year}</td>
                                <td>${country.head_of_state}</td>
                            </tr>`;
                    });

                    tableHTML += `</tbody></table>`;
                    resultDiv.innerHTML = tableHTML;  // Insert the table into the result div
                } else {
                    // If no results found, display the message
                    resultDiv.innerHTML = `<p>No countries found matching that name.</p>`;
                }
            })
            .catch(error => {
                // Handle any errors that occurred during the fetch
                resultDiv.innerHTML = `<p>An error occurred while fetching the data. Please try again.</p>`;
                console.error('Fetch error:', error);
            });
    });
});

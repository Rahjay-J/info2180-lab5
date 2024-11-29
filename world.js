document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('lookup').addEventListener('click', function() {
        console.log('Button clicked!');
        
        const country = document.getElementById('country').value.trim();
        const resultDiv = document.getElementById('result');
        resultDiv.innerHTML = ''; // Clear previous results

        if (country === "") {
            resultDiv.innerHTML = '<p class="error-message">Please enter a country name.</p>';
            return;
        }

        const url = `world.php?country=${encodeURIComponent(country)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Response Data:', data);

                if (data.error) {
                    resultDiv.innerHTML = `<p class="error-message">${data.error}</p>`;
                } else if (data.length > 0) {
                    data.forEach(countryData => {
                        const countryInfo = `
                            <div class="country-item">
                                <h3>${countryData.name}</h3>
                                <p><strong>Region:</strong> ${countryData.region}</p>
                                <p><strong>Population:</strong> ${countryData.population}</p>
                                <p><strong>Area:</strong> ${countryData.area} km²</p>
                            </div>
                        `;
                        resultDiv.innerHTML += countryInfo;
                    });
                } else {
                    resultDiv.innerHTML = '<p class="error-message">No countries found matching that name.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = '<p class="error-message">An error occurred while fetching the data. Please try again.</p>';
            });
    });
});

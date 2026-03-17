// 1. Global array to temporarily store our fetched SQL data locally
let globalCanteenData = [];

// 2. Wait for the HTML DOM to fully load before running the script
document.addEventListener('DOMContentLoaded', () => {
    fetchCatalogue();

    // 3. Event Listener for the Drop-down menu
    document.getElementById('categoryFilter').addEventListener('change', (event) => {
        const selectedCategory = event.target.value;
        filterCatalogue(selectedCategory);
    });
});

// 4. Fetch the JSON data from the PHP back-end bridge
function fetchCatalogue() {
    fetch('get_items.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            globalCanteenData = data;
            renderCatalogue(globalCanteenData);
        })
        .catch(error => {
            console.error('Error fetching catalogue:', error);
            document.getElementById('catalogue-container').innerHTML =
                '<p class="text-danger text-center">Failed to load the catalogue.</p>';
        });
}

// 5. The Filtering Algorithm
function filterCatalogue(category) {
    if (category === 'All') {
        renderCatalogue(globalCanteenData);
    } else {
        const filteredData = globalCanteenData.filter(item => item.department_name === category);
        renderCatalogue(filteredData);
    }
}

// 6. The UI Rendering Logic (Updated for Accessibility)
function renderCatalogue(dataToRender) {
    const container = document.getElementById('catalogue-container');
    container.innerHTML = '';

    if (dataToRender.length === 0) {
        container.innerHTML = '<p class="text-center text-muted">No items found in this category.</p>';
        return;
    }

    dataToRender.forEach(item => {
        const cardHTML = `
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <!-- h3 for sequential accessibility hierarchy -->
                        <h3 class="card-title mb-0 fs-5">${item.department_name}</h3>
                    </div>
                    <div class="card-body">
                        <!-- h4 for sequential accessibility hierarchy -->
                        <h4 class="card-subtitle mb-2 text-muted fs-6">${item.item_name}</h4>
                        <p class="card-text fs-4 fw-bold">$${item.price}</p>
                        <button class="btn btn-outline-success w-100">Add to Order</button>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += cardHTML;
    });
}

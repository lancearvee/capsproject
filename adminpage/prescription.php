<?php
include('../adminpage/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
?>

<style>
    .preload {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>
<div id="preload" class="preload">
    <div class="spinner"></div>
</div>




  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header" style="display: flex; align-items: center;">
                    <h3 class="card-title">Prescription</h3>
                </div>
                <div class="card-body">
                    <div class="tab-pane">
                    <div class="search-box position-relative">
                        <form action="/search" method="GET">
                        <input
                            type="text"
                            id="medicineSearch"
                            name="query"
                            class="form-control"
                            placeholder="Search medicine..."
                            aria-label="Search"
                        >
                        <div id="suggestions" class="dropdown-menu"></div>
                        </form>
                    </div>
                    <div id="medicine-table-container"></div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="process-btn">Process</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>



  </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('#medicineSearch');
    const suggestionsBox = document.querySelector('#suggestions');
    const tableContainer = document.querySelector('#medicine-table-container');
    const processButton = document.querySelector('#process-btn');

    if (!searchInput || !suggestionsBox || !tableContainer || !processButton) return;

    // Handle typing in the search input to show medicine suggestions
    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();

        if (query.length > 1) { // Start suggesting after 2+ characters
            fetch(`../backendAdmin/fetch_medicine.php?term=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';

                    if (data.length > 0) {
                        suggestionsBox.classList.add('show');
                        data.forEach(item => {
                        const suggestion = document.createElement('a');
                        suggestion.className = 'dropdown-item';
                        
                        // Get today's date and compare with expiry date
                        const expiryDate = new Date(item.expiry_date);
                        const today = new Date();
                        const expired = expiryDate < today;

                        // Show "Expired" if expired, and do not show expiry_date in that case
                        const expiredText = expired ? 'Expired' : `${item.expiry_date}`;

                        // Update the suggestion text based on expiry status
                        suggestion.textContent = `${item.brand_name} - ${item.medicine_name}, ${item.dosage} (${item.gram}g) ${expiredText}`;
                        suggestion.onclick = () => {
                            searchInput.value = ''; // Clear the input
                            suggestionsBox.classList.remove('show');
                            addMedicineRow(item); // Pass item directly to add the row
                        };
                        suggestionsBox.appendChild(suggestion);
                    });

                    } else {
                        suggestionsBox.classList.remove('show');
                    }
                })
                .catch(error => console.error('Error fetching suggestions:', error));
        } else {
            suggestionsBox.classList.remove('show');
        }
    });

    // Close suggestions when clicking outside the input or suggestions box
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.remove('show');
        }
    });

    // Function to add a single row for the selected medicine
    function addMedicineRow(medicine) {
        const { brand_name, medicine_name, dosage, gram, price_unit, id, stock_qty, expired } = medicine;

        // Check if the medicine is already added (by id)
        const existingRow = Array.from(tableContainer.querySelectorAll('tr')).some(row => {
            const rowId = row.querySelector('.medicine-id');
            return rowId && rowId.value === id;
        });

        if (existingRow) {
            alert("This medicine is already added.");
            return;
        }

        // If the table doesn't exist, create it
        if (tableContainer.innerHTML === '') {
            tableContainer.innerHTML = `
                <table class="table table-bordered" id="medicine-table">
                    <thead>
                        <tr>
                            <th>Brand</th>
                            <th>Medicine</th>
                            <th>Dosage</th>
                            <th>Gram</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="medicine-table-body">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right"><strong>Total:</strong></td>
                            <td id="total-price" colspan="2"><strong>0.00</strong></td>
                        </tr>
                    </tfoot>
                </table>
            `;
        }

        // Create a new row with the selected medicine data
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <input type="hidden" class="medicine-id" value="${id}">
            <td><input type="text" class="form-control medicine-brand" value="${brand_name}" readonly></td>
            <td><input type="text" class="form-control medicine-name" value="${medicine_name}" readonly></td>
            <td><input type="text" class="form-control medicine-dosage" value="${dosage}" readonly></td>
            <td><input type="text" class="form-control medicine-gram" value="${gram}" readonly></td>
            <td><input type="text" class="form-control medicine-price" value="${price_unit}" readonly></td>
            <td><input type="number" class="form-control medicine-quantity" value="0" min="0" max="${stock_qty}"></td>
            <td><input type="text" class="form-control medicine-total" value="0" readonly></td>
            <td><button type="button" class="btn btn-danger remove-btn">X</button></td>
        `;
        
        // Append the row to the table body
        tableContainer.querySelector('#medicine-table-body').appendChild(newRow);
        updateTotal(newRow.querySelector('.medicine-quantity'));

        // Check if the medicine is expired
        if (expired) {
            // If expired, show alert and reset quantity to 0 when user tries to input a number greater than 0
            newRow.querySelector('.medicine-quantity').addEventListener('input', function () {
                const quantity = parseFloat(this.value);
                if (quantity > 0) {
                    alert("This medicine is expired.");
                    this.value = 0; // Reset the quantity to 0
                    updateTotal(this); // Update total
                }
            });
        }

        // Add event listener for quantity input to update total dynamically
        newRow.querySelector('.medicine-quantity').addEventListener('input', function () {
            const quantity = parseFloat(this.value);
            if (quantity > stock_qty) {
                alert(`Out of stocks! The current stock for this medicine is ${stock_qty}.`);
                this.value = stock_qty;
            }
            updateTotal(this);
        });

        // Add event listener to the remove button in the new row
        newRow.querySelector('.remove-btn').addEventListener('click', function () {
            removeRow(newRow);
        });

        // Update the total price in the footer after adding the row
        updateFooterTotal();
    }


    // Function to update the total price based on quantity
    function updateTotal(inputElement) {
        const row = inputElement.closest('tr');
        const quantity = parseFloat(inputElement.value) || 0;
        const price = parseFloat(row.querySelector('.medicine-price').value) || 0;
        const total = row.querySelector('.medicine-total');
        total.value = (quantity * price).toFixed(2);

        // Update the total price in the footer after calculating
        updateFooterTotal();
    }

    // Function to remove a row from the table
    function removeRow(row) {
        row.remove();
        // If the table is empty, hide the table container
        if (tableContainer.querySelector('#medicine-table-body').children.length === 0) {
            tableContainer.innerHTML = ''; // Clear the table container
        } else {
            updateFooterTotal(); // Update the total in the footer
        }
    }

    // Function to update the total price in the footer
    function updateFooterTotal() {
        const allRows = tableContainer.querySelectorAll('#medicine-table-body tr');
        let totalSum = 0;

        allRows.forEach(row => {
            const rowTotal = parseFloat(row.querySelector('.medicine-total').value) || 0;
            totalSum += rowTotal;
        });

        tableContainer.querySelector('#total-price').innerHTML = `<strong>${totalSum.toFixed(2)}</strong>`;
    }

    // Handling the Process button click
    processButton.addEventListener('click', function () {
        const medicineRows = document.querySelectorAll('#medicine-table-body tr');
        const medicines = [];

        medicineRows.forEach(row => {
            const medicineId = row.querySelector('.medicine-id').value;
            const brandName = row.querySelector('.medicine-brand').value;
            const medicineName = row.querySelector('.medicine-name').value;
            const dosage = row.querySelector('.medicine-dosage').value;
            const gram = row.querySelector('.medicine-gram').value;
            const priceUnit = row.querySelector('.medicine-price').value;
            const quantity = row.querySelector('.medicine-quantity').value;

            medicines.push({
                id: medicineId,
                brand_name: brandName,
                medicine_name: medicineName,
                dosage: dosage,
                gram: gram,
                price_unit: priceUnit,
                quantity: quantity
            });
        });

        // Show confirmation popup
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to process on payment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Handle form submission here (assuming you have a form to submit)
                // For example, you can append the medicines to the form and submit
                const form = document.createElement("form");
                form.method = "POST";  // POST or whatever method
                form.action = "../backendAdmin/prescription_alone.php";  // Adjust the action URL

                // Append the medicines to the form
                const medicinesInput = document.createElement("input");
                medicinesInput.type = "hidden";
                medicinesInput.name = "medicines";
                medicinesInput.value = JSON.stringify(medicines); 
                form.appendChild(medicinesInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            sessionStorage.removeItem('successMessage');
        }
    });
</script>

<script>
    window.addEventListener('load', function() {
    document.getElementById('preload').style.display = 'none';
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
include('../adminpage/footer.php');
?>
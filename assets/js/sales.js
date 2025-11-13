document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('medicine-search');
    const searchResults = document.getElementById('search-results');
    const billingTableBody = document.querySelector('#billing-table tbody');
    const amountPaidInput = document.getElementById('amount_paid');

    // Live search for medicines
    searchInput.addEventListener('keyup', function() {
        const term = searchInput.value;
        if (term.length < 2) {
            searchResults.innerHTML = '';
            return;
        }
        fetch(`ajax_search.php?term=${term}`)
            .then(response => response.json())
            .then(data => {
                let list = '<ul>';
                data.forEach(med => {
                    list += `<li data-id="${med.med_id}" data-name="${med.med_name}" data-packing="${med.packing}" data-price="${med.price}">
                                ${med.med_name} (${med.packing}) - $${med.price}
                             </li>`;
                });
                list += '</ul>';
                searchResults.innerHTML = list;
            });
    });

    // Add medicine to bill when clicked from search results
    searchResults.addEventListener('click', function(e) {
        if (e.target.tagName === 'LI') {
            const medId = e.target.dataset.id;
            // Check if item is already in the bill
            if (document.querySelector(`tr[data-id="${medId}"]`)) {
                alert('This medicine is already in the bill.');
                return;
            }

            const row = document.createElement('tr');
            row.dataset.id = medId;
            row.innerHTML = `
                <td>${e.target.dataset.name}<input type="hidden" name="med_id[]" value="${medId}"></td>
                <td>${e.target.dataset.packing}</td>
                <td class="price">${parseFloat(e.target.dataset.price).toFixed(2)}</td>
                <td><input type="number" name="quantity[]" class="quantity" value="1" min="1"></td>
                <td class="total">${parseFloat(e.target.dataset.price).toFixed(2)}</td>
                <td><button type="button" class="btn-delete remove-item">Remove</button></td>
            `;
            billingTableBody.appendChild(row);
            searchInput.value = '';
            searchResults.innerHTML = '';
            updateTotals();
        }
    });

    // Update totals when quantity or amount paid changes
    document.querySelector('#sale-form').addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity') || e.target.id === 'amount_paid') {
            updateTotals();
        }
    });
    
    // Remove item from bill
    billingTableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            updateTotals();
        }
    });

    // Function to calculate and update all totals
    function updateTotals() {
        let subtotal = 0;
        billingTableBody.querySelectorAll('tr').forEach(row => {
            const price = parseFloat(row.querySelector('.price').textContent);
            const quantity = parseInt(row.querySelector('.quantity').value);
            const total = price * quantity;
            row.querySelector('.total').textContent = total.toFixed(2);
            subtotal += total;
        });

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('total_amount_hidden').value = subtotal.toFixed(2);

        const amountPaid = parseFloat(amountPaidInput.value) || 0;
        const changeDue = amountPaid - subtotal;
        document.getElementById('change_due').textContent = changeDue.toFixed(2);
    }
});
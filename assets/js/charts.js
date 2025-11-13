document.addEventListener('DOMContentLoaded', function() {
    // Fetch data from our PHP script
    fetch('get_chart_data.php')
        .then(response => response.json())
        .then(data => {
            // --- Create Sales Trend Line Chart ---
            const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: data.salesTrend.labels,
                    datasets: [{
                        label: 'Daily Sales (₹)',
                        data: data.salesTrend.data,
                        borderColor: '#f36d21', // Orange
                        backgroundColor: 'rgba(243, 109, 33, 0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // --- Create Low Stock Bar Chart ---
            const stockCtx = document.getElementById('lowStockChart').getContext('2d');
            new Chart(stockCtx, {
                type: 'bar',
                data: {
                    labels: data.lowStock.labels,
                    datasets: [{
                        label: 'Stock Quantity',
                        data: data.lowStock.data,
                        backgroundColor: '#2c3e50' // Dark Blue
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y' } // 'y' for horizontal bars
            });
        });
});
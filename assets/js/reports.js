// Reports Page Management
const ReportsManager = {
    elements: {
        reportDate: document.getElementById('reportDate'),
        hourlySalesChart: document.getElementById('hourlySalesChart'),
        topItemsChart: document.getElementById('topItemsChart'),
        totalSales: document.querySelector('.bg-primary h2'),
        itemsSold: document.querySelector('.bg-success h2'),
        averageSale: document.querySelector('.bg-info h2'),
        salesTable: document.querySelector('.table tbody')
    },

    // Sample data structure for sales
    sampleData: {
        totalSales: 15250.00,
        itemsSold: 127,
        averageSale: 120.08,
        hourlyData: [500, 750, 1200, 1500, 2000, 1800, 1600, 1400, 1200, 1000, 1300, 1000],
        topItems: {
            labels: ['Pandesal', 'Chocolate Cake', 'Ensaymada', 'Cheese Bread', 'Mango Cake'],
            data: [45, 25, 20, 15, 12]
        },
        salesList: [
            { time: '08:30 AM', items: ['Pandesal x10', 'Cheese Bread x2'], total: 130.00, payment: 'Cash' },
            { time: '09:15 AM', items: ['Chocolate Cake x1'], total: 550.00, payment: 'Card' },
            { time: '10:00 AM', items: ['Ensaymada x5', 'Pandesal x20'], total: 350.00, payment: 'Cash' }
        ]
    },

    // Initialize charts
    initCharts() {
        // Hourly Sales Chart
        this.charts = {};
        this.charts.hourlySales = new Chart(this.elements.hourlySalesChart.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['6AM', '7AM', '8AM', '9AM', '10AM', '11AM', '12PM', '1PM', '2PM', '3PM', '4PM', '5PM'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: this.sampleData.hourlyData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '₱' + value.toLocaleString()
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => '₱' + context.parsed.y.toLocaleString()
                        }
                    }
                }
            }
        });

        // Top Items Chart
        this.charts.topItems = new Chart(this.elements.topItemsChart.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: this.sampleData.topItems.labels,
                datasets: [{
                    data: this.sampleData.topItems.data,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    },

    // Update dashboard with new data
    updateDashboard(data = this.sampleData) {
        // Update summary cards
        this.elements.totalSales.textContent = '₱' + data.totalSales.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        this.elements.itemsSold.textContent = data.itemsSold + ' items';
        this.elements.averageSale.textContent = '₱' + data.averageSale.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Update sales table
        this.elements.salesTable.innerHTML = data.salesList.map(sale => `
            <tr>
                <td>${sale.time}</td>
                <td>${sale.items.join(', ')}</td>
                <td>₱${sale.total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td><span class="badge bg-${sale.payment.toLowerCase() === 'cash' ? 'success' : 'primary'}">${sale.payment}</span></td>
            </tr>
        `).join('');

        // Update charts
        this.charts.hourlySales.data.datasets[0].data = data.hourlyData;
        this.charts.hourlySales.update();

        this.charts.topItems.data.labels = data.topItems.labels;
        this.charts.topItems.data.datasets[0].data = data.topItems.data;
        this.charts.topItems.update();
    },

    // Handle date change
    handleDateChange(event) {
        const selectedDate = event.target.value;
        // TODO: Fetch actual data for the selected date
        // For now, using sample data
        this.updateDashboard();
    },

    // Initialize
    init() {
        this.initCharts();
        this.updateDashboard();

        // Event listeners
        this.elements.reportDate.addEventListener('change', (e) => this.handleDateChange(e));
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => ReportsManager.init());

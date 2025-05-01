@include('_layouts.header')
@include('_layouts.leftbar')

<div class="container">
    <div class="flex-grow flex">
        <section class="w-full p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white shadow rounded-lg p-4">
                    <h2 class="text-lg font-semibold">Total Transactions</h2>
                    <p class="text-2xl font-bold">1,234</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <h2 class="text-lg font-semibold">Total Users</h2>
                    <p class="text-2xl font-bold">567</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <h2 class="text-lg font-semibold">Total Revenue</h2>
                    <p class="text-2xl font-bold">$12,345</p>
                </div>
                <div class="bg-white shadow rounded-lg p-4">
                    <h2 class="text-lg font-semibold">New Orders</h2>
                    <p class="text-2xl font-bold">89</p>
                </div>
            </div>
        </section>
    </div>
    <div class="flex-grow flex">
        <section class="w-full p-4">
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Sales Chart</h2>
                <canvas id="salesChart" width="400" height="200"></canvas>
            </div>
        </section>
        <section class="w-full p-4">
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Revenue Distribution</h2>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'Sales',
                        data: [1200, 1900, 3000, 5000, 2000, 3000],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <script>
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'pie',
                data: {
                    labels: ['Product A', 'Product B', 'Product C', 'Product D'],
                    datasets: [{
                        label: 'Revenue',
                        data: [3000, 5000, 2000, 4000],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        </script>
    </div>
</div>


@include('_layouts.footer')
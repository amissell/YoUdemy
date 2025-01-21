<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy Statistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }
    </style>
</head>
<body class="h-full">
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar (Same as original) -->
        <aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 bg-white border-r border-gray-200">
            <!-- Logo -->
            <div class="flex items-center h-16 px-6 border-b border-gray-200 bg-white">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-lg">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Youdemy</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto">
                <!-- Main Navigation -->
                <div>
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Main</h3>
                    <div class="mt-4 space-y-1">
                        <a href="dashboard.php" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-chart-line w-5 h-5"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg bg-indigo-50 text-indigo-600">
                            <i class="fas fa-chart-bar w-5 h-5"></i>
                            <span class="ml-3">Statistics</span>
                        </a>
                        <!-- Other navigation items... -->
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-72 flex flex-col flex-1">
            <!-- Top Navigation (Same as original) -->
            <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
                <!-- Header content... -->
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                <!-- Statistics Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Platform Statistics</h1>
                    <p class="mt-2 text-sm text-gray-600">Detailed analytics and insights about your platform's performance</p>
                </div>

                <!-- Time Period Selector -->
                <div class="mb-6">
                    <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                        <option>Last year</option>
                    </select>
                </div>

                <!-- Growth Metrics -->
                <div class="stats-grid mb-8">
                    <!-- Revenue Growth -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-50 text-green-600 rounded-lg">
                                <i class="fas fa-dollar-sign text-xl"></i>
                            </div>
                            <span class="flex items-center text-green-600 text-sm font-medium">
                                <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                24%
                            </span>
                        </div>
                        <h3 class="text-gray-900 font-semibold">Revenue Growth</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-2">$124,750</p>
                        <p class="text-sm text-gray-500 mt-2">+$28,450 vs last period</p>
                    </div>

                    <!-- Student Engagement -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-50 text-blue-600 rounded-lg">
                                <i class="fas fa-user-graduate text-xl"></i>
                            </div>
                            <span class="flex items-center text-green-600 text-sm font-medium">
                                <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                18%
                            </span>
                        </div>
                        <h3 class="text-gray-900 font-semibold">Active Students</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-2">2,845</p>
                        <p class="text-sm text-gray-500 mt-2">86% completion rate</p>
                    </div>

                    <!-- Course Completion -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-50 text-purple-600 rounded-lg">
                                <i class="fas fa-graduation-cap text-xl"></i>
                            </div>
                            <span class="flex items-center text-green-600 text-sm font-medium">
                                <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                12%
                            </span>
                        </div>
                        <h3 class="text-gray-900 font-semibold">Course Completion</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-2">78%</p>
                        <p class="text-sm text-gray-500 mt-2">+5% vs last period</p>
                    </div>

                    <!-- Average Rating -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200 hover:shadow-lg transition-all">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-12 bg-yellow-50 text-yellow-600 rounded-lg">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <span class="flex items-center text-green-600 text-sm font-medium">
                                <i class="fas fa-arrow-up mr-1 text-xs"></i>
                                0.3
                            </span>
                        </div>
                        <h3 class="text-gray-900 font-semibold">Average Rating</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-2">4.8</p>
                        <p class="text-sm text-gray-500 mt-2">From 12,450 ratings</p>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Revenue Chart -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Revenue Overview</h2>
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>

                    <!-- Enrollment Chart -->
                    <div class="bg-white p-6 rounded-xl border border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Enrollment Trends</h2>
                        <canvas id="enrollmentChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Top Performing Content -->
                <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Top Performing Content</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrollments</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Completion Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <!-- Table rows with sample data -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded bg-gray-200"></div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Complete Web Development</div>
                                                <div class="text-sm text-gray-500">John Doe</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">1,234</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">$45,670</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <span class="text-yellow-400 mr-1"><i class="fas fa-star"></i></span>
                                            4.9
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 88%"></div>
                                        </div>
                                        <span class="text-sm text-gray-500">88%</span>
                                    </td>
                                </tr>
                                <!-- Add more rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- <script>
        // Chart.js initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Revenue',
                        data: [30000, 45000, 42000, 50000, 75000, 90000],
                        borderColor: '#4F46E5',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Enrollment Chart
            const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
            new Chart(enrollmentCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'New Enrollments',
                        data: [450, 520, 480, 600, 750, 820],
                        backgroundColor: '#818CF8'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });

        // Mobile menu toggle
        const menuButton = document.querySelector('button');
        const sidebar = document.querySelector('aside');
        
        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !menuButton.contains(e.target)) {
                sidebar.classList.add('hidden');
            }
        });
    </script> -->
</body>
</html>
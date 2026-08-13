<?php
$monthlyMotherRegistrations = [
    'labels' => ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    'values' => [8, 10, 9, 12, 11, 14, 13, 16, 15, 18, 20, 22],
];
$monthlyMotherRegistrations = $monthlyMotherRegistrations ?? ['labels' => [], 'values' => []];
?>
<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-6 py-4">
        <h2 class="text-lg font-semibold text-slate-900">Monthly Mother Registrations</h2>
        <p class="mt-1 text-sm text-slate-500">Registrations during the last 12 months</p>
    </div>
    <div class="p-6">
        <div class="h-72"><canvas id="motherRegistrationsChart"></canvas></div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('motherRegistrationsChart');
        if (!canvas || typeof Chart === 'undefined') return;

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: <?= json_encode($monthlyMotherRegistrations['labels'] ?? []) ?>,
                datasets: [{
                    label: 'Mother Registrations',
                    data: <?= json_encode($monthlyMotherRegistrations['values'] ?? []) ?>,
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
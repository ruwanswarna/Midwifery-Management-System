<?php
$pregnancyStatusDistribution = [
    'labels' => ['Normal', 'High Risk', 'Completed', 'Transferred'],
    'values' => [28, 7, 5, 2],
];
$pregnancyStatusDistribution = $pregnancyStatusDistribution ?? ['labels' => [], 'values' => []];
?>
<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-6 py-4">
        <h2 class="text-lg font-semibold text-slate-900">Pregnancy Status Distribution</h2>
        <p class="mt-1 text-sm text-slate-500">Current pregnancy status overview</p>
    </div>
    <div class="p-6">
        <div class="h-72"><canvas id="pregnancyStatusChart"></canvas></div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('pregnancyStatusChart');
        if (!canvas || typeof Chart === 'undefined') return;

        new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($pregnancyStatusDistribution['labels'] ?? []) ?>,
                datasets: [{
                    data: <?= json_encode($pregnancyStatusDistribution['values'] ?? []) ?>,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
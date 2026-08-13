document.querySelectorAll('.period-btn').forEach(button => {

    button.addEventListener('click', async () => {

        const period = button.dataset.period;

        const response = await fetch(
            `/dashboard/statistics?period=${period}`
        );

        const data = await response.json();

        document.querySelector('#family-value').textContent =
            data.families.value;

        document.querySelector('#family-trend').textContent =
            data.families.trend;

    });

});
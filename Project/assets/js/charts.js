// CHARTS : Initializes a bar chart using Chart.js to display request data. It reads labels and values from data attributes on the canvas element and configures the chart's appearance and behavior.
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("requestsChart");
    if (!canvas) return;

    const labels = JSON.parse(canvas.dataset.labels || "[]");
    const values = JSON.parse(canvas.dataset.values || "[]");

    new Chart(canvas, {
        type: "bar",
        data: {
            labels,
            datasets: [{
                label: "Requests by Status",
                data: values,
                backgroundColor: ["#1f4fff", "#ff9800", "#4caf50"]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
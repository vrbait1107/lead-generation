$(document).ready(function () {
    let chart = "chart";

    $.ajax({
        url: "/ajax/dashboard.php",
        type: "POST",
        data: {
            chart: chart,
        },
        success(data) {
            let value = JSON.parse(data);
            var labels = value.map(item => item.state);
            var dataValues = value.map(item => parseInt(item.count));
            var ctx = document.getElementById('piechart').getContext('2d');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Leads',
                        data: dataValues,
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#FF5733', '#33FF57'
                        ],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });

        },
        error(err) {
            alert("Something Went Wrong");
            console.error(err);
        },
    });
});

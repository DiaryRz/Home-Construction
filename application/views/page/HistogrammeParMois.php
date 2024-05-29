<h1>Montant des devis par mois</h1>
<div>
    <canvas id="myChart"></canvas>
</div>
<script src="<?php echo base_url("assets/Chart.js") ?>"></script>
<script>
    var labels = [];
    var data = [];

    <?php foreach ($chart_data as $row): ?>
        labels.push("<?php echo $row->month; ?>");
        data.push("<?php echo $row->montant; ?>");
        console.log("eto") ;
    <?php endforeach; ?>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Data',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

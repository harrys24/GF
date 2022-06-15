<div class="chart-container" style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart"></canvas>
</div>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data:{
        //12
        labels:['J','F','M','A'],
        datasets:[
            {
            label:'Courbe d\'absence',
            fill:true,
            backgroundColor:'rgba(255,144,56,0.25)',
            borderColor:'rgba(255,144,56,0.6)',
            pointBackgroundColor:'rgba(255,144,56,0.8)',
            data:[0,1056,23,256]
            }
    ]
    },
    options:{
        title: {
            display: true,
            text: 'Représentation graphique ABS et Retard'
        },
        elements:{
            point:{
                radius:4,
                hoverRadius:10
            }
        },
        legend:{
            position:'right'
        }
    }
});
</script>
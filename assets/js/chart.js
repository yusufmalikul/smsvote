// Define a plugin to provide data labels
Chart.plugins.register({
    afterDatasetsDraw: function(chartInstance, easing) {
        // To only draw at the end of animation, check for easing === 1
        var ctx = chartInstance.chart.ctx;

        chartInstance.data.datasets.forEach(function (label, i) {
            var meta = chartInstance.getDatasetMeta(i);
            if (!meta.hidden) {
                meta.data.forEach(function(element, index) {
                    // Draw the text in black, with the specified font
                    ctx.fillStyle = 'rgb(255, 255, 255)';

                    var fontSize = 16;
                    var fontStyle = 'normal';
                    var fontFamily = 'Helvetica Neue';
                    ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                    // Just naively convert to string for now
                    // var dataString = dataset.data[index].toString();
                    var dataString = labels[index];

                    // Make sure alignment settings are correct
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    var padding = 5;
                    var position = element.tooltipPosition();
                    ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                });
            }
        });
    }
});

function startChart() {
  // label inside chart
  labels = label;
  var data = {
    //labels : label,
    // labels: [
    //   "No 1",
    //   "No 2",
    //   "No 3"
    // ],
    datasets: [
      {
        data: jumlah_suara,
        backgroundColor: warnaBG,
        hoverBackgroundColor: warnaHover
      }
    ],
    labels : label
  };
  var ctx = "pie_chart";
  var pieChart = new Chart(ctx,{
    type: 'pie',
    data: data,
    options: {
      title: {
        display: true,
        text: 'Voting Ketua HMP Pendidikan Informatika',
        fontSize: 29
      },
      legend: {
        labels : {
          fontSize: 20
        }
      }
    }
  });
}

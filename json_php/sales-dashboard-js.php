<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

// Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["North", "South", "East", "West"],
    datasets: [{
      label: "Total Sales Yearly",
      backgroundColor: "#ed7d31",
      hoverBackgroundColor: "#e56c1a",
      borderColor: "#e56c1a",
      data: [<?php echo zone($sql, 3); ?>, <?php echo zone($sql, 4); ?>, <?php echo zone($sql, 1); ?>, <?php echo zone($sql, 5); ?>],
    }],
  },
  options: {
    maintainAspectRatio: false,
    responsive: true,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 6
        },
        maxBarThickness: 25,
      }],
      yAxes: [{
        ticks: {
          min: 0,
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function (value, index, values) {
            return "\u20B9 " + number_format(value);
            //return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function (tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': \u20B9 ' + number_format(tooltipItem.yLabel);
        }
      }
    },
  }
});



// Bar Chart Example
var ctx2 = document.getElementById("myBarChart2");
var myBarChart2 = new Chart(ctx2, {
  type: 'bar',
  data: {
    labels: ["North", "South", "East", "West"],
    datasets: [{
      label: "Revenue",
      backgroundColor: "#4e73df",
      hoverBackgroundColor: "#2e59d9",
      borderColor: "#4e73df",
      data: [<?php echo zone_qtr($sql, 3, '2022-10-01 00:00:00', '2023-12-31 23:59:00'); ?>, <?php echo zone_qtr($sql, 4, '2022-10-01 00:00:00', '2023-12-31 23:59:00'); ?>, <?php echo zone_qtr($sql, 1, '2022-10-01 00:00:00', '2023-12-31 23:59:00'); ?>, <?php echo zone_qtr($sql, 5, '2022-10-01 00:00:00', '2023-12-31 23:59:00'); ?>],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 6
        },
        maxBarThickness: 25,
      }],
      yAxes: [{
        ticks: {
          min: 0,
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function (value, index, values) {
            return "\u20B9 " + number_format(value);
            //return number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function (tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': \u20B9 ' + number_format(tooltipItem.yLabel);
        }
      }
    },
  }
});


const categorywise = {
  labels: [<?php echo product_group($sql); ?>],
  datasets: [{
    type: 'bar',
    label: 'Unit Sold',
    yAxisID: 'A',
    data: [<?php echo product_group_totalamt($sql); ?>],
    borderColor: 'rgb(255, 99, 132)',
    backgroundColor: 'rgba(255, 99, 132, 0.2)'
  }, {
    type: 'line',
    label: 'Sales',
    yAxisID: 'B',
    data: [<?php echo product_group_total($sql); ?>],
    fill: false,
    borderColor: 'rgb(54, 162, 235)'
  }],

};


// Bar Chart Example
var ctx3 = document.getElementById("myBarChart3");
var myBarChart3 = new Chart(ctx3, {
  type: 'bar',
  data: categorywise,
  options: {
    responsive:true,
    scales: {
      yAxes: [{
        id: 'A',
        type: 'linear',
        position: 'left',
      }, {
        id: 'B',
        type: 'linear',
        position: 'right'
      }]
    }
  }
});



const targetachieve = {
  labels: [<?php echo product_group($sql); ?>],
  datasets: [{
    type: 'line',
    label: 'Line Dataset',
    data: [12, 18, 23, 30,12, 18, 23, 30],
    fill: false,
    borderColor: '#92d050'
  }, {
    type: 'bar',
    label: 'Bar Dataset',
    data: [25, 20, 30, 40, 12, 18, 23, 30],
    borderColor: '#4472c4',
    backgroundColor: '#254f9a'
  }, {
    type: 'bar',
    label: 'Bar Dataset',
    data: [15, 22, 28, 33, 12, 18, 23, 30],
    borderColor: '#ed7d31',
    backgroundColor: '#c85f18'
  }]
 
};


// Bar Chart Example
var ctx3 = document.getElementById("myBarChart4");
var myBarChart3 = new Chart(ctx3, {
  type: 'bar',
  data: targetachieve,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const datamom = [<?php echo getmonthwise($sql, '04', '2022'); ?>, <?php echo getmonthwise($sql, '05', '2022'); ?>, <?php echo getmonthwise($sql, '06', '2022'); ?>, <?php echo getmonthwise($sql, '07', '2022'); ?>, <?php echo getmonthwise($sql, '08', '2022'); ?>, <?php echo getmonthwise($sql, '09', '2022'); ?>, <?php echo getmonthwise($sql, '10', '2022'); ?>, <?php echo getmonthwise($sql, '11', '2022'); ?>, <?php echo getmonthwise($sql, '12', '2022'); ?>, <?php echo getmonthwise($sql, '01', '2023'); ?>, <?php echo getmonthwise($sql, '02', '2023'); ?>, <?php echo getmonthwise($sql, '03', '2023'); ?>];
const mcolours = datamom.map((value) => value < 0 ? '#86B4E9' : '#334F98');

const momsales = {
  labels: ["April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec", "Jan", "Feb", "March"],
  datasets: [{
    type: 'bar',
    label: 'Increase',
    data: datamom,
    borderColor: '#4472c4',
    backgroundColor: mcolours
  }
  ]
};


// Bar Chart Example
var ctx3 = document.getElementById("myBarChart5");
var myBarChart3 = new Chart(ctx3, {
  type: 'bar',
  data: momsales,
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

const graph = document.getElementById("highpermorfingpie").getContext("2d");

let massPopChart = new Chart(graph, {
  type: "pie", // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data: {
    labels: [<?php echo getstatebusiness_pie($sql, 'DESC'); ?>],

    datasets: [
      {
        label: "Population en M ",
        data: [<?php echo getstatebusiness_pieamount($sql, 'DESC'); ?>],
        // backgroundColor: "blue",
        backgroundColor: [ "#7eb0d5", "#b2e061", "#bd7ebe", "#ffb55a", "#ffee65",],
       
        hoverBorderWidth: 3
      }]
  },
  options: {
    title: {
      display: false,
      text: "High Performing Regions",
      fontSize: 12
    },
    legend: {
      display: false
    },
    // start at 0
    scales: {
      yAxes: [
        {
          gridLines: {
            display: false
          },
          ticks: {
            beginAtZero: false,
            display: false
          }
        }]
    },

  }
});
//# High Graph Chart 

const graph2 = document.getElementById("highpermorfingproduct").getContext("2d");

Chart.defaults.global.defaultFontSize = 12;

let massPopChart2 = new Chart(graph2, {
  type: "pie", // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data: {
    labels: [<?php echo getprodbusiness_pie($sql, 'DESC'); ?>],

    datasets: [
      {
        label: "Population en M ",
        data: [<?php echo getprodbusiness_pieamount($sql, 'DESC'); ?>],
        // backgroundColor: "blue",
        backgroundColor: [ "#76c8c8", "#c80064", "#badbdb", "#dedad2", "#e4bcad", ],
        hoverBorderWidth: 3
      }]
  },
  options: {
    title: {
      display: false,
      text: "High Performing Product",
      fontSize: 12
    },
    legend: {
      display: false
    },
    // start at 0
    scales: {
      yAxes: [
        {
          gridLines: {
            display: false
          },
          ticks: {
            beginAtZero: false,
            display: false
          }
        }]
    },

  }
});

//#high perform product close


const graph3 = document.getElementById("highpermorfingcategory").getContext("2d");

Chart.defaults.global.defaultFontSize = 12;

let massPopChart3 = new Chart(graph3, {
  type: "pie", // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data: {
    labels: [<?php echo getcatbusiness_pie($sql, 'DESC'); ?>],

    datasets: [
      {
        label: "Population en M ",
        data: [<?php echo getcatbusiness_pieamount($sql, 'DESC'); ?>],
        // backgroundColor: "blue",
        backgroundColor: [ "#54bebe",  "#d7658b", "#df979e", "#badbdb", "#dedad2",  ],
        hoverBorderWidth: 3
      }]
  },
  options: {
    title: {
      display: false,
      text: "High Performing Category",
      fontSize: 12
    },
    legend: {
      display: false
    },
    // start at 0
    scales: {
      yAxes: [
        {
          gridLines: {
            display: false
          },
          ticks: {
            beginAtZero: false,
            display: false
          }
        }]
    },

  }
});

//high perform category piechart close



const graph4 = document.getElementById("lowpermorfingcategory").getContext("2d");

Chart.defaults.global.defaultFontSize = 12;

let massPopChart4 = new Chart(graph4, {
  type: "pie", // bar, horizontalBar, pie, line, doughnut, radar, polarArea
  data: {
    labels: [<?php echo getcatbusiness_pie($sql, 'ASC'); ?>],

    datasets: [
      {
        label: "Population en M ",
        data: [<?php echo getcatbusiness_pieamount($sql, 'ASC'); ?>],
        // backgroundColor: "blue",
        backgroundColor: [ "#ffee65", "#beb9db", "#fd7f6f", "#7eb0d5", "#b2e061",],

        hoverBorderWidth: 3
      }]
  },
  options: {
    title: {
      display: false,
      text: "Low Performing Category",
      fontSize: 12
    },
    legend: {
      display: false
    },
    // start at 0
    scales: {
      yAxes: [
        {
          gridLines: {
            display: false
          },
          ticks: {
            beginAtZero: false,
            display: false
          }
        }]
    },

  }
});

</script>
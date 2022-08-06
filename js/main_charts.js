
function money_chart(labels,data2,label,id,color){

var ctx = document.getElementById(id);
var labels=labels.split(',');
var data2=data2.split(',');
var data = {
  labels:labels,
  datasets: [{
    label:label,
    backgroundColor: "rgba("+color+",0.2)",
    borderColor: "rgba("+color+",1)",
    borderWidth: 2,
    hoverBackgroundColor: "rgba("+color+",0.4)",
    hoverBorderColor: "rgba("+color+",1)",
    data:data2,
  }]
};

var option = {
  scales: {
      
    yAxes: [{
      stacked: true,
      gridLines: {
        display: true,
        color: "rgba("+color+",0.2)"
      }
    }],
    xAxes: [{
      gridLines: {
        display: true
      }
    }]
  }
};

var myChart = new Chart(ctx, {
    type: 'bar',
  options: option,
  data: data
});
}
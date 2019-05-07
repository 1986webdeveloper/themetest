var randomScalingFactor = function() {
	return Math.round(Math.random() * 100);
};

var datapoints = [0, 20, 20, 60, 60, 120, NaN, 180, 120, 125, 105, 110, 170];
var chartpage_01 = {
	type: 'line',
	data: {
		labels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
		datasets: [{
			label: 'Cubic interpolation (monotone)',
			data: datapoints,
			borderColor: window.chartColors.red,
			backgroundColor: 'rgba(0, 0, 0, 0)',
			fill: false,
			cubicInterpolationMode: 'monotone'
		}, {
			label: 'Cubic interpolation (default)',
			data: datapoints,
			borderColor: window.chartColors.blue,
			backgroundColor: 'rgba(0, 0, 0, 0)',
			fill: false,
		}, {
			label: 'Linear interpolation',
			data: datapoints,
			borderColor: window.chartColors.green,
			backgroundColor: 'rgba(0, 0, 0, 0)',
			fill: false,
			lineTension: 0
		}]
	},
	options: {
		responsive: true,
		title: {
			display: true,
			text: 'Chart.js Line Chart - Cubic interpolation mode'
		},
		tooltips: {
			mode: 'index'
		},
		scales: {
			xAxes: [{
				display: true,
				scaleLabel: {
					display: true
				}
			}],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Value'
				},
				ticks: {
					suggestedMin: -10,
					suggestedMax: 200,
				}
			}]
		}
	}
};

var chartpage_02 = {
	type: 'line',
	data: {
		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
		datasets: [{
			label: 'Unfilled',
			fill: false,
			backgroundColor: window.chartColors.blue,
			borderColor: window.chartColors.blue,
			data: [
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor()
			],
		}, {
			label: 'Dashed',
			fill: false,
			backgroundColor: window.chartColors.green,
			borderColor: window.chartColors.green,
			borderDash: [5, 5],
			data: [
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor()
			],
		}, {
			label: 'Filled',
			backgroundColor: window.chartColors.red,
			borderColor: window.chartColors.red,
			data: [
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor()
			],
			fill: true,
		}]
	},
	options: {
		responsive: true,
		title: {
			display: true,
			text: 'Chart.js Line Chart'
		},
		tooltips: {
			mode: 'index',
			intersect: false,
		},
		hover: {
			mode: 'nearest',
			intersect: true
		},
		scales: {
			xAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Month'
				}
			}],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Value'
				}
			}]
		}
	}
};

var chartpage_03 = {
	type: 'line',
	data: {
		labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
		datasets: [{
			label: 'My First dataset',
			borderColor: window.chartColors.red,
			fill: false,
			// Skip a point in the middle
			data: [
				randomScalingFactor(),
				randomScalingFactor(),
				NaN,
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor()
			],

		}, {
			label: 'My Second dataset',
			borderColor: window.chartColors.blue,
			fill: false,
			// Skip first and last points
			data: [
				NaN,
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				randomScalingFactor(),
				NaN
			],
		}]
	},
	options: {
		responsive: true,
		title: {
			display: true,
			text: 'Chart.js Line Chart - Skip Points'
		},
		tooltips: {
			mode: 'index',
		},
		hover: {
			mode: 'index'
		},
		scales: {
			xAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Month'
				}
			}],
			yAxes: [{
				display: true,
				scaleLabel: {
					display: true,
					labelString: 'Value'
				},
			}]
		}
	}
};

window.onload = function() {
	var ctx_chartpage_01 = document.getElementById('chartpage_01_chart').getContext('2d');
	window.myLine = new Chart(ctx_chartpage_01, chartpage_01);

	var ctx_chartpage_03 = document.getElementById('chartpage_03_chart').getContext('2d');
	window.myLine = new Chart(ctx_chartpage_03, chartpage_03);

	var ctx_chartpage_02 = document.getElementById('chartpage_02_chart').getContext('2d');
	window.myLine = new Chart(ctx_chartpage_02, chartpage_02);
};
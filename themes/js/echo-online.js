/**
 * Data Story PaidContent theme for HighCharts
 * @author NKB
 */

Highcharts.theme = {
	colors: ['#51707e', '#100000', '#1d4456', '#e5e9ea', '#2f4f5e', '#5a7987', '#d6d6d6', '#000000', '#748d99', '#50707d'],
	chart: {
		backgroundColor: '#fff',
		plotBackgroundColor: 'rgba(255, 255, 255, .9)',
		plotShadow: false,
		plotBorderWidth: 0
	},
	title: {
		style: { 
			color: '#FF0000',
			font: 'bold 14px Georgia, serif'
		}
	},
	credits: {
		enabled: false
	},
	subtitle: {
		style: { 
			color: '#666',
			font: '12px verdana, Tahoma, Geneva, Arial, Sans-serif'
		}
	},
	xAxis: {
		gridLineWidth: 0,
		minorTickInterval: null,
		lineColor: '#FF0000',
		tickColor: '#FF0000',
		labels: {
			style: {
				color: '#000',
				font: '10px verdana, Tahoma, Geneva, Arial, Sans-serif'
			}
		},
		title: {
			style: {
				color: '#222',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'verdana, Tahoma, Geneva, Arial, Sans-serif'

			}				
		}
	},
	yAxis: {
		minorTickInterval: null,
		lineColor: '#FF0000',
		lineWidth: 1,
		tickWidth: 1,
		gridLineWidth: 0,
		tickColor: '#FF0000',
		labels: {
			style: {
				color: '#000',
				font: '11px verdana, Tahoma, Geneva, Arial, Sans-serif'
			}
		},
		title: {
			style: {
				color: '#333',
				fontWeight: 'bold',
				fontSize: '12px',
				fontFamily: 'verdana, Tahoma, Geneva, Arial, Sans-serif'
			}				
		}
	},
	legend: {
		itemStyle: {			
			font: '9px verdana, Tahoma, Geneva, Arial, Sans-serif',
			color: 'black'

		},
		itemHoverStyle: {
			color: '#039'
		},
		itemHiddenStyle: {
			color: 'gray'
		},
		borderWidth: 0,
		borderRadius: 0
	},
	labels: {
		style: {
			color: '#99b'
		}
	},
	tooltip:{
		style: {
			color: '#333',
			fontWeight: 'normal',
			fontSize: '12px',
			fontFamily: 'verdana, Tahoma, Geneva, Arial, Sans-serif'
		}	
	},
	plotOptions: {	
		column : {
			pointPadding: 0.2,
			borderWidth: 0,
			borderColor: '#aaa',
			marker: {
				enabled: true
			}
		},
		line : {
			pointPadding: 0.2,
			borderWidth: 0,
			marker: {
				enabled: true
			}
		},
		pie : {
			allowPointSelect: true,
			cursor: "pointer",
			dataLabels: {
				enabled: true
			},
			markers: {
				enabled: true
			}
		}
	}
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
	

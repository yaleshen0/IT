
var data = {
        labels: ["不能上网", "QuickBook", "电话", "Remote/PC", 
        "EXCEL", "无法登陆网站","Email", "显示器问题", "打印机问题", "其他"],
        datasets: [
        {
            label: ['Opened'],
            data: [openWifi, openQB, openPhone, openRemp, openExcel, openWebsite, openEmail, openMonitor, openPrinter, openOthers],
            backgroundColor: [
			'#FF6384',
			'#FF6384',
			'#FF6384',
			'#FF6384',
			'#FF6384',
			'#FF6384',
			'#FF6384',
			'#FF6384',
			'#FF6384',
			'#FF6384'
			],
            borderWidth: 1
        },
        {
            label: ['Unopened'],
            data: [unopenWifi, unopenQB, unopenPhone, unopenRemp, unopenExcel, unopenWebsite, unopenEmail, unopenMonitor, unopenPrinter, unopenOthers],
            backgroundColor: [
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0',
            '#4BC0C0'
			],
            borderWidth: 1
        },
        {
            label: ['Closed'],
            data: [closeWifi, closeQB, closePhone, closeRemp, closeExcel, closeWebsite, closeEmail, closeMonitor, closePrinter, closeOthers],
            backgroundColor: [
            '#FFCE56',
            '#FFCE56',
            '#FFCE56',
            '#FFCE56',
            '#FFCE56',
            '#FFCE56',
            '#FFCE56',
            '#FFCE56',
            '#FFCE56'
			],
            borderWidth: 1
        },
        {
            label: ['All'],
            data: [allWifi, allQB, allPhone, allRemp, allExcel, allWebsite, allEmail, allMonitor, allPrinter, allOthers],
            backgroundColor: [
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED',
            '#E7E9ED'
			],
            borderWidth: 1
        }
        ]
    },

ctx = $('#myChart');
var myChart = new Chart(ctx, {
	type: 'bar',
	data: data,
	options: {
        title: {
               fontSize: 30 
            }
        }	
});



function createBarChartDeviceTypes(devices, assignedDevices, inStoreDevices) {

    const data = {
        labels: Object.keys(devices),
        datasets: [{
            type: 'bar',
            label: 'Amount of Devices per type ',
            data: Object.values(devices),
            backgroundColor: 'rgba(131,194,206,0.8)',
            },
            {
            type: 'bar',
            label: 'Assigned',
            data:  Object.values(assignedDevices),
            fill: false,
            backgroundColor: 'rgba(255,139,0,0.8)',
            },
            {
            type: 'bar',
            label: 'in Store',
            data:  Object.values(inStoreDevices),
            fill: false,
            backgroundColor: 'rgba(75,215,79,0.8)',

            }
        ]
    };


    const config = {
        type: 'scatter',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: Math.max(...Object.values(devices)) + 5,

                }
            }
        }
    };

    new Chart(
        document.getElementById('deviceAmountAndStateBarChart'),
        config
    );
}

function createDonutChartStatus(deviceStates) {

    const colors = {
        'assigned': 'rgba(255,139,0,0.8)',
        'in Store': 'rgba(75,215,79,0.8)',
        'ordered': 'rgba(11,155,32,0.8)',
        'damaged': 'rgb(255,63,63)',
        'repair': 'rgb(255,208,100)',
        'deleted': 'rgb(136,136,136,0.8)',
        'stolen': 'rgb(97,140,206)',
        'lost': 'rgb(201, 203, 207)'
    };

    const datadoughnut = {
        labels: Object.keys(deviceStates),
        datasets: [{
            label: 'Status of Devices',
            data: Object.values(deviceStates),
            backgroundColor: Object.keys(deviceStates).map(status => {
                if (deviceStates[status] > 0) {
                    return colors[status];
                } else {
                    return 'rgba(0, 0, 0, 0)'; // transparent color
                }
            }),
        hoverOffset: 4
}]
};

    const configdoughnut = {
        type: 'doughnut',
        data: datadoughnut,
        options: {
            maintainAspectRatio: false,
            responsive: true,
        }
    };

    new Chart(
        document.getElementById('allDeviceStatesDonutChart'),
        configdoughnut
    );
}

function createHandoverLineChart(handoversHistory){

    const labels = Object.keys(handoversHistory);
    const data = {
        labels: labels,
        datasets: [{
            label: 'Handovers past year',
            data: Object.values(handoversHistory),
            fill: false,
            borderColor: 'rgb(231,85,85)',
            tension: 0.1
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    };

    new Chart(
        document.getElementById('handoverHistoryPastYearLineChart'),
        config
    );
}



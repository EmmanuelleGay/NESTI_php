const dataOrderByDay = {

    categories: [
        '0',
        '1',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9'

    ],
    series: [
        {
            name: 'Coûts',
            data: vars.purchasedTotalByDay
        },
        {
            name: 'Ventes',
            data: vars.soldTotalByDay
        }

    ]
}

const optionsOrderByDay = {
    chart: {
        title: 'Commandes',
        width: 800,
        height: 400
    },
    xAxis: {
        pointOnColumn: false,
        title: {
            text: 'Jour'
        }
    },
    yAxis: {
        title: 'Montant commandes'
    }
};


const dataConnexionLogByHour = {
    categories: ['Connection'],
    series: vars.connexionByHour

}

const optionsConnexionLog = {
    chart: {
        title: 'Consultation du site',
        width: 400,
        height: 400
    },
    legend: {
        visible: false
    },
    series: {
        dataLabels: {
            visible: true,
            anchor: 'outer',
            
        },
        radiusRange: {
            inner: '60%',
            outer: '100%',
          }
    }

};


const dataArticleBarChart = {
    categories: [
        0,
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9
    ],
    series: [

        {
            name: 'Coûts',
            data: vars.articlePurchases
        },
        {
            name: 'Ventes',
            data: vars.articleSales
        }
    ]
}

const optionsArticleBarChart = {
    chart: {
        title: 'Article',
        width: 900,
        height: 400
    }
};


$(() => { // orders graph
    const chartOrderNode = document.getElementById('chartOrder');
    const chartOrder = toastui.Chart.lineChart({el: chartOrderNode, data: dataOrderByDay, options: optionsOrderByDay});

    // log connexion
    const chartConnexionLogNode = document.getElementById('chartConnexionLog');
    const chartConnexionLog = toastui.Chart.pieChart({el: chartConnexionLogNode, data: dataConnexionLogByHour, options: optionsConnexionLog});

    // article bar chart
    const chartArticleNode = document.getElementById('chartArticle');
    const chartArticle = toastui.Chart.columnChart({el: chartArticleNode, data: dataArticleBarChart, options: optionsArticleBarChart});

});

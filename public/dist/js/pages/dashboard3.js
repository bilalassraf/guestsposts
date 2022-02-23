// /* global Chart:false */

// $(function () {
//   'use strict'

//   var ticksStyle = {
//     fontColor: '#495057',
//     fontStyle: 'bold'
//   }

//   var mode = 'index'
//   var intersect = true

// //  

//   var $visitorsChart = $('#visitors-chart')
//   // eslint-disable-next-line no-unused-vars
//   var visitorsChart = new Chart($visitorsChart, {
//     data: {
//       labels: ['Approved', 'Pending', 'Rejected', 'Deleted'],
//       datasets: [{
//         type: 'line',
//         data: [112, 70, 90, 67],
//         backgroundColor: 'transparent',
//         borderColor: '#00695B',
//         pointBorderColor: '#00695B',
//         pointBackgroundColor: '#fff',
//         fill: false
//         // pointHoverBackgroundColor: '#007bff',
//         // pointHoverBorderColor    : '#007bff'
//       },
//       ]
//     },
//     options: {
//       maintainAspectRatio: false,
//       tooltips: {
//         mode: mode,
//         intersect: intersect
//       },
//       hover: {
//         mode: mode,
//         intersect: intersect
//       },
//       legend: {
//         display: false
//       },
//       scales: {
//         yAxes: [{
//           // display: false,
//           gridLines: {
//             display: true,
//             lineWidth: '4px',
//             color: 'rgba(0, 0, 0, .2)',
//             zeroLineColor: 'transparent'
//           },
//           ticks: $.extend({
//             beginAtZero: true,
//             suggestedMax: 100
//           }, ticksStyle)
//         }],
//         xAxes: [{
//           display: true,
//           gridLines: {
//             display: true
//           },
//           ticks: ticksStyle
//         }]
//       }
//     }
//   })
// })

// // lgtm [js/unused-local-variable]

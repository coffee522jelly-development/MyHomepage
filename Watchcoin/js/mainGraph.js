  // メイングラフ
  function MainGraph(){
    var ctx3 = document.getElementById("myDayChart").getContext('2d');
    window.myChart3 = new Chart(ctx3, {
      type: 'line',
      data: {
        labels: $timearr,
        datasets: [{
          label: '終値',
          data: $dataCarr,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 1.5,
        }, {
          label: '始値',
          data: $dataOarr,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 0.5,
          hidden: true,
        }, {
        label: '高値',
          data: $dataHarr,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 0.5,
          hidden: true,
        }, {
        label: '安値',
          data: $dataLarr,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 0.5,
          hidden: true,
        }, {
        label: '10SMA',
          data: $dataAve10,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 1.5,
        }, {
        label: '20SMA',
          data: $dataAve20,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 1.5,
        }, {
        label: '50SMA',
          data: $dataAve50,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 1.5,
        }, {
        label: '100SMA',
          data: $dataAve100,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 1.55,
        }],
      },
      options: {
        legend: {
              labels: {
                  // このフォントプロパティ指定は、グローバルプロパティを上書きします
                  fontColor: '#cccccc'
              }
            },
        title: {
              display: true,
              text: 'BTC/JPY　'+ timeConv(periods) +'チャート',
          },
        animation: false,
        hover: {
              animationDuration: 0, // アイテムのマウスオーバー時のアニメーションの長さ
          },
        responsiveAnimationDuration: 0, // サイズ変更後のアニメーションの長さ
        //maintainAspectRatio: false,
        plugins: {
          colorschemes: {
            scheme: 'brewer.Blues8'
          }
        },
        elements: {
          line: {
              tension: 0, // ベジェ曲線を無効
          }
        },
      scales: {
          xAxes: [{
            gridLines: {
                color: "#444444",
            },
            ticks: {
              maxRotation: 20,
              minRotation: 0,
            }
          }],
          yAxes: [{
            gridLines: {
                color: "#444444",
            }
          }]
        },
    },
    });
    }

    // 出来高グラフ
  function VolumeGraph(){
    var ctxVolume = document.getElementById("myVolumeChart").getContext('2d');
    window.myVolumeChart = new Chart(ctxVolume, {
      type: 'bar',
      data: {
        labels: $timearr,
        datasets: [{
          label: '出来高',
          data: $dataVolume,
          pointRadius: 0,
          pointHitRadius: 2,
          fill:false,
          borderWidth: 1.5,
        }],
      },
      options: {
        legend: {
              display: false,
              labels: {
                  // このフォントプロパティ指定は、グローバルプロパティを上書きします
                  fontColor: '#cccccc'
              }
            },
        animation: false,
        hover: {
              animationDuration: 0, // アイテムのマウスオーバー時のアニメーションの長さ
          },
        responsiveAnimationDuration: 0, // サイズ変更後のアニメーションの長さ
        //maintainAspectRatio: false,
        plugins: {
          colorschemes: {
            scheme: 'brewer.Blues8'
          }
        },
        elements: {
          line: {
              tension: 0, // ベジェ曲線を無効
          }
        },
      scales: {
          xAxes: [{
            display:false,
            // gridLines: {
            //     color: "#444444",
            // },
            // ticks: {
            //   maxRotation: 20,
            //   minRotation: 0,
            // }
          }],
          yAxes: [{
            ticks:{
              padding :26,
            },
            gridLines: {
                color: "#444444",
            }
          }]
        },
    },
    });
    }


　// 時間変換関数
  function timeConv(time){
      if(time >= 86400)
        time = parseInt(time / 86400) + '日足';
      else if(time < 3600){
        time = parseInt(time / 60) + '分足';
      }
      else{
        time = parseInt(time / 3600) + '時間足';
      }
      return time;
  }
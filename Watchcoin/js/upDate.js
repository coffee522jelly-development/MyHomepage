var options = {
  type: 'line',
  data: {
    labels: $timearr,
    datasets: [{
      label: '終値',
      data: $dataCarr,
      pointRadius: 0,
      pointHitRadius: 2,
      fill:false,
      borderWidth: 0.5,
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
    label: '移動平均(10MA)',
      data: $dataAve10,
      pointRadius: 0,
      pointHitRadius: 2,
      fill:false,
      borderWidth: 0.75,
    }, {
    label: '移動平均(20MA)',
      data: $dataAve20,
      pointRadius: 0,
      pointHitRadius: 2,
      fill:false,
      borderWidth: 0.75,
    }, {
    label: '移動平均(50MA)',
      data: $dataAve50,
      pointRadius: 0,
      pointHitRadius: 2,
      fill:false,
      borderWidth: 0.75,
    }, {
    label: '移動平均(100MA)',
      data: $dataAve100,
      pointRadius: 0,
      pointHitRadius: 2,
      fill:false,
      borderWidth: 0.75,
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
          text: 'BTC/JPY　チャート'
      },
    animation: false,
    hover: {
          animationDuration: 0, // アイテムのマウスオーバー時のアニメーションの長さ
      },
    responsiveAnimationDuration: 0, // サイズ変更後のアニメーションの長さ
    maintainAspectRatio: false,
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
};

$(document).ready(function() {
    /**
     * 送信ボタンクリック
     */
    $('#180btn').on('click', function() {
      // POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
      var data = {'periods' : 180};

      $.ajax({
        url: 'Request.php', //アクセスするURL
        type: 'POST',　　 //post or get
        data: data,           //アクセスするときに必要なデータを記載      
      })
      .done(function(response) { 
         //通信成功時の処理
         //成功したとき実行したいスクリプトを記載
        if (myChart3) {
          myChart3.destroy();
         }
         clearGraph();
         var ctx3 = document.getElementById("myDayChart").getContext('2d');
         myChart3 = new Chart(ctx3, options);
         console.log("success");
      })
      .fail(function(xhr) {  
　　　　　 //通信失敗時の処理
         //失敗したときに実行したいスクリプトを記載
         console.log("failed");
      })
      .always(function(xhr, msg) { 
　　　　　//通信完了時の処理
        //結果に関わらず実行したいスクリプトを記載
        console.log("complete");
      });   
    });
  });
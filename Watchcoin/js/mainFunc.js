  // 変数定義
  let $timearr = [];
  let $dataOarr =[];
  let $dataHarr =[];
  let $dataLarr =[];
  let $dataCarr =[];
  let $dataVolume =[];

  let $sizearr = [10, 20, 50, 100];
  let $dataAve10 =[];
  let $dataAve20 =[];
  let $dataAve50 =[];
  let $dataAve100 =[];

//　時間0詰め
var toDoubleDigits = function(num) {
    num += "";
    if (num.length === 1) {
        num = "0" + num;
    }
    return num;     
}


// OHLCデータ取得
function GetOHLCData() {
    var $data;
    for(var i =arySize - aryWidth; i < arySize ;i++){
        for(var j=0; j<6; j++){
            $data = aryTrade['result'][periods][i][j];
            // 時間ラベル
            if(j == 0){ 
            $date = new Date(aryTrade['result'][periods][i][0] * 1000);
            if(parseInt(Xperiods) <= 1800)
                $timearr.push(toDoubleDigits($date.getHours()) + ":" + toDoubleDigits($date.getMinutes()));
            else if(parseInt(Xperiods) >= 86400)
                $timearr.push($date.getFullYear() + "/" + toDoubleDigits(($date.getMonth() + 1)) + "/" + toDoubleDigits($date.getDate()));
            else
                $timearr.push(toDoubleDigits(($date.getMonth() + 1)) + "/" + toDoubleDigits($date.getDate()));
            }
            // 始値
            if(j == 1){ $dataOarr.push($data); }
            // 高値
            if(j == 2){ $dataHarr.push($data); }
            // 安値
            if(j == 3){ $dataLarr.push($data); }
            // 終値
            if(j == 4){ $dataCarr.push($data); }
            // 出来高
            if(j == 5){ $dataVolume.push($data); }
        }
    }
}

// 移動平均計算
function GetMA() {
    var $data = parseInt(aryTrade['result'][periods][arySize - aryWidth][4]);
    for(var x=0; x<4; x++){
        for(var i = arySize - aryWidth; i < arySize - $sizearr[x] ; i++){
            for(var j = 1; j < $sizearr[x]; j++){
                $data = $data + parseInt(aryTrade['result'][periods][i + j][4]);
            }

            $data = $data / $sizearr[x];
            // 10MA
            if(x == 0){$dataAve10.push(parseInt($data));}
            // 20MA
            if(x == 1){$dataAve20.push(parseInt($data));}
            // 50MA
            if(x == 2){$dataAve50.push(parseInt($data));}
            // 100MA
            if(x == 3){$dataAve100.push(parseInt($data));}
        }
    }
}

function upDateMainGraph(){
    GetOHLCData();
    GetMA();
    MainGraph();
    VolumeGraph();
}

function clearGraph(){
    $timearr.length = 0;
    $dataOarr.length = 0;
    $dataHarr.length = 0;
    $dataLarr.length = 0;
    $dataCarr.length = 0;
    $dataVolume.length = 0;
    $dataAve10.length = 0;
    $dataAve20.length = 0;
    $dataAve50.length = 0;
    $dataAve100.length = 0;
}

// 横幅サイズ調整
function WidthSize(){
    obj = document.ReDraw.Width;
    index = obj.selectedIndex;
    aryWidth = obj.options[index].value;

    clearGraph();
    
    upDateMainGraph();
}

function removeData(chart) {
    chart.data.labels.pop();
    chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
    });
    chart.update();
}
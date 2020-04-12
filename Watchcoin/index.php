<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<link rel="icon" type="image/x-icon" href="img/bitcoin.svg">

<title>WatchCoin</title>
<script src="js/chartjs-chart-financial.js" type="text/javascript"></script>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<body>
  <!-- Image and text -->
<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="img/bitcoin.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    WatchCoin
  </a>
</nav>
<div class="container">
<h3>日足チャート</h3>
<div class="row">
  <canvas id="myDayChart" class="col-md-12" width="400px" height="200px"></canvas>
</div>

<h3>現在の価格グラフ</h3>
<div class="row">
<canvas id="myBarChart" class="col-md-6" width="400px" height="200px"></canvas>
<canvas id="myBarChart2" class="col-md-6" width="400px" height="200px"></canvas>
</div>

  <div id="nowPrice">
  <p id="Value"></p>
  <p id="Trend"></p>
  </div>
  <div class="row">

<?php
// coincheck で取得
$json_str = @file_get_contents("https://coincheck.com/api/ticker");
$json = json_decode($json_str);
$Coincheck = $json->last;

// Zaif で取得
$json_str = @file_get_contents("https://api.zaif.jp/api/1/ticker/btc_jpy");
$json = json_decode($json_str);
$Zaif = $json->last;

// bitflyer で取得
$json_str = @file_get_contents("https://api.bitflyer.jp/v1/ticker?product_code=BTC_JPY");
$json = json_decode($json_str);
$Bitflyer = $json->ltp;

// 指定日時のタイムスタンプ取得
$timestamp = time();
$json_str = @file_get_contents("https://api.cryptowat.ch/markets/bitflyer/btcjpy/ohlc?periods=14400&after=".$timestamp);
$arr2 = json_decode($json_str, true);

// bitflyerでの板取引
$json_str = file_get_contents("https://bitflyer.jp/api/echo/price");
$arr = json_decode($json_str, true);

$json_trade = file_get_contents("https://api.cryptowat.ch/markets/bitflyer/btcjpy/ohlc");
?>
<script>
  let $bitFlyer = "<?php echo $Bitflyer; ?>";
  let $zaif = "<?php echo $Zaif; ?>";
  let $conicheck = "<?php echo $Coincheck; ?>";

  let ave = Math.round((parseInt($bitFlyer) + parseInt($zaif) + parseInt($conicheck)) / 3);
  document.getElementById('Value').innerHTML = "BitCoinの現在価格：約"　+ ave + "円";

  var ctx = document.getElementById("myBarChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Conicheck", "Zaif", "bitFlyer", "Average"],
      datasets: [{
        label: 'Bitcoin',
		    backgroundColor: 'rgba(0, 200, 150, 0.3)',
        data: [$conicheck, $zaif, $bitFlyer, ave]
      }]
    }
  });

  let $bid = "<?php echo $arr['bid']?>";
  let $mid = "<?php echo $arr['mid']?>";
  let $ask = "<?php echo $arr['ask']?>";

  var ctx2 = document.getElementById("myBarChart2").getContext('2d');
  var myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
      labels: ["買取価格", "中値", "販売価格"],
      datasets: [{
        label: '価格差グラフ/bitFlyer',
		    backgroundColor: 'rgba(0, 200, 150, 0.3)',
        data: [$bid, $mid, $ask],
      }]
    }
  });

  let aryTrade = <?php echo $json_trade; ?>;
  
  let $timearr =[];
  function GetTime($timearr) {
    var $date;
    for(var i =750;i<1000;i++){
      $date = new Date(aryTrade['result']['14400'][i][0] * 1000).toLocaleDateString('ja-JP').slice(5);
      $timearr.push($date);
    }
}
  GetTime($timearr);

  // 終値
  let $dataCarr =[];
  function GetCData($dataCarr) {
    var $data;
    for(var i =750;i<1000;i++){
      $data = aryTrade['result']['14400'][i][4];
      $dataCarr.push($data);
    }
  }
  GetCData($dataCarr);

  var ctx3 = document.getElementById("myDayChart").getContext('2d');
  var myChart3 = new Chart(ctx3, {
    type: 'line',
    data: {
      labels: $timearr,
      datasets: [{
        label: '終値',
		    backgroundColor: 'rgba(0, 200, 150, 0.3)',
        data: $dataCarr,
        pointRadius: 0,
      }]
    }
  });

  let trend;
  let strTrend;
  if(parseInt($bitFlyer) < parseInt($mid)){
    trend = Boolean("true");
    strTrend = "上げ(高く売りたい)";
  }
  else{
    trend = Boolean("false");
    strTrend = "下げ(安く買いたい)";
  }

  console.log(trend);
  document.getElementById('Trend').innerHTML = "トレンド(中値-現在価格):" + strTrend;

  var ssu = new SpeechSynthesisUtterance();
  ssu.text = 'ビットコインの現在価格は' + ave +'円です';
  ssu.lang = 'ja-JP';
  speechSynthesis.speak(ssu);

</script>
<?php
echo  '<div id="News" class="col-md-6"><h3>ビットコインニュース</h3>';
$num = 11;
$rss = simplexml_load_file('http://news.google.com/news?hl=ja&gl=JP&ceid=JP:ja&ie=UTF-8&oe=UTF-8&output=rss&q=ビットコイン');
echo '<ul class="rss">';
foreach($rss->channel->item as $item){
	$title = $item->title;
	$date = date("Y/n/j", strtotime($item->pubDate));
  $link = $item->link;
  ++$count;
  if($count === $num) {
      break;
    }
?>

<li><a href="<?php echo $link; ?>" target="_blank">
<span class="title"><?php echo $title; ?></span>
<span class="date"><?php echo $date; ?></span>
</a></li>
<?php }  
echo '</ul></div>';
?>
    <div id ="links" class="col-md-6">
      <h3>取引所へのリンク</h3>
        <div class="list-group">
          <a href="https://bitflyer.com/ja-jp/" class="list-group-item list-group-item-action">bitFlyer</a>
          <a href="https://coincheck.com/ja/" class="list-group-item list-group-item-action">Coincheck</a>
          <a href="https://bitcoin.dmm.com/" class="list-group-item list-group-item-action">DMMコイン</a>
          <a href="https://coin.z.com/jp/" class="list-group-item list-group-item-action">GMOコイン</a>
          <a href="https://zaif.jp/?lang=ja/" class="list-group-item list-group-item-action">Zaif</a>
        </div>
    </div>

    <div id ="topics" class="col-md-6">
      <h3>開発中</h3>
      <p id="disc">ビットコインの売買の役に立つツールを作っていきたいと思っています。
        支援してくださる方がいらっしゃいましたら、coincheckからの送金をお待ちしております。
        開発者が喜んでコーヒーを飲むので、開発スピードが上がるかも・・・
        <br>bitcoin address:18yCHudbTRxn9fy64YuACXPrmSQ9ggE73e
      </p>
      <img src="img/address.jpg" width="100px" height="100px">
    </div>

    <div id ="others" class="col-md-6">
    <h3>その他</h3>
      <a href="https://github.com/cryptohakka/bitcoinwhitepaper_jp/blob/master/Japanese/bitcoin_ja.pdf" class="list-group-item list-group-item-action">ビットコインの仕組み(原論文日本語訳)</a>
    </div>
</div>
  <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="row">
        <div class="col-md-12">
          <img class="mb-2" src="img/bitcoin.svg" alt="" width="24" height="24">
          <small class="d-block mb-3 text-muted">&copy; WatchCoin 2020</small>
        </div>
      </div>
  </footer>
</div> <!-- container -->

<!-- JavaScriptを使用する場合 -->
<!-- jQuery、Popper.js、Bootstrap.jsの順番で読み込みます（下記はbundle版を使用） -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" integrity="sha384-zDnhMsjVZfS3hiP7oCBRmfjkQC4fzxVxFhBx8Hkz2aZX8gEvA/jsP3eXRCvzTofP" crossorigin="anonymous"></script>

</body>
</html>
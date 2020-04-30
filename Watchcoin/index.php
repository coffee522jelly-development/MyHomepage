<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<link rel="icon" type="image/x-icon" href="img/bitcoin.svg">

<title>WatchCoin</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<!-- MainGraph.js -->
<script src="js/mainGraph.js"></script>
<!-- MainFunc.js -->
<script src="js/mainFunc.js"></script>
<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<!-- upData.js 
<script src="js/upDate.js"></script>
-->
<!-- Charts.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<!-- ColorSchemes -->
<script type="text/javascript" src="https://github.com/nagix/chartjs-plugin-colorschemes/releases/download/v0.2.0/chartjs-plugin-colorschemes.min.js"></script>


<body>
  <!-- Navbar -->
  <header>
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand" href="#">
        <img src="img/bitcoin.svg" width="30" height="30" class="d-inline-block align-top" alt="">
        WatchCoin
      </a>
    </nav>
  </header>

<div class="container">
  <h3>BTC/JPY　チャート <?php echo $periods?></h3>
    <div class="row">
      <canvas id="myDayChart" class="col-md-12" width="1600px" height="650px"></canvas>
    </div>
    <br>
    <label for="SampleSize">時間足の指定(default=1分足)：</label>
      <form action="index.php" method="post">
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='60'>1m</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='180'>3m</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='300'>5m</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='900'>15m</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='1800'>30m</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='3600'>1h</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='7200'>2h</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='14400'>4h</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='21600'>6h</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='43200'>12h</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='86400'>1d</button>
        <button class="periods btn-dark rounded-pill w-100px " type='submit' name='periods' value='259200'>3d</button>
        <!-- <button type='submit' name='periods' value='604800'>週足</button> -->
      </form>
      <!--
      <button id="180btn" class="periods btn-dark rounded-pill w-100px" >３分足</button>
      -->
    <br>
    <label for="SampleSize">表示するデータ数(default=500)：</label>
      <form name="ReDraw" class ="col-md-2">
        <select id="SampleSize" name="Width" onChange="WidthSize()" class="form-control">
          <option value="100">100</option>
          <option value="250">250</option>
          <option value="500">500</option>
          <option value="750">750</option>
          <option value="1000">1000</option>
        </select>
      </form>
<br>
<br>
<br>
<!-- <form action="/index.php" method="post">
    <label for="TimeSize">足幅：</label>
    <select name="TimeSize[]" multiple="multiple">
        <option value="60">1分足</option>
        <option value="180">3分足</option>
        <option value="300">5分足</option>
        <option value="900">15分足</option>
        <option value="1800">30分足</option>
        <option value="3600">1時間足</option>
        <option value="7200">2時間足</option>
        <option value="14400">4時間足</option>
        <option value="21600">6時間足</option>
        <option value="43200">12時間足</option>
        <option value="86400">日足</option>
        <option value="259200">3日足</option>
        <option value="604800">週足</option>
    </select>
    <input type="submit" value="送信">
</form> -->

  <h3>現在価格</h3>
    <div class="row">
      <canvas id="myBarChart" class="col-md-6" width="400px" height="200px"></canvas>
      <canvas id="myBarChart2" class="col-md-6" width="400px" height="200px"></canvas>
    </div>

    <div id="nowPrice">
      <p id="Value" class="col-md-6 Trend"></p>
      <p id="Trend" class="col-md-6 Trend"></p>
      <p id="buy" class="col-md-6 Trend"></p>
      <p id="mid" class="col-md-6 Trend"></p>
      <p id="sell" class="col-md-6 Trend"></p>
      <p id="diff" class="col-md-6 Trend"></p>
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

// bitflyerでの板取引
$json_str = file_get_contents("https://bitflyer.jp/api/echo/price");
$arr = json_decode($json_str, true);

// Krakenでのドル現在価格
$json_str = file_get_contents("https://api.cryptowat.ch/markets/kraken/btcusd/price");
$aryPrice = json_decode($json_str, true);
$btcusd = $aryPrice["result"]["price"];

require "Request.php";
?>

<script>
  MainGraph();

  let $bitFlyer   = <?php echo $Bitflyer; ?>;
  let $zaif       = <?php echo $Zaif; ?>;
  let $conicheck  = <?php echo $Coincheck; ?>;
  let btcusd     = <?php echo $btcusd; ?>;

  let ave = Math.round((parseInt($bitFlyer) + parseInt($zaif) + parseInt($conicheck)) / 3);
  document.getElementById('Value').innerHTML = "BitCoinの現在価格：約"　+ ave + "円("+ btcusd +"USDドル)";

  // グローバル設定
  Chart.defaults.global.defaultFontColor = '#cccccc';

  var ctx = document.getElementById("myBarChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Conicheck", "Zaif", "bitFlyer", "Average"],
      datasets: [{
        label: 'Bitcoin',
        data: [$conicheck, $zaif, $bitFlyer, ave]
      }]
    },
    options: {
    animation: false,
    plugins: {
      colorschemes: {
        scheme: 'brewer.Blues8'
      }
    },
    scales: {
        xAxes: [{
          gridLines: {
              color: "#444444",
          },
          ticks: {
            maxRotation: 20,
            minRotation: 0
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

  let $bid = "<?php echo $arr['bid']?>";
  let $mid = "<?php echo $arr['mid']?>";
  let $ask = "<?php echo $arr['ask']?>";

  var ctx2 = document.getElementById("myBarChart2").getContext('2d');
  var myChart2 = new Chart(ctx2, {
    type: 'line',
    data: {
      labels: ["買い値", "中値", "売値"],
      datasets: [{
        label: '価格差グラフ/bitFlyer',
        data: [$bid, $mid, $ask],
        pointRadius: 0,
        pointHitRadius: 2,
      }]
    },
    options: {
    animation: false,
    plugins: {
      colorschemes: {
        scheme: 'brewer.Blues8'
      }
    },
    scales: {
        xAxes: [{
          gridLines: {
              color: "#444444",
          },
          ticks: {
            maxRotation: 20,
            minRotation: 0
          }
        }],
        yAxes: [{
          gridLines: {
              color: "#444444",
          }
        }]
      }
    },
  });

  // let trend;
  // let strTrend;
  // if(parseInt($bitFlyer) < parseInt($mid)){
  //   trend = Boolean("true");
  //   strTrend = "上げ(高く売りたい)";
  // }
  // else{
  //   trend = Boolean("false");
  //   strTrend = "下げ(安く買いたい)";
  // }
  // document.getElementById('Trend').innerHTML = "トレンド(中値-現在価格):" + strTrend;

  document.getElementById('buy').innerHTML = "買い値：" + $bid +"円";
  document.getElementById('mid').innerHTML = "中値：" + $mid + "円";
  document.getElementById('sell').innerHTML = "売り値：" + $ask + "円";
  document.getElementById('diff').innerHTML = "(売り−買い)：" + ($ask - $bid) + "円";

  var ssu = new SpeechSynthesisUtterance();
  ssu.text = 'ビットコインの現在価格は' + ave +'円で、'+ btcusd +'ドルです。';
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
  <li>
    <a href="<?php echo $link; ?>" target="_blank">
    <span class="title"><?php echo $title; ?></span>
    <span class="date"><?php echo $date; ?></span>
    </a>
  </li>
<?php }
echo '</ul></div>';
?>
    <div id ="links" class="col-md-6">
      <h3>取引所へのリンク</h3>
        <div class="list-group">
          <a href="https://app.bitbank.cc/trade" class="list-group-item list-group-item-action">bitbank</a>
          <a href="https://bitflyer.com/ja-jp/" class="list-group-item list-group-item-action">bitFlyer</a>
          <a href="https://www.bitmex.com/?lang=ja-jp" class="list-group-item list-group-item-action">bitMEX</a>
          <a href="https://coincheck.com/exchange/tradeview" class="list-group-item list-group-item-action">Coincheck</a>
          <a href="https://bitcoin.dmm.com/" class="list-group-item list-group-item-action">DMMコイン</a>
          <a href="https://coin.z.com/jp/" class="list-group-item list-group-item-action">GMOコイン</a>
          <a href="https://app.liquid.com/ja/" class="list-group-item list-group-item-action">Liquid by Quoine</a>
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

<!-- jQuery、Popper.js、Bootstrap.jsの順番で読み込みます（下記はbundle版を使用） -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js" integrity="sha384-zDnhMsjVZfS3hiP7oCBRmfjkQC4fzxVxFhBx8Hkz2aZX8gEvA/jsP3eXRCvzTofP" crossorigin="anonymous"></script>

</body>
</html>
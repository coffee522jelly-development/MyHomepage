<?php
// URLから足パラメータを読み取る
if(isset($_POST["periods"])) {
    $periods = $_POST["periods"];
} else {
	$periods = 900;
}

// 指定時間足のデータ取得
$json_trade = file_get_contents("https://api.cryptowat.ch/markets/bitflyer/btcjpy/ohlc?periods=".$periods);
$arrOHLC = json_decode($json_trade, true);
$arraycount = count($arrOHLC["result"][$periods], 1) / 8;

?>
<script>
    let periods = <?php echo $periods; ?>;
    let aryTrade = <?php echo $json_trade; ?>;
    let arySize = <?php echo $arraycount; ?>;

    //　時間足情報
    let Xperiods = "<?php echo $periods?>";

    // デフォルト500設定
    document.getElementById('SampleSize').options[2].selected = true;
    let aryWidth = 500;

    GetOHLCData();
    GetMA();
</script>

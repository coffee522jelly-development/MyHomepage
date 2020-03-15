
function speak()
{
    var text = document.querySelector('.text').value;
    var uttr = new SpeechSynthesisUtterance(text);
    uttr.text = document.querySelector('.text').value;
    uttr.lang = 'ja-JP';
    speechSynthesis.speak(uttr);
}

function Read()
{
    var text = document.querySelector('#Read').value;
    var uttr = new SpeechSynthesisUtterance(text);
    uttr.text = document.querySelector('#Read').value;
    uttr.lang = 'ja-JP';
    uttr.rate = 1.0;
    speechSynthesis.speak(uttr);
}

function recog(){
var btn = document.getElementById('btn');
var content = document.getElementById('content');

//音声認識APIの使用
var speech = new webkitSpeechRecognition();

//言語を日本語に設定
speech.lang = "ja";

//ボタンクリックで認識開始
btn.addEventListener('click', function() {
  speech.start();
});

//認識されたテキストを使って処理を分岐
speech.addEventListener('result', function(e) {
  console.log(e);
  var text = e.results[0][0].transcript;
  switch(text) {
    case "ホーム":
      alert("ホーム画面に戻ります。");
      goToHome();
      break;  
    case "設定":
      alert("設定画面を開きます。");
      Setting();
      break;
    case "ヘルプ":
      alert("ヘルプ画面を開きます。");
      Help();
      break;     
    case "登録":
      alert("登録画面を表示します。");
      SubmitBM();
      break;
    case "ブックマーク":
      alert("登録されているブックマーク一覧に移動します。このページでは、登録されたWebサイトの音声コマンドを使用できます。");
      AllviewBM();
      break;  
    /*case "削除":
      alert("削除画面を表示します。");
      Delete();
      break;*/
    case "ログアウト":
      alert("ログアウトします。");
      Signout();
      break;  
    case "サインアウト":
      alert("サインアウトします。");
      Signout();
      break;
   /* case "読み上げ":
      alert("読み上げます。");
      Read1();
      break;
    case "一覧":
      alert("一覧を表示します。");
      Allview();
      break;
    case "テレビ":
      alert("テレビを表示します。");
      Television();
      break;
    case "アップロード":
      alert("アップロード画面に移動します。");
      Upload();
      break;
      */

    case "スクロール":
      alert("自動スクロールします。");
      document.getElementById( "Hello" ).value = 'スクロールします。';
      speak();
      AutoScroll();
      break;

    default:
    if ($('#BM').is(':visible')) {
    // 表示されている場合の処理
    accessToBM(text);
    } else {
    // 非表示の場合の処理
    getTextContents(text);
    }
    break;
  }
});
}
//ビデオ
function getVideo() {
    var URL = '<iframe width="560" height="315" src="https://www.youtube.com/embed/TBEuMfNqv_k?rel=0&amp;controls=0&amp;showinfo=0;autoplay=1" frameborder="0" allowfullscreen></iframe>';
    content.innerHTML = URL;
    document.getElementById( "Hello" ).value = 'ビデオ';
}

//イベント
function getEventData() {
  // キーワードを「東京」に設定
  var baseURL = "https://api.atnd.org/events/?keyword=東京&format=jsonp&count=20&callback=callback";
  var script = document.createElement('script');
  document.getElementById( "Hello" ).value = 'イベント';
  script.src = baseURL;
  document.body.appendChild(script);

  window.callback = function(data) {
    var ul = document.createElement('ul');
    content.appendChild(ul);

    for(var item in data.events) {
      var li = document.createElement('li');
      var a = document.createElement('a');

      a.href = data.events[item].event.event_url;
      a.textContent = data.events[item].event.title;
      a.target = "_blank";
      li.style.lineHeight = 1.5;
      li.appendChild(a);
      ul.appendChild(li);
    }
  };
}

//テキスト表示
function getTextContents(text) {
  document.getElementById( "Hello" ).value = 'すみません、わかりません。';
  speak();
  content.innerHTML = '<p>認識された言葉は</p>' +
                   '<input id="recog" class="recog"  value="' + text + '"><button onclick="copyToClipboard()">コピー</button>';
}

function accessToBM(text){
 //content.innerHTML = '<button onclick="copyToClipboard()">コピー</button>';
  //例外の中から比較対象を抽出
  var elements = document.getElementsByClassName( "cmd" ) ;	// HTMLCollection
  var url = document.getElementsByClassName( "url" ) ;	// HTMLCollection
  var count = 0;
  for (var i = 0; i < 100; i++) {

  if(elements[i].innerText == text){
    //console.log('hello');
    count++;
    document.getElementById( "Hello" ).value = elements[i].innerText + 'に移動します。';
    speak();
    window.open().location.href = url[i].href;
  }
}
}

//ログアウト画面への遷移
function Signout(){
  document.getElementById( "Hello" ).value = 'サインアウトしました。ログインページに戻りましょう。';
  speak();
  window.location.href = 'Login/logout.php'; //通常の遷移
}
//アベマTVのニュースチャンネル
function Television(){
  document.getElementById( "Hello" ).value = 'テレビ';
  window.location.href  = 'https://abema.tv/now-on-air/abema-news'; //通常の遷移
}
//音声ブックマークみたいなものも面白いかもしれない。

//音声メモコピー用javascript
function copyToClipboard() {
    // コピー対象をJavaScript上で変数として定義する
    var copyTarget = document.getElementById("recog");
    // コピー対象のテキストを選択する
    copyTarget.select();
    // 選択しているテキストをクリップボードにコピーする
    document.execCommand("Copy");
    // コピーをお知らせする
    alert("コピーできました！ : " + copyTarget.value);
}
//if登録
function Submit(){
  document.getElementById( "Hello" ).value = '登録画面を表示しました。情報を入力してください。';
  speak();
  $.ajax({
      url:'./Submit.html',
      type:'GET'
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      Read();
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}
function SubmitBM(){
  document.getElementById( "Hello" ).value = '登録画面を表示しました。情報を入力してください。';
  speak();
  $.ajax({
      url:'./SubmitBM.html',
      type:'GET'
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      Read();
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}
function Setting(){
  document.getElementById( "Hello" ).value = '設定画面を開きました';
  speak();
  $.ajax({
    url:'./Setting.php',
    type:'GET'
})
// Ajaxリクエストが成功した時発動
.done( (data) => {
    $('.result').html(data);
    console.log(data);
    $('#color-type').on('click',function(){
        $.ajax({
        })
        // Ajaxリクエストが成功した時発動
        .done( (data) => {
            alert("テーマを" + $("input:radio[name='radio_group']:checked").val()+"に変更します。");
            if($("input:radio[name='radio_group']:checked").val()=="ダーク"){
                $("#top_bar").removeClass("bg-danger");
                $("#top_bar").removeClass("bg-primary");
                $('#top_bar').addClass("navbar-dark");
                $('#top_bar').addClass("bg-dark");
            }
            if($("input:radio[name='radio_group']:checked").val()=="ブルー"){                      $('#top_bar').addClass("navbar-dark");
                $("#top_bar").removeClass("bg-dark");
                $("#top_bar").removeClass("bg-danger");    
                $('#top_bar').addClass("navbar-dark");
                $('#top_bar').addClass("bg-primary");
            }
            if($("input:radio[name='radio_group']:checked").val()=="レッド"){
                $("#top_bar").removeClass("bg-dark");
                $("#top_bar").removeClass("bg-primary");   
                $('#top_bar').addClass("navbar-dark");
                $('#top_bar').addClass("bg-danger");  
            }
            $.ajax({
                url:'./Setting/Setting.php',
                type:'POST',
                data:{
                  'color':$("input:radio[name='radio_group']:checked").val()
                }
            })
            // Ajaxリクエストが成功した時発動
            .done( (data) => {
                $('.result').html(data);
                console.log(data);
            })
        })
        // Ajaxリクエストが失敗した時発動
        .fail( (data) => {
            $('.result').html(data);
            console.log(data);
        })
        // Ajaxリクエストが成功・失敗どちらでも発動
        .always( (data) => {
        });
    });
})
// Ajaxリクエストが失敗した時発動
.fail( (data) => {
    $('.result').html(data);
    console.log(data);
})
}
function Help(){
    document.getElementById( "Hello" ).value = 'ヘルプ画面を開きました';
    speak();
  $.ajax({
      url:'./help.html',
      type:'GET'
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      Read();
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}

//if削除
function Delete(){
  document.getElementById( "Hello" ).value = '削除フォームを表示しました。';
  speak();
  $.ajax({
      url:'./DeleteTable.html',
      type:'GET',
      data:{
      }
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      $('#DeleteAll').on('click',function(){
          $.ajax({
              url:'./DeleteTable.php',
              type:'POST',
              data:{
                'dbtable':$('#dbtable').val()
              }
          })
          // Ajaxリクエストが成功した時発動
          .done( (data) => {
              $('.result').html(data);
              console.log(data);
          })
          // Ajaxリクエストが失敗した時発動
          .fail( (data) => {
              $('.result').html(data);
              console.log(data);
          })
          // Ajaxリクエストが成功・失敗どちらでも発動
          .always( (data) => {

          });
      });
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}
//if削除
function Allview(){
  document.getElementById( "Hello" ).value = '一覧画面を表示しました。';
  speak();
  $.ajax({
      url:'./allview.php',
      type:'GET'
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      Read();
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}

function AutoScroll(){
//読み上げスクロールができないか検討
var speed = 100; // スクロールのスピード（1に近いほど速く）
var move = 5; // スクロールのなめらかさ（1に近いほどなめらかに）
// 初期化
var x = 0;
var y = 0;
var nx = 0;
var ny = 0;

	window.scrollBy(0, move); // スクロール処理

	var rep = setTimeout("AutoScroll()", speed);

	// スクロール位置をチェック（IE用）
	if(document.all){

		x = document.body.scrollLeft;
		y = document.body.scrollTop;

	}
	// スクロール位置をチェック（NN用）
	else if(document.layers || document.getElementById){

		x = pageXOffset;
		y = pageYOffset;

	}

	if(nx == x && ny == y){ // スクロールし終わっていたら処理を終了

		clearTimeout(rep);

	}
	else{

		nx = x;
		ny = y;

	}
}

function AllviewBM(){
  document.getElementById( "Hello" ).value = '登録されているブックマーク一覧画面を表示しました。';
  speak();
  $.ajax({
      url:'./allviewBM.php',
      type:'GET'
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      Read();
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}

function Read1(){
  document.getElementById( "Hello" ).value = '入力番号のレシピを読み上げます。';
  speak();
  $.ajax({
      url:'./Read.php',
      type:'POST',
      data:{
          'number':$('#number').val()
      }
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      Read();
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}

function goToHome(){
    document.getElementById( "Hello" ).value = 'ホームに戻りました。';
    speak();
        $.ajax({
            url:'./home.html',
            type:'GET',
            data:{
            }
        })
        // Ajaxリクエストが成功した時発動
        .done( (data) => {
            $('.result').html(data);
            console.log(data);
        })
        // Ajaxリクエストが失敗した時発動
        .fail( (data) => {
            $('.result').html(data);
            console.log(data);
        })
        // Ajaxリクエストが成功・失敗どちらでも発動
        .always( (data) => {

        });
    }

function Upload(){
  document.getElementById( "Hello" ).value = '画像をアップロードしましょう。';
  speak();
  $.ajax({
      url:'photo%20uploader/uploader.php',
      type:'POST',
      data:{
          'number':$('#number').val()
      }
  })
  // Ajaxリクエストが成功した時発動
  .done( (data) => {
      $('.result').html(data);
      console.log(data);
      Read();
  })
  // Ajaxリクエストが失敗した時発動
  .fail( (data) => {
      $('.result').html(data);
      console.log(data);
  })
}

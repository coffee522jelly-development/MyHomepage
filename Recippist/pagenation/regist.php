<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <script type="text/javascript">
      document.onkeydown = keydown;

      function keydown() {
        target = document.getElementById("message");
        target.innerHTML = "キーが押されました KeyCode :" + event.keyCode;

        target = document.getElementById("messageShift");
        if (event.shiftKey == true) {
          target.innerHTML = "Shiftキーが押されました";
        }
        else {
          target.innerHTML = "";
        }

        target = document.getElementById("messageCtrl");
        if (event.ctrlKey == true) {
          target.innerHTML = "Ctrlキーが押されました";
        }
        else {
          target.innerHTML = "";
        }

        target = document.getElementById("messageAlt");
        if (event.altKey == true) {
          target.innerHTML = "Altlキーが押されました";
        }
        else {
          target.innerHTML = "";
        }
      }
    </script>
</head>

<body>

  <div>メッセージ</div>
  <div id="message"></div>
  <div id="messageShift"></div>
  <div id="messageCtrl"></div>
  <div id="messageAlt"></div>
</body>
</html>

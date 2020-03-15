<h2>画像のアップロード</h2>
<form action="./photo%20uploader/process.php" method="post" enctype="multipart/form-data">
	<input type="file" name="fileToUpload" accept="image/*">
	<input type="submit" value="画像のアップロード">
</form>

<script>
$(function() {
  $('input[type=file]').after('<section id="photo"></section>');

  // アップロードするファイルを選択
  $('input[type=file]').change(function() {
    var file = $(this).prop('files')[0];

    // 画像以外は処理を停止
    if (! file.type.match('image.*')) {
      // クリア
      $(this).val('');
      $('section').html('');
      return;
    }

    // 画像表示
    var reader = new FileReader();
    reader.onload = function() {
      var img_src = $('<img>').attr('src', reader.result);
      $('section').html(img_src);
    }
    reader.readAsDataURL(file);
  });
});
</script>

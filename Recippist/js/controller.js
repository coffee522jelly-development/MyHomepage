$( '#Hello' ).keypress( function ( e ) {
if ( e.which == 13 ) {
  // ここに処理を記述
  document.getElementById('btn').click();
  return false;
}
});

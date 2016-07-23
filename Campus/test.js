function changeDisabled() {
  if ( document.touroku["student"][0].checked ) {
    <!-- 「大学生」のラジオボタンをクリックしたとき -->
      document . touroku["daigaku"] . disabled = false;
    <!--「大学生」のラジオボタンの横のテキスト入力欄を有効化 -->
      document . touroku["gakuseki"] . disabled = false;
    <!--「大学生」のラジオボタンの横のテキスト入力欄を有効化 -->
  } else {
    <!-- 「大学生」のラジオボタン以外をクリックしたとき -->
      document . touroku["daigaku"] . disabled = true;
    <!--「その他」のラジオボタンの横のテキスト入力欄を無効化 -->
      document . touroku["gakuseki"] . disabled = true;
    <!--「その他」のラジオボタンの横のテキスト入力欄を無効化 -->
  }
}

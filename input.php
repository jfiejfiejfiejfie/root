<form action="confirm.php" method="post" name="form" onsubmit="return validate()"> 
<p>お問い合わせ内容をご入力の上、「確認画面へ」ボタンをクリックしてください。</p>
<div>
<label>お名前<span class="span">必須</span></label>
<input type="text" name="name" placeholder="例）山田太郎" value="">
</div>
<div>
<label>ふりがな<span class="span">必須</span></label>
<input type="text" name="furigana" placeholder="例）やまだたろう" value="">
</div>
<div>
<label>メールアドレス<span class="span">必須</span></label>
<input type="text" name="email" placeholder="例）guest@example.com" value="">
</div>
<div>
<label>電話番号<span class="nin">任意</span></label>
<input type="text" name="tel" placeholder="例）0000000000" value="">
</div>
<div>
<label>性別<span class="span">必須</span></label>
<input type="radio" name="sex" value="男性" checked> 男性
<input type="radio" name="sex" value="女性"> 女性
</div>
<div>
<label>お問い合わせ項目<span class="span">必須</span></label>
<select name="item">
<option value="">お問い合わせ項目を選択してください</option>
<option value="ご予約">ご予約</option>
<option value="ご質問・お問い合わせ">ご質問・お問い合わせ</option>
<option value="ご意見・ご感想">ご意見・ご感想</option>
</select>
</div>
<div>
<label>お問い合わせ内容<span class="span">必須</span></label>
<textarea name="content" rows="5" placeholder="お問合せ内容を入力"></textarea>
</div>
<button class="btn" type="submit">確認画面へ</button>
</form>
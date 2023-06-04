<div id="modal-help" class="modal modal-fixed-footer">
	<div class="modal-content help">
		<p>店舗編集についてのヘルプ一覧</p>
		<div class="modal-box">
			<ul class="collapsible help" data-collapsible="accordion">
				<li id="section0">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>トップ画像とは？</div>
					<div class="collapsible-body">
						<span>トップ画像とは、ユーザーが店舗の紹介ページにアクセスした時に一番上に表示される画像です。
							こちらの画像は重要な役割を持っています。<br>何故なら検索したユーザーはトップ画像の見栄えでタップする確率が高いからです。
							なるべく映える写真がおすすめです。試しに画像をアップして「店舗ページを確認する」で確認してみることをおすすめします。下の画像のように掲載されます。
						</span>
						<img class="responsive-img" width="100%"
							src="<?=HELP_SHOP['TOP_IMAGE_01']?>" />
					</div>
				</li>
				<li id="section1">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>キャッチコピーとは？</div>
					<div class="collapsible-body"><span>キャッチコピーはお店のPR部分で宣伝となる場所です。これはGoogleで検索した際に概要部分に表示されます。
							<br>また店舗基本的に120文字以内が最適とされています。<br><span
								class="red-text">※</span>注意点としまして絵文字も使えますが文字数を２つ消費します。</span>
						<img class="responsive-img" width="100%"
							src="<?=HELP_SHOP['CATCH_01']?>" />
						<span>もちろん店舗の紹介ページにも反映されます。
						<img class="responsive-img" width="100%"
							src="<?=HELP_SHOP['CATCH_02']?>" />
							<br>キャッチコピーを決めるのに悩んだら他の店舗を参考にしてみるのもいいかもしれません。</span>
					</div>
				</li>
				<li id="section2">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>クーポンとは？</div>
					<div class="collapsible-body"><span><?=LT['001']?>だけで使えるクーポンになります。
							<br>クーポンの対象期間を設定し、クーポンタイトルと、クーポン内容を設定します。
							<br><span class="red-text">またクーポン設定後は、表示切り替え「ON」を行わないと紹介ページに反映されませんのでご注意ください。</span>
							<br>いくつかのクーポンを用意し時期に合わせて表示する、表示しない等の設定ができます。
							<br>紹介ページのショップメニューからクーポンをタップすると以下のように表示されます。</span>
						<img class="responsive-img" width="100%"
							src="<?=HELP_SHOP['COUPON_01']?>" />
					</div>
				</li>
				<li id="section3">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>スタッフとは？</div>
					<div class="collapsible-body"><span>スタッフを店舗に追加することが出来ます。
							<br><?=LT['001']?>内でスタッフのアカウントを作成いたします。
							<br>スタッフは自身の管理画面にログインすることが出来ます。
							<br>
							<h6>追加手順</h6>
							<div class="divider"></div>
							<i class="material-icons">check</i>名前を入力<br><span class="red-text">※</span>名前は基本的に本名です。
							<div class="divider"></div>
							<i class="material-icons">check</i>ニックネームを入力<br><span
								class="red-text">※</span>紹介ページにはにニックネームのみで表示されます。
							<div class="divider"></div>
							<i class="material-icons">check</i>メールアドレスを入力<br><span
								class="red-text">※</span>スタッフの方にメールアドレスを確認する必要があります。
							<div class="divider"></div>
							<i class="material-icons">check</i>登録ボタンをタップ<br><span
								class="red-text">※</span>入力したメールアドレスに認証メールを送信します。
							スタッフの方で認証するためのリンクをタップする必要があります。認証の有効期限は１時間なので
							過ぎた場合はやり直しになりますのでご注意ください。<br>認証完了後、画面の再読み込みを行ってください。
							スタッフが追加されましたら、クーポンと同様に表示切り替え「ON」にしてください。<br>
							もしスタッフが退職した場合等は「OFF」にするか削除をしてください。
						</span></div>
				</li>
				<li id="section4">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>店舗情報とは？</div>
					<div class="collapsible-body"><span>店舗情報は早い段階で入力しておきましょう！
							<br>アクセスユーザーは料金体制がどうなのか、店舗でカードが使えるか、等情報を把握したいはずです。</span></div>
				</li>
				<li id="section5">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>店舗ギャラリーとは？</div>
					<div class="collapsible-body"><span>店舗ギャラリーは店内の雰囲気などイメージが湧くような画像を載せるとよいでしょう。
							<br>アップロード制限として、９枚の画像のみとしています。
						</span></div>
				</li>
				<li id="section6">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>求人情報とは？</div>
					<div class="collapsible-body"><span>求人情報を載せておくだけでその店舗が活発である証拠になります。
							募集をしていなくても載せておくことをおすすめします。</span></div>
				</li>
				<li id="section7">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>SNSとは？</div>
					<div class="collapsible-body">
						<h6><i class="material-icons">check</i>FaceBookの追加方法</h6>
						<span>自身のアカウントページでURL「facebook.com/」より後ろ赤枠部分がアカウントになりますのでそちらを入力してください。
							<img class="responsive-img" width="100%"
								src="<?=HELP_SHOP['SNS_01']?>" />
						</span>
						<div class="divider"></div>
						<br>
						<h6><i class="material-icons">check</i>Twitterの追加方法</h6>
						<span>自身のアカウントページでサイドメニューを表示し、赤枠部分がアカウントになりますのでそちらを入力してください。
							<img class="responsive-img" width="100%"
								src="<?=HELP_SHOP['SNS_02']?>" />
						</span>
						<div class="divider"></div>
						<br>
						<h6><i class="material-icons">check</i>Instagramの追加方法</h6>
						<span>自身のアカウントページでサイドメニューを表示し、赤枠部分がアカウントになりますのでそちらを入力してください。
							<img class="responsive-img" width="100%"
								src="<?=HELP_SHOP['SNS_03']?>" />
						</span>
					</div>
				</li>
				<li id="section8">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>店舗お知らせとは？</div>
					<div class="collapsible-body"><span>店舗からお知らせを投稿出来ます。店舗ブログとしても活用ください。</span></div>
				</li>
				<li id="section9">
					<div class="collapsible-header"><i class="material-icons">whatshot</i>出勤管理とは？</div>
					<div class="collapsible-body"><span>日々の出勤状況をUPすることが出来ます。</span></div>
				</li>
			</ul>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-green btn-flat">閉じる</a>
	</div>
</div>
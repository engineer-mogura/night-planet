document.write("<script type='text/javascript' src='/js/util.js'></script>");
/** */
$(document).ready(function () {
    allInitialize();
});

/**
 * オール初期化
 */
function allInitialize() {
    if ($("#user-default").length) {
        initializeUser();
    }
    if ($("#owner-default").length) {
        initializeOwner();
    }
    if ($("#shop-default").length) {
        initializeShop();
    }
    if ($("#cast-default").length) {
        initializeCast();
    }
    if ($("#developer-default").length) {
        initializeDeveloper();
    }

    // 初期化
    initialize();
}

/**
 * イベントオールクリア
 */
function crearAllevents() {
    if ($("#user-default").length) {
        crearUserEvents();
    }
    if ($("#owner-default").length) {
        crearOwnerEvents();
    }
    if ($("#shop-default").length) {
        crearShopEvents();
    }
    if ($("#cast-default").length) {
        crearCastEvents();
    }
    if ($("#developer-default").length) {
        crearDeveloperEvents();
    }

    crearCommonEvents();
}

/**
 * ユーザー画面のイベントクリア
 */
function crearUserEvents() {
    /** ユーザートップ画面 START */
    $(document).off("change", "#image-file");
    /** ユーザートップ画面 END */
}

/**
 * オーナー画面のイベントクリア
 */
function crearOwnerEvents() {
    /** オーナートップ画面 START */
    $(document).off("change", ".shop-switchBtn");
    $(document).off("change", "#image-file");
    /** オーナートップ画面 END */
}

/**
 * ショップ画面のイベントクリア
 */
function crearShopEvents() {
    /** 共通 START */
    $(document).off("click", ".modal-trigger.edit-help");
    /** 共通 END */
    /** トップ画像タブ START */
    $(document).off("click", ".top-image-changeBtn");
    $(document).off("click", ".top-image-saveBtn");
    /** トップ画像タブ END */
    /** キャッチコピータブ START */
    $(document).off("click", ".catch-changeBtn");
    $(document).off("click", ".catch-saveBtn");
    $(document).off("click", ".catch-deleteBtn");
    /** キャッチコピータブ END */
    /** クーポンタブ START */
    $(document).off("click", ".coupon-changeBtn");
    $(document).off("click", ".coupon-addBtn");
    $(document).off("click", ".coupon-saveBtn");
    $(document).off("click", ".check-coupon-group");
    $(document).off("change", ".coupon-switchBtn");
    $(document).off("click", ".coupon-deleteBtn");
    /** クーポンタブ END */
    /** スタッフタブ START */
    $(document).off("click", ".cast-changeBtn");
    $(document).off("click", ".cast-addBtn");
    $(document).off("click", ".cast-saveBtn");
    $(document).off("click", ".check-cast-group");
    $(document).off("change", ".cast-switchBtn");
    $(document).off("click", ".cast-deleteBtn");
    /** スタッフタブ END */
    /** 店舗情報タブ START */
    $(document).off("click", ".tenpo-changeBtn");
    $(document).off("click", ".tenpo-saveBtn");
    /** 店舗情報タブ END */
    /** 店舗ギャラリータブ START */
    $(document).off("click", ".gallery-deleteBtn");
    $(document).off("change", "#image-file");
    $(document).off("click", ".gallery-saveBtn");
    $(document).off("click", ".gallery-chancelBtn");
    /** 店舗ギャラリータブ END */
    /** 求人情報タブ START */
    $(document).off("click", ".jobModal-callBtn");
    $(document).off("click", ".chip-credit");
    $(document).off("click", ".job-changeBtn");
    $(document).off("click", ".job-saveBtn");
    $(document).off("click", ".chip-treatment");
    /** 求人情報タブ END */
    /** SNSタブ START */
    $(document).off("click", ".sns-changeBtn");
    $(document).off("click", ".sns-saveBtn");
    /** SNSタブ END */
    /** お知らせ画面 */
    $(document).off("change", "#title, #content, #image-file");
    $(document).off(
        "change",
        "#modal-title, #modal-content, #modal-image-file"
    );
    $(document).off("change", "#image-file");
    $(document).off("change", "#modal-image-file");
    $(document).off("click", ".createBtn");
    $(document).off("click", ".updateBtn");
    $(document).off("click", ".archiveLink");
    $(document).off("click", ".updateModeBtn");
    $(document).off("click", ".returnBtn");
    $(document).off("click", ".deleteBtn");
    /** お知らせ画面 */
    /** 出勤管理画面 */
    $(document).off("click", ".saveBtn");
    $(document).off("click", ".chip-cast");
    /** 出勤管理画面 */
}

/**
 * スタッフ画面のイベントクリア
 */
function crearCastEvents() {
    $(document).off("input");
    $(document).off("change", "select");
    $(document).off("change", "#title, #content, #image-file");
    $(document).off(
        "change",
        "#modal-title, #modal-content, #modal-image-file"
    );
    $(document).off("change", "#image-file");
    $(document).off("change", "#modal-image-file");
    $(document).off("click", ".createBtn");
    $(document).off("click", ".updateBtn");
    $(document).off("click", ".archiveLink");
    $(document).off("click", ".updateModeBtn");
    $(document).off("click", ".returnBtn");
    $(document).off("click", ".saveBtn");
    $(document).off("click", ".deleteBtn");
    $(document).off("click", ".chancelBtn");
    $(document).off("click", ".changeBtn");
    $(document).off("change", "#image-file");
}

/**
 * ショップ画面のイベントクリア
 */
function crearDeveloperEvents() {

    /** ニュース画面 */
    $(document).off("change", "#title, #content, #image-file");
    $(document).off(
        "change",
        "#modal-title, #modal-content, #modal-image-file"
    );
    $(document).off("change", "#image-file");
    $(document).off("change", "#modal-image-file");
    $(document).off("click", ".createBtn");
    $(document).off("click", ".updateBtn");
    $(document).off("click", ".archiveLink");
    $(document).off("click", ".updateModeBtn");
    $(document).off("click", ".returnBtn");
    $(document).off("click", ".deleteBtn");
    /** ニュース画面 */
}

/**
 * 共通画面のイベントクリア
 */
function crearCommonEvents() {
    $(document).off("click", "#return_top a");
}

/**
 * TODO: fileload関数でも対応できそうなので、後で考える。
 * 店舗のトップイメージの変更時画像を差し替える処理
 */
function imgDisp() {
    var file = $("#top-image-file").prop("files")[0];

    //画像ファイルかチェック
    if (
        file["type"] != "image/jpeg" &&
        file["type"] != "image/png" &&
        file["type"] != "image/gif"
    ) {
        alert("jpgかpngかgifファイルを選択してください");
        $("#top-image-file").val("");
        return false;
    }

    var fileReader = new FileReader();
    fileReader.onloadend = function () {
        //選択した画像をimg要素に表示
        $("#top-image-show")
            .attr({ width: "100%", height: "300", src: fileReader.result })
            .css({ "background-color": "gray", "object-fit": "contain" });
        $("#top-image-preview").attr("src", fileReader.result);
    };
    fileReader.readAsDataURL(file);
}

/**
 * 誕生日用 datepicker初期化処理
 */
function birthdayPickerIni() {
    $(".birthday-picker").pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 100, // Creates a dropdown of 15 years to control year,
        closeOnSelect: false, // Close upon selecting a date,
        container: undefined, // ex. 'body' will append picker to body
        monthsFull: [
            "1月",
            "2月",
            "3月",
            "4月",
            "5月",
            "6月",
            "7月",
            "8月",
            "9月",
            "10月",
            "11月",
            "12月",
        ],
        monthsShort: [
            "1月",
            "2月",
            "3月",
            "4月",
            "5月",
            "6月",
            "7月",
            "8月",
            "9月",
            "10月",
            "11月",
            "12月",
        ],
        weekdaysFull: [
            "日曜日",
            "月曜日",
            "火曜日",
            "水曜日",
            "木曜日",
            "金曜日",
            "土曜日",
        ],
        weekdaysShort: ["日", "月", "火", "水", "木", "金", "土"],
        weekdaysLetter: ["日", "月", "火", "水", "木", "金", "土"],
        labelMonthNext: "翌月",
        labelMonthPrev: "前月",
        labelMonthSelect: "月を選択",
        labelYearSelect: "年を選択",
        today: "今日",
        clear: "クリア",
        close: "閉じる",
        format: "yyyy-mm-dd",
        min: new Date(1960, 1, 1),
        max: new Date(),
    });
    $(".birthday-picker").pickadate("setDate", new Date());
}

function telme(message, tel) {
    var result = confirm(message);
    if (result == true) {
        location.href = "tel:" + tel;
    }
}

/**
 * HTMLを生成する
 * @param  {} file
 * @param  {} obj
 * @param  {} imgCount
 */
function fileload(file, obj, imgCount, path) {
    var orientation;
    var $html;
    loadImage.parseMetaData(file, (data) => {
        var options = {
            canvas: true,
        };
        if (data.exif) {
            options.orientation = data.exif.get("Orientation");
        }
        loadImage(
            file,
            (canvas) => {
                var dataUri = canvas.toDataURL("image/jpeg");
                // 画像を作成
                var img = new Image();
                img.src = dataUri;
                $.get(path, {}, function (html) {
                    var $dom = $(html);
                    $($dom).addClass("image" + imgCount);
                    $($dom).find(".deleteBtn").remove();
                    $($dom).find("input[name='name']").val(file.name);
                    $($dom).find("img").attr({ src: dataUri });
                    $(obj).append($dom);
                    $(".materialboxed").materialbox();
                    $(".tooltipped").tooltip({ delay: 50 });
                });
            },
            options
        );
    });
}

/**
 * 日記アーカイブの画像をカルーセルに描画する
 * @param  {} obj 対象のセレクター
 * @param  {} selectFiles 選択した画像リスト
 * @param  {} delFlg newタグが付いた画像を削除するか
 */
function canvasRender(obj, selectFiles, delFlg) {
    if (delFlg) {
        $(obj).find(".new").remove();
    } else {
        $(obj).find(".card-img").remove();
    }

    var fileList = $(selectFiles).prop("files");
    var imgCount = $(obj).find(".card-img").length;
    var fimeMax = $("input[name='file_max']").val();
    var modulePath = "/module/materialboxed.ctp";

    $.each(fileList, function (index, file) {
        //画像ファイルかチェック
        if (
            file["type"] != "image/jpeg" &&
            file["type"] != "image/png" &&
            file["type"] != "image/gif"
        ) {
            alert("jpgかpngかgifファイルを選択してください");
            $(selectFiles).val("");
            return false;
        }
    });
    // ファイル数を制限する
    if (fileList.length + imgCount > fimeMax) {
        alert("アップロードできる画像は" + fimeMax + "ファイルまでです。");
        resetBtn(obj, true);
        return;
    }
    for (var i = 0; i < fileList.length; i++) {
        imgCount += 1;
        fileload(
            fileList[i],
            $(obj).find("#content,#modal-content").closest(".row"),
            imgCount,
            modulePath
        );
    }
}

/**
 * 画像フォームリセット リセットボタン処理
 * @param  {} obj 対象のセレクター
 * @param  {} delFlg newタグが付いた画像を削除するか
 */
function resetBtn(obj, delFlg) {
    if (delFlg) {
        $(obj).find(".new").remove();
    } else {
        $(obj).find(".card-img").remove();
    }

    $(obj)
        .find("#image-file")
        .replaceWith($("#image-file").val("").clone(true));
    $(obj)
        .find("#modal-image-file")
        .replaceWith($("#modal-image-file").val("").clone(true));
    $(obj).find("input[name='file_path']").val("");
    $(obj).find("input[name='modal_file_path']").val("");
}

/**
 * モーダル初期化処理
 */
function resetModal() {
    // 通常の表示モードに切り替える。
    $("#modal-diary").find(".updateModeBtn").removeClass("hide");
    $("#modal-diary").find(".returnBtn").addClass("hide");
    $(".modal-edit-diary").addClass("hide");
    $("#view-diary").removeClass("hide");
    $("#modal-diary").find(".updateBtn").addClass("disabled");

    //$(".modal-edit-diary").find('form')[0].reset();
    $(".modal-edit-diary").find("input[name='json_data']").val("");
    $(".modal-edit-diary").find("textarea[name='content']").text("");
    $(".modal-edit-diary").find("textarea").trigger("autoresize");
}

/**
 * 共通バリデーション処理
 */
function formValidete(form) {
    var validete = "";
    var result = false;
    if ($(form).find('input[name="title"]').val().length == 0) {
        validete = "タイトルを入力してください";
    } else if ($(form).find('input[name="title"]').val().length > 50) {
        validete = "タイトルが長すぎです。";
    } else if ($(form).find('textarea[name="content"]').val().length == 0) {
        validete = "内容を入力してください";
    } else if ($(form).find('textarea[name="content"]').val().length > 600) {
        validete = "内容が長すぎです。";
    }
    if (validete.length > 0) {
        alert(validete);
        result = true;
    }
    return result;
}

/**
 * スタッフ画像 削除ボタン処理
 */
function castImageDeleteBtn(form, obj) {
    if (!confirm("削除しますか？")) {
        return false;
    }
    var $form = form;

    //通常のアクションをキャンセルする
    event.preventDefault();

    $.ajax({
        url: $form.attr("action"), //Formのアクションを取得して指定する
        type: $form.attr("method"), //Formのメソッドを取得して指定する
        data: $form.serialize(), //データにFormがserialzeした結果を入れる
        dataType: "html", //データにFormがserialzeした結果を入れる
        timeout: 30000,
        beforeSend: function (xhr, settings) {
            //Buttonを無効にする
            $($form).find(".saveBtn").removeClass("disabled");
            //処理中のを通知するアイコンを表示する
            $("#dummy").load("/module/Preloader.ctp");
        },
        complete: function (xhr, textStatus) {
            //処理中アイコン削除
            $(".preloader-wrapper").remove();
            $($form).find(".saveBtn").addClass("disabled");
            $(".tooltipped").tooltip({ delay: 50 });
        },
        success: function (response, textStatus, xhr) {
            // OKの場合
            if (response) {
                var $objWrapper = $("#wrapper");
                $($objWrapper).replaceWith(response);
                // $.notifyBar({
                //     // cssClass: 'success',
                //     // //html: response.message
                // });
            } else {
                // NGの場合
                $.notifyBar({
                    cssClass: "error",
                    html: response.error,
                });
            }
        },
        error: function (response, textStatus, xhr) {
            $($form).find(".saveBtn").attr("disabled", false);
            $.notifyBar({
                cssClass: "error",
                html: "通信に失敗しました。ステータス：" + textStatus,
            });
        },
    });
}

/**
 * ヘルプモーダル表示処理
 */
var helpModal = function () {
    $("#modal-help").modal({
        ready: function () {
            scrollPosition = $(window).scrollTop();
            // モーダル表示してる時は、背景画面のスクロールを禁止する
            $("body").addClass("fixed").css({ top: -scrollPosition });
        },
        // モーダル非表示完了コールバック
        complete: function () {
            // モーダル非表示した時は、背景画面のスクロールを解除する
            $("body").removeClass("fixed").css({ top: 0 });
            window.scrollTo(0, scrollPosition);
            $(".modal-content.help").animate({ scrollTop: 0 }, 1000);
            $(".modal-trigger.edit-help").each(function (i, el) {
                whichHelp = $(el).attr("data-help");
                $(".collapsible.help").collapsible("close", whichHelp);
            });
        },
    });
    $(".collapsible.help").collapsible();
    var whichHelp, target, targetP, scrollP, position;
    // ヘルプをクリックした時
    $(document).on("click", ".modal-trigger.edit-help", function (e) {
        e.preventDefault();
        whichHelp = $(this).attr("data-help");
        $(".collapsible.help").collapsible("open", whichHelp);
        targetP = $("#section" + whichHelp).position();
        scrollH = $(".modal-content.help").scrollTop();
        position = targetP.top + scrollH;
        $(".modal-content.help").animate(
            {
                scrollTop: position,
            },
            400
        );
    });
};

// common initialize
function initialize() {
    /* 共通初期化処理 START */
    // materializecss sideNav サイドバーの初期化
    $("nav.nav-header-menu .button-collapse").sideNav({
        menuWidth: 300,
        edge: "left",
        closeOnClick: false,
        draggable: true,
        onOpen: function (el) {
            // 開いたときの処理
        },
        onClose: function (el) {
            // 閉じたときの処理
        },
    });

    $(".slider").slider();
    // materializecss selectbox
    $("select").material_select();
    $(".materialboxed").materialbox();
    $(".scrollspy").scrollSpy();
    $(".collapsible").collapsible();
    Materialize.updateTextFields();
    $("input, textarea").characterCounter();

    // materializecss Chips
    $(document).find(".chips").material_chip();
    // materializecss Chips 追加イベント
    $(".chips").on("chip.add", function (e, chip) {
        console.log(this);
        //alert("chip.add");
    });
    // materializecss Chips 削除イベント
    $(".chips").on("chip.delete", function (e, chip) {
        //alert("chip.delete");
    });
    // materializecss Chips 選択イベント
    $(".chips").on("chip.select", function (e, chip) {
        console.log(this);
        //alert("chip.select");
    });
    // nav {
    //     background-color: rgba(0, 0, 0, 0.55);
    //     color: #fff;
    //     /* background-color: #3e3e3e; */
    // }

    $(function () {
        /** 下にスクロールでヘッダー非表示・上にスクロールでヘッダー表示 */
        var $win = $(window),
            $header = $("#nav-header-menu"),
            headerHeight = $header.outerHeight(),
            startPos = 0;

        $($win).on("load scroll", function () {
            var value = $(this).scrollTop();
            if (value > startPos && value > headerHeight) {
                $header.css("top", "-" + headerHeight + "px");
            } else {
                $header.css("top", "0");
            }
            // ヘッダーを半透明にするかしないか
            if (value == 0) {
                $("nav").removeClass("nav-opacity");
            } else {
                $("nav").addClass("nav-opacity");
            }
            startPos = value;
        });

        // ローディング終了後、画面をフェードイン
        // Pace.on('done', function(){
        //     $('.wrap').fadeIn();
        // });
    });

    // show return top button
    $(function () {
        var topBtn = $("#return_top");
        $(window).scroll(function () {
            var scrTop = $(this).scrollTop();
            if (scrTop > 100) {
                topBtn.stop().fadeIn("slow");
            } else {
                topBtn.stop().fadeOut();
            }
        });
        // click return top
        $(document).on("click", "#return_top a", function () {
            $("html,body").animate({ scrollTop: 0 }, 1000, "easeOutExpo");
            return false;
        });
        // ボトムナビゲーションのreturn top
        // $(document).on('click','#bottom-nav-return_top a',function() {
        //     $('html,body').animate({scrollTop : 0}, 1000, 'easeOutExpo');
        //     return false;
        // });
    });

    // スマートフォン以外の電話タップを無効にする
    $(function () {
        var ua = navigator.userAgent.toLowerCase();
        var isMobile = /iphone/.test(ua) || /android(.+)?mobile/.test(ua);
        if (!isMobile) {
            $('a[href^="tel:"]').on("click", function (e) {
                e.preventDefault();
            });
        }
    });

    // TODO: ピッカー系がgoogle chomeブラウザで不具合が出てるっぽい。2019/03/28時点
    // 症状は、クリックしても一瞬表示されるだけ。現時点の解決策としては<label>タグを付与することで表示される
    /* 店舗編集のスクリプト クーポン materializecss Date Picker */
    $(".datepicker").pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        closeOnSelect: false, // Close upon selecting a date,
        container: undefined, // ex. 'body' will append picker to body
        monthsFull: [
            "1月",
            "2月",
            "3月",
            "4月",
            "5月",
            "6月",
            "7月",
            "8月",
            "9月",
            "10月",
            "11月",
            "12月",
        ],
        monthsShort: [
            "1月",
            "2月",
            "3月",
            "4月",
            "5月",
            "6月",
            "7月",
            "8月",
            "9月",
            "10月",
            "11月",
            "12月",
        ],
        weekdaysFull: [
            "日曜日",
            "月曜日",
            "火曜日",
            "水曜日",
            "木曜日",
            "金曜日",
            "土曜日",
        ],
        weekdaysShort: ["日", "月", "火", "水", "木", "金", "土"],
        weekdaysLetter: ["日", "月", "火", "水", "木", "金", "土"],
        labelMonthNext: "翌月",
        labelMonthPrev: "前月",
        labelMonthSelect: "月を選択",
        labelYearSelect: "年を選択",
        today: "今日",
        clear: "クリア",
        close: "閉じる",
        format: "yyyy-mm-dd",
    });
    $(".datepicker").pickadate("setDate", new Date());

    $(".timepicker").pickatime({
        default: "now", // Set default time: 'now', '1:30AM', '16:30'
        fromnow: 0, // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: "OK", // text for done-button
        cleartext: "クリア", // text for clear-button
        canceltext: "キャンセル", // Text for cancel-button,
        container: undefined, // ex. 'body' will append picker to body
        autoclose: false, // automatic close timepicker
        ampmclickable: true, // make AM PM clickable
        aftershow: function () {}, //Function for after opening timepicker
    });

    // PhotoSwipeを起動する
    initPhotoSwipeFromDOM(".my-gallery");
    /* 共通処理 END */
}

/**
 * ユーザー画面の初期化処理
 */
function initializeUser() {

    // いいね、口コミボタン押した時
    $(document).on("click", ".favo_click", function () {
        // アニメーションする
        $(this).addClass('purupuru');
        $(this).delay(800).queue(function () {
            $(this).removeClass('purupuru').dequeue();
        });
        var data = $(this).data();
        var count_elm = null;
        // お気に入りか、口コミか
        if ($(this).closest('.favorite').length > 0) {
            count_elm = $(this).closest('.favorite').find(".count");
        } else if ($(this).closest('.voice').length > 0) {
            count_elm = $(this).closest('.voice').find(".count");
        }
        var status = 1; // クリック状態初期値

        // お気に入り追加
        if ($(this).hasClass('grey')) {
            $(count_elm).text(Number($(count_elm).text()) + 1);
        } else {
            if (Number($(count_elm).text()) != 0) {
                $(count_elm).text(Number($(count_elm).text()) - 1);
                status = 0;
            }
        }
        // お気に入りボタンカラー切り替え
        $(this).toggleClass('grey');
        $(this).toggleClass('red');

        data.status = status;
        data.action = "/user/users/favorite_click";

        $.ajax({
            type: "POST",
            datatype: "JSON",
            url: data.action,
            data: data,
            timeout: 30000,
            beforeSend: function (xhr, settings) {
                $(this).attr("disabled", true);
            },
            complete: function (xhr, textStatus) {
                $(this).attr("disabled", false);
            },
            success: function (response, dataType) {
                // OKの場合
                if (response.success) {
                    Materialize.toast(
                        response.message,
                        3000,
                        "rounded"
                    );
                } else {
                    // NGの場合
                    Materialize.toast(
                        response.message,
                        3000,
                        "rounded"
                    );
                }
            },
            error: function (response, textStatus, xhr) {
                $(this).attr("disabled", false);
                $.notifyBar({
                    cssClass: "error",
                    html: "通信に失敗しました。ステータス：" + textStatus,
                });
            },
        });
    });

    // レビュー送信ボタン押した時
    $(document).on("click", ".review_send", function () {
        // ボタン
        $btn = $(this);
        //ボタン無効化
        $btn.addClass("disabled");
        var flag = true;
        var form = $('#review-form');
        // 各値を入れるオブジェクト
        var data= new Object();
        data['id'] = Number(form.find('input[name="shop_id"]').val());
        data['cost'] = form.find('div[name="cost"]').data("rateitValue");
        data['atmosphere'] = form.find('div[name="atmosphere"]').data("rateitValue");
        data['customer'] = form.find('div[name="customer"]').data("rateitValue");
        data['staff'] = form.find('div[name="staff"]').data("rateitValue");
        data['cleanliness'] = form.find('div[name="cleanliness"]').data("rateitValue");
        data['comment'] = form.find('textarea[name="comment"]').val();
        $.each(data, function(index, value) {
            console.log(index + ': ' + value);
            if (value === 0) {
                alert("☆は１個以上選択してください。");
                //ボタン有効化
                $btn.removeClass("disabled");
                flag = false;
            }
            var input = $("<input>")
                .attr({"type": "hidden","name": index, 'value':value});
            form.append(input);
        })
        //通常のアクションをキャンセルする
        event.preventDefault();
        if (!flag) {
            return false;
        }
        form.submit();
    });

     // レビューをもっと見るボタン押した時
     $(document).on("click", ".see_more_reviews", function () {

        var data = $(this).data();
        data['now_count'] = $('.other-review-section__ul__li').length
        $.ajax({
            type: "POST",
            datatype: "JSON",
            url: data.action,
            data: data,
            timeout: 30000,
            beforeSend: function (xhr, settings) {
                //Buttonを無効にする
                //処理中のを通知するアイコンを表示する
                $("#dummy").load("/module/Preloader.ctp");
            },
            complete: function (xhr, textStatus) {
                //処理中アイコン削除
                $(".preloader-wrapper").remove();
            },
            success: function (response, textStatus, xhr) {
                // OKの場合
                if (response.success) {
                    if (response.html != null) {
                        $(response.html).appendTo('.other-review-section__ul');
                        $('div.rateit').rateit();
                    } else {
                        $('.see_more_reviews').remove();
                        $('.review-more-btn-section').html('<p>すべて表示しました。</p>');
                    }
                    var count = $('.other-review-section__ul__li').length;
                    $('.paging').text(count + '/' + response.all_favo);
                }
            },
            error: function (response, textStatus, xhr) {
                $.notifyBar({
                    cssClass: "error",
                    html: "データ取得に失敗しました。"
                });
            },
        });
    });

     // お気に入りをもっと見るボタン押した時
     $(document).on("click", ".see_more_favos", function () {

        var data = $(this).data();
        data['now_count'] = $('.favo-list-section__ul__li').length
        $.ajax({
            type: "POST",
            datatype: "JSON",
            url: data.action,
            data: data,
            timeout: 30000,
            beforeSend: function (xhr, settings) {
                //Buttonを無効にする
                //処理中のを通知するアイコンを表示する
                $("#dummy").load("/module/Preloader.ctp");
            },
            complete: function (xhr, textStatus) {
                //処理中アイコン削除
                $(".preloader-wrapper").remove();
            },
            success: function (response, textStatus, xhr) {
                // OKの場合
                if (response.success) {
                    if (response.html != null) {
                        $(response.html).appendTo('.favo-list-section__ul');
                    } else {
                        $('.see_more_favos').remove();
                        $('.favo-more-btn-section').html('<p>すべて表示しました。</p>');
                    }
                    var count = $('.favo-list-section__ul__li').length;
                    $('.paging').text(count + '/' + response.all_favo);
                }
            },
            error: function (response, textStatus, xhr) {
                $.notifyBar({
                    cssClass: "error",
                    html: "データ取得に失敗しました。"
                });
            },
        });
    });

    // 通常モーダルの初期化処理(個別に設定する場合は、この処理の下に再初期化すること)
    $(".modal").modal({
        ready: function () {
            scrollPosition = $(window).scrollTop();
            // モーダル表示してる時は、背景画面のスクロールを禁止する
            $("body").addClass("fixed").css({ top: -scrollPosition });
        },
        // モーダル非表示完了コールバック
        complete: function () {
            // モーダル非表示した時は、背景画面のスクロールを解除する
            $("body").removeClass("fixed").css({ top: 0 });
            window.scrollTo(0, scrollPosition);
        },
    });

    // ユーザーの初期化処理
    var x = $(window).width();
    var y = 600;
    if (x <= y) {
        $(".search-result-card").removeClass("horizontal");
    } else {
        $(".search-result-card").addClass("horizontal");
    }

    $(window).resize(function () {
        //windowの幅をxに代入
        var x = $(window).width();
        //windowの分岐幅をyに代入
        var y = 600;
        if (x <= y) {
            $(".search-result-card").removeClass("horizontal");
        } else {
            $(".search-result-card").addClass("horizontal");
        }
    });
    $(".marquee").marquee({
        yScroll: "top", // 初期位置(topかbottom)
        showSpeed: 250, // ドロップダウンの速度
        scrollSpeed: 6, // スクロールの速度
        pauseSpeed: 1000, // 次のメッセージに進むかスクロールに移るまでの時間
        pauseOnHover: true, // マウスオーバーで停止するかどうか
        loop: -1, // 繰り返し回数(負の値にすると無限回)
        fxEasingShow: "swing", // ドロップダウンのときのイージング
        fxEasingScroll: "linear",
        // 初期時
        // , init: function ($marquee, options){
        //     if( $marquee.is("#marquee2") ) options.yScroll = "bottom";
        // }
        // メッセージ切替表示前
        beforeshow: function ($marquee, $li) {
            var $author = $li.find(".author");
            if ($author.length) {
                $("#marquee-author")
                    .html(
                        "<span style='display:none;'>" +
                            $author.html() +
                            "</span>"
                    )
                    .find("> span")
                    .fadeIn(850);
            }
        },
        // メッセージ表示切替時（上から下にスライド表示された時）
        show: function () {},
        // メッセージスクロール完了後（スライド表示されたメッセージが左方向へすべてスクロールされた時）
        aftershow: function ($marquee, $li) {
            // find the author
            var $author = $li.find(".author");
            // hide the author
            if ($author.length)
                $("#marquee-author").find("> span").fadeOut(250);
        },
    });

    // TODO: ユーザーのログイン機能実装時に解除する
    $("#modal-login").modal({
        ready: function () {
            $("#modal-login").css('z-index','9999');
            //this.close();
        },
        // モーダル非表示完了コールバック
        complete: function () {
            // alert("complete");
        },
    });

    // TODO: ユーザーのログイン機能実装時に解除する
    $("#modal-review").modal({
        ready: function () {
            $("#modal-review").css('z-index','9999');
            //this.close();
        },
        // モーダル非表示完了コールバック
        complete: function () {
            // alert("complete");
        },
    });

    /* トップ画面 START */
    if ($("#top").length) {
        // 検索ボタン押した時
        commonSearch(false);

        var options = {
            //'swipeable':true, // モバイル時のスワイプでタブ切り替え
            //'responsiveThreshold':991,
            onShow: function () {
                // タブ切り替え時のコールバック
            },
        };
        $("ul.tabs").tabs(options);
    }
    /* トップ画面 END */
    /* ニュース画面 START */
    if ($("#news").length) {
        // 検索ボタン押した時
        commonSearch(false);
    }
    /* ニュース画面 END */
    /* エリア画面 START */
    if ($("#area").length) {
        // 検索ボタン押した時
        commonSearch(false);
    }
    /* エリア画面 END */

    /* unknow画面 START */
    if ($("#unknow").length) {
        // 検索ボタン押した時
        commonSearch(false);
    }
    /* unknow画面 END */

    /* ジャンル画面 START */
    if ($("#genre").length) {
        // 検索ボタン押した時
        commonSearch(false);
    }
    /* ジャンル画面 END */

    /* 検索画面 START */
    if ($("#search").length) {
        // 検索ボタン押した時
        commonSearch(true);
    }
    /* 検索画面 画面 END */

    /* 店舗画面 START */
    if ($("#shop").length) {
        // 検索ボタン押した時
        commonSearch(false);
        // 店舗住所取得
        var address = $("table td[name='address']").text();
        // Googleマップ初期化処理
        googlemap_init("google_map", address);
    }
    /* 店舗画面 END */
    /* レビュー画面 START */
    if ($("#review").length) {
        // 検索ボタン押した時
        commonSearch(false);
        // 店舗住所取得
        var address = $("table td[name='address']").text();
    }
    /* レビュー画面 END */
    /* スタッフ画面 START */
    if ($("#cast").length) {
        // 検索ボタン押した時
        commonSearch(false);
        // 店舗住所取得
        var address = $("table td[name='address']").text();
    }
    /* スタッフ画面 END */

    /* ギャラリー画面 START */
    if ($("#gallery").length) {
        // 検索ボタン押した時
        commonSearch(false);
    }
    /* ギャラリー画面 END */

    /* 日記画面 START */
    if ($("#diary").length) {
        // 検索ボタン押した時
        commonSearch(false);

        // アーカイブ日記をクリックした時
        $(document).on("click", ".archiveLink", function () {
            var $form = $("#view-archive-diary");
            $($form)
                .find("input[name='diary_id']")
                .val($(this).find("input[name='diary_id']").val());
            //通常のアクションをキャンセルする
            event.preventDefault();
            callModalDiaryWithAjax($form , $(this), "user");
            $(".materialboxed").materialbox();
        });
    }
    /* 日記画面 END */

    /* お知らせ画面 START */
    if ($("#notice").length) {
        // 検索ボタン押した時
        commonSearch(false);

        // アーカイブお知らせをクリックした時
        $(document).on("click", ".archiveLink", function () {
            var $form = $("#view-archive-notice");
            $($form)
                .find("input[name='notice_id']")
                .val($(this).find("input[name='notice_id']").val());
            //$($form).find("input[name='id']").val($(this).find("input[name='id']").val());
            //通常のアクションをキャンセルする
            event.preventDefault();
            callModalNoticeWithAjax($form, $(this), "user");
            $(".materialboxed").materialbox();
        });
    }
    /* お知らせ画面 END */
    /* ユーザー管理画面 START */
    if ($("#user").length) {

        // 検索ボタン押した時
        commonSearch(false);

        /* プロフィール 画面 START */
        if ($("#profile").length) {
            var $profile = $("#profile");

            // 画像を選択した時
            $(document).on("change", "#image-file", function () {
                var $form = $(this).closest("form");
                var file = this.files[0];
                var img = new Image();
                loadImage.parseMetaData(file, (data) => {
                    var options = {
                        canvas: true,
                    };
                    if (data.exif) {
                        options.orientation = data.exif.get("Orientation");
                    }
                    loadImage(
                        file,
                        (canvas) => {
                            var dataUri = canvas.toDataURL("image/jpeg");

                            img.src = dataUri;
                            $(document).find("img").attr({ src: dataUri });
                        },
                        options
                    );
                    // 画像が読み込まれてから処理
                    img.onload = function () {
                        // IMGのセレクタ取得
                        var $selecter = $(document).find("img");
                        // ファイル変換
                        var blobList = fileConvert("#image-canvas", $selecter);

                        // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                        // POSTでリクエスト内のデータが全部なくなるので。
                        // TODO: 後で対策を考えよう
                        $($form).find("#image-file, .file-path").val("");

                        // アップロード用blobをformDataに設定
                        var formData = new FormData($form.get()[0]);
                        formData.append("image", blobList[0]);

                        //通常のアクションをキャンセルする
                        event.preventDefault();
                        fileUpAjaxCommon($form, formData, $("#wrapper"));
                    };
                });
            });
            // 入力フォームに変更があった時
            $(document)
                .find($profile)
                .on("input", function () {
                    $($profile).find(".saveBtn").removeClass("disabled");
                });
            // リストボックスを変更した時
            $(document).on("change", "select", function () {
                $($profile).find(".saveBtn").removeClass("disabled");
            });
            // 登録ボタン押した時
            $($profile)
                .find(".saveBtn")
                .on("click", function () {
                    if (!confirm("こちらのプロフィール内容でよろしいですか？")) {
                        return false;
                    }
                    var $form = $("#save-profile");

                    //通常のアクションをキャンセルする
                    event.preventDefault();
                    ajaxCommon($form, $("#wrapper"));
                });
        }
        /* プロフィール 画面 END */
    }

    /* お気に入り 画面 START */
    if ($("#myfavo").length) {

        // 検索ボタン押した時
        commonSearch(false);
    }
    /* お気に入り 画面 END */

    /* ユーザー管理画面 END */

}

/**
 * 検索ボタン押下時の処理
 * @param  {boolean} isAjax
 */
function commonSearch(isAjax) {
    $(document).on("click", ".searchBtn", function () {
        form = $(this).closest($("#modal-search")).find(".search-form");
        // トップか検索画面からの検索は下のセレクタで取得
        if (form.length == 0) {
            form = $(this).closest($(".search-form"));
        }
        if (
            form.find("input[name='key_word']").val() == "" &&
            form.find("[name='area']").val() == "" &&
            form.find("[name='genre']").val() == ""
        ) {
            alert("条件を入力してください。");
            return false;
        }
        // AJAX送信
        if (isAjax) {
            //通常のアクションをキャンセルする
            event.preventDefault();
            searchAjax("#search-result", form);
        } else {
            // POST送信
            form.submit();
        }
    });
}
/**
 * オーナー画面の初期化処理
 */
function initializeOwner() {
    // 通常モーダルの初期化処理(個別に設定する場合は、この処理の下に再初期化すること)
    $(".modal").modal({
        ready: function () {
            scrollPosition = $(window).scrollTop();
            // モーダル表示してる時は、背景画面のスクロールを禁止する
            $("body").addClass("fixed").css({ top: -scrollPosition });
        },
        // モーダル非表示完了コールバック
        complete: function () {
            // モーダル非表示した時は、背景画面のスクロールを解除する
            $("body").removeClass("fixed").css({ top: 0 });
            window.scrollTo(0, scrollPosition);
        },
    });

    /* ダッシュボード 画面 START */
    if ($("#dashbord").length) {
        /* スタッフ スイッチ押した時 */
        $(document).on("change", ".shop-switchBtn", function () {
            var target = $(this).closest(".shop-box");
            var json = JSON.parse(
                $(target).find('input[name="json_data"]').val()
            );
            var status = 1; // チェック状態初期値
            // チェックされてない場合
            if (!$(this).prop("checked")) {
                status = 0;
            }
            var data = {
                id: json.id,
                status: status,
                action: "/owner/owners/switch_shop",
            };

            $.ajax({
                type: "POST",
                datatype: "JSON",
                url: data.action,
                data: data,
                timeout: 30000,
                beforeSend: function (xhr, settings) {
                    $("#dashbord").find(".shop-switchBtn").attr("disabled", true);
                },
                complete: function (xhr, textStatus) {
                    $("#dashbord").find(".shop-switchBtn").attr("disabled", false);
                },
                success: function (response, dataType) {
                    // OKの場合
                    if (response.success) {
                        Materialize.toast(
                            $(target).find(".shop-num").text() +
                                response.message,
                            3000,
                            "rounded"
                        );
                    } else {
                        // NGの場合
                        Materialize.toast(
                            $(target).find(".shop-num").text() +
                                response.message,
                            3000,
                            "rounded"
                        );
                    }
                },
                error: function (response, textStatus, xhr) {
                    $("#dashbord").find(".shop-switchBtn").attr("disabled", false);
                    $.notifyBar({
                        cssClass: "error",
                        html: "通信に失敗しました。ステータス：" + textStatus,
                    });
                },
            });
        });
    }
    /* ダッシュボード 画面 END */

    /* プロフィール 画面 START */
    if ($("#profile").length) {
        var $profile = $("#profile");

        // 画像を選択した時
        $(document).on("change", "#image-file", function () {
            var $form = $(this).closest("form");
            var file = this.files[0];
            var img = new Image();
            loadImage.parseMetaData(file, (data) => {
                var options = {
                    canvas: true,
                };
                if (data.exif) {
                    options.orientation = data.exif.get("Orientation");
                }
                loadImage(
                    file,
                    (canvas) => {
                        var dataUri = canvas.toDataURL("image/jpeg");

                        img.src = dataUri;
                        $(document).find("img").attr({ src: dataUri });
                    },
                    options
                );
                // 画像が読み込まれてから処理
                img.onload = function () {
                    // IMGのセレクタ取得
                    var $selecter = $(document).find("img");
                    // ファイル変換
                    var blobList = fileConvert("#image-canvas", $selecter);

                    // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                    // POSTでリクエスト内のデータが全部なくなるので。
                    // TODO: 後で対策を考えよう
                    $($form).find("#image-file, .file-path").val("");

                    // アップロード用blobをformDataに設定
                    var formData = new FormData($form.get()[0]);
                    formData.append("image", blobList[0]);

                    //通常のアクションをキャンセルする
                    event.preventDefault();
                    fileUpAjaxCommon($form, formData, $("#wrapper"));
                };
            });
        });
        // 入力フォームに変更があった時
        $(document)
            .find($profile)
            .on("input", function () {
                $($profile).find(".saveBtn").removeClass("disabled");
            });
        // リストボックスを変更した時
        $(document).on("change", "select", function () {
            $($profile).find(".saveBtn").removeClass("disabled");
        });
        // 登録ボタン押した時
        $($profile)
            .find(".saveBtn")
            .on("click", function () {
                if (!confirm("こちらのプロフィール内容でよろしいですか？")) {
                    return false;
                }
                var $form = $("#save-profile");

                //通常のアクションをキャンセルする
                event.preventDefault();
                ajaxCommon($form, $("#wrapper"));
            });
    }
    // /* プロフィール 画面 END */

    /* プラン変更 画面 START */
    if ($("#change-plan").length) {
        /**
         * 全てのボタンを無効化する
         */
        $("form").submit(function () {
            var message = $(this).find('input[name="message"]').val();
            var result = confirm(message);
            if (result) {
                $('button[type="submit"]').prop("disabled", true);
                return true;
            }
            return false;
        });
    }
    /* プラン変更 画面 END */
}

/**
 * ショップ画面の初期化処理
 */
function initializeShop() {
    // 通常モーダルの初期化処理(個別に設定する場合は、この処理の下に再初期化すること)
    $(".modal").modal({
        ready: function () {
            scrollPosition = $(window).scrollTop();
            // モーダル表示してる時は、背景画面のスクロールを禁止する
            $("body").addClass("fixed").css({ top: -scrollPosition });
        },
        // モーダル非表示完了コールバック
        complete: function () {
            // モーダル非表示した時は、背景画面のスクロールを解除する
            $("body").removeClass("fixed").css({ top: 0 });
            window.scrollTo(0, scrollPosition);
        },
    });

    // ヘルプモーダルの初期化処理
    helpModal();

    /* 店舗情報 画面 START */
    if ($("#shop-edit").length) {
        // 店舗編集のスクリプト 店舗情報 クレジットフォームを入力不可にする
        $($("#tenpo").find('div[name="credit"]'))
            .find("input")
            .prop("disabled", true);

        /* サイドメニュータブ 関連処理 START */
        // タブメニューボタン押した時
        $(document).on("click", ".tab-click", function () {
            var tab = $(this).data("tab");
            $("ul.tabs").tabs("select_tab", tab);
            // 左にスクロールするか判定する
            var isLeft =
                tab == "top-image" || tab == "catch" || tab == "coupon"
                    ? true
                    : false;
            if (isLeft) {
                $("ul.tabs").animate({
                    scrollLeft: $("ul.tabs").offset(),
                });
                return;
            }
            $("ul.tabs").animate({
                scrollLeft: $("#" + tab).offset().top,
            });
        });
        // 他の画面でタブメニューが押された場合
        if ($("#select_tab")) {
            var tab = $("#select_tab").val();
            $('[data-tab="' + tab + '"]').trigger("click");
        }
        /* サイドメニュータブ 関連処理 END */

        /* トップ画像 関連処理 START */
        // トップ画像 変更、やめるボタン押した時
        $(document).on("click", ".top-image-changeBtn", function () {
            // 画像をクリアする
            $("#top-image")
                .find("#top-image-show")
                .attr({ width: "", height: "", src: "" });
            $("#top-image").find('[name="top_image"]').val("");

            // 編集フォームが表示されている場合
            if ($("#save-top-image").css("display") == "block") {
                // ビュー表示
                $("#top-image").find("#save-top-image").hide();
                $("#top-image").find("#show-top-image").show();
            } else {
                // 編集表示
                $("#top-image").find("#save-top-image").show();
                $("#top-image").find("#show-top-image").hide();
            }
        });
        // トップ画像 登録ボタン押した時
        $(document).on("click", ".top-image-saveBtn", function () {
            //ファイル選択済みかチェック
            var fileCheck = $("#top-image-file").val().length;
            if (fileCheck === 0) {
                alert("画像ファイルを選択してください");
                return false;
            }
            if (!confirm("こちらの画像に変更でよろしいですか？")) {
                return false;
            }

            var $form = $("#save-top-image");

            // blobファイル変換
            var blobList = fileConvert(
                "#top-image-canvas",
                ".top-image-preview"
            );

            // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
            // POSTでリクエスト内のデータが全部なくなるので。
            // TODO: 後で対策を考えよう
            $($form).find('input[name="top_image_file"]').val("");

            // アップロード用blobをformDataに設定
            var formData = new FormData($form.get()[0]);
            formData.append("top_image_file", blobList[0]);
            for (item of formData) {
                console.log(item);
            }
            //通常のアクションをキャンセルする
            event.preventDefault();
            fileUpAjaxCommon($form, formData, $("#top-image"));
        });

        /* トップ画像 関連処理 END */

        /* キャッチコピー 関連処理 START */
        // キャッチコピー 変更、やめるボタン押した時
        $(document).on("click", ".catch-changeBtn", function () {
            // 編集フォームが表示されている場合
            if ($("#save-catch").css("display") == "block") {
                // $(obj).find('[name="catch"]').val(""); //初期値を削除しない
                $("#catch").find("#save-catch").hide();
                $("#catch").find("#show-catch").show();
            } else {
                // catchという変数にしたかったがcatchはjsで予約語になる
                var json = JSON.parse(
                    $("#catch").find('input[name="json_data"]').val()
                );
                $("#catch").find('textarea[name="catch"]').val(json["catch"]);
                $("#catch").find("#save-catch").show();
                $("#catch").find("#show-catch").hide();
                $("textarea").trigger("autoresize");
                Materialize.updateTextFields(); // インプットフィールドの初期化
            }
        });

        // キャッチコピー 登録ボタン押した時
        $(document).on("click", ".catch-saveBtn", function () {
            var $form = $("#save-catch");
            if ($form.find('textarea[name="catch"]').val() == "") {
                alert("キャッチコピーを入力してください。");
                return false;
            }
            if (!confirm("キャッチコピーを変更してもよろしいですか？")) {
                return false;
            }

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#catch"));
        });

        // キャッチコピー 削除ボタン押した時
        $(document).on("click", ".catch-deleteBtn", function () {
            if (!confirm("キャッチコピーを削除してもよろしいですか？")) {
                return false;
            }
            var json = JSON.parse(
                $("#catch").find('input[name="json_data"]').val()
            );
            $("#catch").find('input[name="id"]').val(json["id"]);

            var $form = $("#delete-catch");

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#catch"));
        });
        /* キャッチコピー 関連処理 END */

        /* クーポン 関連処理 START */
        // クーポン 変更、やめるボタン押した時
        $(document).on("click", ".coupon-changeBtn", function () {
            $("html,body").animate({ scrollTop: 0 });

            if ($("#save-coupon").css("display") == "block") {
                // $(obj).find('[name="coupon"]').val(""); //初期値を削除しない
                $("#coupon").find("#save-coupon").hide();
                $("#coupon").find("#show-coupon").show();
            } else {
                // コントローラ側で処理判断するパラメータ
                $('input[name="crud_type"]').val("update");

                var checked = $('input[name="check_coupon"]:checked');
                var json = JSON.parse(
                    $(checked)
                        .closest(".coupon-box")
                        .find('input[name="json_data"]')
                        .val()
                );
                var from = $("#from-day").pickadate("picker"); // Date Picker
                var to = $("#to-day").pickadate("picker"); // Date Picker
                from.set("select", [2000, 1, 1]);
                from.set("select", new Date(2000, 1, 1));
                from.set("select", json["from_day"], { format: "yyyy-mm-dd" });
                to.set("select", [2000, 1, 1]);
                to.set("select", new Date(2000, 1, 1));
                to.set("select", json["to_day"], { format: "yyyy-mm-dd" });
                $("#coupon").find('input[name="id"]').val(json["id"]);
                $("#coupon").find('input[name="title"]').val(json["title"]);
                $("#coupon")
                    .find('textarea[name="content"]')
                    .val(json["content"]);
                if (json["status"] == 1) {
                    $('input[name="status"]').attr("checked", "checked");
                }
                $("#coupon").find("#save-coupon").show();
                $("#coupon").find("#show-coupon").hide();
                $("textarea").trigger("autoresize");
                Materialize.updateTextFields(); // インプットフィールドの初期化
            }
        });

        // クーポン 追加ボタン押した時
        $(document).on("click", ".coupon-addBtn", function () {
            if ($("#save-coupon").css("display") == "block") {
                // $(obj).find('[name="coupon"]').val(""); //初期値を削除しない
                $("#coupon").find("#save-coupon").hide();
                $("#coupon").find("#show-coupon").show();
            } else {
                $("html,body").animate({ scrollTop: 0 });
                // フォームの中身はすべて消す
                $("#coupon").find('input[name="id"]').val("");
                $("#coupon")
                    .find("#from-day")
                    .pickadate("picker")
                    .set("select", null);
                $("#coupon")
                    .find("#to-day")
                    .pickadate("picker")
                    .set("select", null);
                $("#coupon").find("#coupon-title").val("");
                $("#coupon").find("#coupon-content").val("");
                // コントローラ側で処理判断するパラメータ
                $('input[name="crud_type"]').val("insert");
                $("#save-coupon").find("button").removeClass("disabled");
                $("#coupon").find("#save-coupon").show();
                $("#coupon").find("#show-coupon").hide();
            }
        });

        // クーポン 登録ボタン押した時
        $(document).on("click", ".coupon-saveBtn", function () {
            if (!confirm("こちらの内容に変更でよろしいですか？")) {
                return false;
            }

            var $form = $('form[name="save_coupon"]');
            var from_day = $($form).find('input[name="from_day_submit"]').val();
            var to_day = $($form).find('input[name="to_day_submit"]').val();
            $($form).find('input[name="from_day"]').val(from_day);
            $($form).find('input[name="to_day"]').val(to_day);

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#coupon"));
        });

        /* クーポン チェックボックス押した時 */
        $(document).on("click", ".check-coupon-group", function () {
            var $button = $("#coupon").find(
                ".coupon-changeBtn,.coupon-deleteBtn"
            );
            var $addButton = $("#coupon").find(".coupon-addBtn");

            if ($(this).prop("checked")) {
                $("html,body").animate(
                    { scrollTop: $(".coupon-Scroll").offset().top },
                    1200
                );
                // 一旦全てをクリアして再チェックする
                $(".check-coupon-group").prop("checked", false);
                $(this).prop("checked", true);
                $($button).removeClass("disabled");
                $($addButton).addClass("disabled");
            } else {
                $($button).addClass("disabled");
                $($addButton).removeClass("disabled");
            }
        });

        /* クーポン スイッチ押した時 */
        $(document).on("change", ".coupon-switchBtn", function () {
            var target = $(this).closest(".coupon-box");
            var json = JSON.parse(
                $(target).find('input[name="json_data"]').val()
            );
            var status = 1; // チェック状態初期値
            // チェックされてない場合
            if (!$(this).prop("checked")) {
                status = 0;
            }
            var data = {
                id: json.id,
                status: status,
                action: "/owner/shops/switch_coupon",
            };

            $.ajax({
                type: "POST",
                datatype: "json",
                url: data.action,
                data: data,
                timeout: 30000,
                beforeSend: function (xhr, settings) {
                    $("#coupon")
                        .find(".coupon-switchBtn")
                        .attr("disabled", true);
                },
                complete: function (xhr, textStatus) {
                    $("#coupon")
                        .find(".coupon-switchBtn")
                        .attr("disabled", false);
                },
                success: function (response, dataType) {
                    // OKの場合
                    if (response.success) {
                        Materialize.toast(
                            $(target).find(".coupon-num").text() +
                                response.message,
                            3000,
                            "rounded"
                        );
                    } else {
                        // NGの場合
                        Materialize.toast(
                            $(target).find(".coupon-num").text() +
                                response.message,
                            3000,
                            "rounded"
                        );
                    }
                },
                error: function (response, textStatus, xhr) {
                    $("#coupon")
                        .find(".coupon-switchBtn")
                        .attr("disabled", false);
                    $.notifyBar({
                        cssClass: "error",
                        html: "通信に失敗しました。ステータス：" + textStatus,
                    });
                },
            });
        });

        // クーポン 削除ボタン押した時
        $(document).on("click", ".coupon-deleteBtn", function () {
            var checked = $('input[name="check_coupon"]:checked');
            var json = JSON.parse(
                $(checked)
                    .closest(".coupon-box")
                    .find('input[name="json_data"]')
                    .val()
            );

            if (
                !confirm(
                    "【" +
                        json.title +
                        "】\n選択したクーポンを削除してもよろしいですか？"
                )
            ) {
                return false;
            }
            var $form = $('form[id="delete-coupon"]');
            $($form).find("input[name='id']").val(json.id);

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#coupon"));
        });
        /* クーポン 関連処理 END */

        /* スタッフ 関連処理 START */
        // スタッフ 変更、やめるボタン押した時
        $(document).on("click", ".cast-changeBtn", function () {
            $("html,body").animate({ scrollTop: 0 });

            if ($("#save-cast").css("display") == "block") {
                // $(obj).find('[name="cast"]').val(""); //初期値を削除しない
                $("#cast").find("#save-cast").hide();
                $("#cast").find("#show-cast").show();
            } else {
                // コントローラ側で処理判断するパラメータ
                $('input[name="crud_type"]').val("update");

                var checked = $('input[name="check_cast"]:checked');
                var json = JSON.parse(
                    $(checked)
                        .closest(".cast-box")
                        .find('input[name="json_data"]')
                        .val()
                );
                $("#cast").find('input[name="id"]').val(json["id"]);
                $("#cast").find('input[name="name"]').val(json["name"]);
                $("#cast").find('input[name="nickname"]').val(json["nickname"]);
                $("#cast").find('input[name="email"]').val(json["email"]);

                if (json["status"] == 1) {
                    $('input[name="status"]').attr("checked", "checked");
                }
                $("#cast").find("#save-cast").show();
                $("#cast").find("#show-cast").hide();
                $("textarea").trigger("autoresize");
                Materialize.updateTextFields(); // インプットフィールドの初期化
            }
        });

        // スタッフ 追加ボタン押した時
        $(document).on("click", ".cast-addBtn", function () {
            if ($("#save-cast").css("display") == "block") {
                $("#cast").find("#save-cast").hide();
                $("#cast").find("#show-cast").show();
            } else {
                $("html,body").animate({ scrollTop: 0 });
                // フォームの中身はすべて消す
                $("#cast").find('input[name="id"]').val("");
                $("#cast").find('input[name="name"]').val("");
                $("#cast").find('input[name="nickname"]').val("");
                $("#cast").find('input[name="email"]').val("");
                // コントローラ側で処理判断するパラメータ
                $('input[name="crud_type"]').val("insert");
                $("#save-cast").find("button").removeClass("disabled");
                $("#cast").find("#save-cast").show();
                $("#cast").find("#show-cast").hide();
            }
        });

        /* スタッフ 登録ボタン押した時 */
        $(document).on("click", ".cast-saveBtn", function () {
            if (!confirm("こちらの内容に変更でよろしいですか？")) {
                return false;
            }

            var $form = $('form[name="save_cast"]');

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#cast"));
        });

        /* スタッフ チェックボックス押した時 */
        $(document).on("click", ".check-cast-group", function () {
            var $button = $("#cast").find(".cast-changeBtn,.cast-deleteBtn");
            var $addButton = $("#cast").find(".cast-addBtn");

            if ($(this).prop("checked")) {
                $("html,body").animate(
                    { scrollTop: $(".cast-Scroll").offset().top },
                    1200
                );
                // 一旦全てをクリアして再チェックする
                $(".check-cast-group").prop("checked", false);
                $(this).prop("checked", true);
                $($button).removeClass("disabled");
                $($addButton).addClass("disabled");
            } else {
                $($button).addClass("disabled");
                $($addButton).removeClass("disabled");
            }
        });

        /* スタッフ スイッチ押した時 */
        $(document).on("change", ".cast-switchBtn", function () {
            var target = $(this).closest(".cast-box");
            var json = JSON.parse(
                $(target).find('input[name="json_data"]').val()
            );
            var status = 1; // チェック状態初期値
            // チェックされてない場合
            if (!$(this).prop("checked")) {
                status = 0;
            }
            var data = {
                id: json.id,
                status: status,
                action: "/owner/shops/switch_cast",
            };

            $.ajax({
                type: "POST",
                datatype: "json",
                url: data.action,
                data: data,
                timeout: 30000,
                beforeSend: function (xhr, settings) {
                    $("#cast").find(".cast-switchBtn").attr("disabled", true);
                },
                complete: function (xhr, textStatus) {
                    $("#cast").find(".cast-switchBtn").attr("disabled", false);
                },
                success: function (response, dataType) {
                    // OKの場合
                    if (response.success) {
                        Materialize.toast(
                            $(target).find(".cast-num").text() +
                                response.message,
                            3000,
                            "rounded"
                        );
                    } else {
                        // NGの場合
                        Materialize.toast(
                            $(target).find(".cast-num").text() +
                                response.message,
                            3000,
                            "rounded"
                        );
                    }
                },
                error: function (response, textStatus, xhr) {
                    $("#cast").find(".cast-switchBtn").attr("disabled", false);
                    $.notifyBar({
                        cssClass: "error",
                        html: "通信に失敗しました。ステータス：" + textStatus,
                    });
                },
            });
        });

        // スタッフ 削除ボタン押した時
        $(document).on("click", ".cast-deleteBtn", function () {
            var checked = $('input[name="check_cast"]:checked');
            var json = JSON.parse(
                $(checked)
                    .closest(".cast-box")
                    .find('input[name="json_data"]')
                    .val()
            );

            if (
                !confirm(
                    "【" +
                        json.name +
                        "】\n選択したスタッフを削除してもよろしいですか？"
                )
            ) {
                return false;
            }
            var $form = $('form[id="delete-cast"]');
            $($form).find("input[name='id']").val(json.id);
            $($form).find("input[name='dir']").val(json.dir);

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#cast"));
        });
        /* スタッフ 関連処理 END */

        /* 店舗情報 関連処理 START */
        // 店舗情報 変更、やめるボタン押した時
        $(document).on("click", ".tenpo-changeBtn", function () {
            $("html,body").animate({ scrollTop: 0 });

            if ($("#save-tenpo").css("display") == "block") {
                // $(obj).find('[name="tenpo"]').val(""); //初期値を削除しない
                $("#tenpo").find("#save-tenpo").hide();
                $("#tenpo").find("#show-tenpo").show();
            } else {
                var json = JSON.parse(
                    $("#tenpo").find('input[name="json_data"]').val()
                );
                // 時間開始に初期値があればセット
                if (json["bus_from_time"]) {
                    var $from = $("#tenpo")
                        .find("#bus-from-time")
                        .pickatime()
                        .pickatime("picker");
                    var from = new Date(json["bus_from_time"]);
                    $($from).val(
                        toDoubleDigits(from.getHours()) +
                            ":" +
                            toDoubleDigits(from.getMinutes())
                    );
                }
                // 時間終了に初期値があればセット
                if (json["bus_to_time"]) {
                    var $to = $("#tenpo")
                        .find("#bus-to-time")
                        .pickatime()
                        .pickatime("picker");
                    var to = new Date(json["bus_to_time"]);
                    $($to).val(
                        toDoubleDigits(to.getHours()) +
                            ":" +
                            toDoubleDigits(to.getMinutes())
                    );
                }
                $("#tenpo").find('input[name="name"]').val(json["name"]);
                $("#tenpo").find('input[name="pref21"]').val(json["pref21"]);
                $("#tenpo").find('input[name="addr21"]').val(json["addr21"]);
                $("#tenpo").find('input[name="strt21"]').val(json["strt21"]);
                $("#tenpo").find('input[name="tel"]').val(json["tel"]);
                $("#tenpo")
                    .find('input[name="bus_hosoku"]')
                    .val(json["bus_hosoku"]);
                $("#tenpo").find('textarea[name="staff"]').val(json["staff"]);
                $("#tenpo").find('textarea[name="system"]').val(json["system"]);
                //クレジットフィールドにあるタグを取得して配列にセット
                var data = JSON.parse(
                    $("#tenpo").find('input[name="credit_hidden"]').val()
                );
                // クレジットフィールドの初期化
                $(".chips-initial").material_chip({
                    data: data,
                });
                $("#tenpo").find("#save-tenpo").show();
                $("#tenpo").find("#show-tenpo").hide();

                $("textarea").trigger("autoresize"); // テキストエリアの初期化
                Materialize.updateTextFields(); // インプットフィールドの初期化
                $($("#tenpo").find('div[name="credit"]'))
                    .find("input")
                    .prop("disabled", true);
            }
        });

        // 店舗情報 登録ボタン押した時
        $(document).on("click", ".tenpo-saveBtn", function () {
            if (!confirm("こちらの店舗内容でよろしいですか？")) {
                return false;
            }

            var $form = $('form[name="save_tenpo"]');
            var tagData = $($form).find(".chips").material_chip("data");
            if (tagData.length > 0) {
                var csvTag = "";
                for (var i = 0; i < tagData.length; i++) {
                    csvTag = csvTag += tagData[i].tag + ",";
                }
                csvTag = csvTag.slice(0, -1);
                $($form).find('input[name="credit"]').val(csvTag);
            }

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#tenpo"));
        });

        /* ギャラリー 関連処理 START */
        // ギャラリー 削除ボタン押した時
        $(document).on("click", ".gallery-deleteBtn", function () {
            var filePath = $(this).data("delete");

            if (!confirm("選択したギャラリーを削除してもよろしいですか？")) {
                return false;
            }
            var $form = $('form[id="delete-gallery"]');
            $($form).find("input[name='file_path']").val(filePath);

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#gallery"));
        });
        // ギャラリー 画像を選択した時
        $(document).on("change", "#image-file", function () {
            if ($("#image-file").prop("files").length == 0) {
                $(".cancelBtn").addClass("disabled");
                $(".createBtn").addClass("disabled");
            } else {
                $(".cancelBtn").removeClass("disabled");
                $(".createBtn").removeClass("disabled");
            }
            $(document).find(".card-img.new").remove();
            var fileList = $("#image-file").prop("files");
            var imgCount = $(".card-img").length;
            var fimeMax = $("input[name='file_max']").val();
            var modulePath = "/module/materialboxed.ctp";

            $.each(fileList, function (index, file) {
                //画像ファイルかチェック
                if (
                    file["type"] != "image/jpeg" &&
                    file["type"] != "image/png" &&
                    file["type"] != "image/gif"
                ) {
                    alert("jpgかpngかgifファイルを選択してください");
                    $("#image-file").val("");
                    return false;
                }
            });
            // ファイル数を制限する
            if (fileList.length + imgCount > fimeMax) {
                alert(
                    "アップロードできる画像は" + fimeMax + "ファイルまでです。"
                );
                resetBtn($(document), true);
                return false;
            }
            for (var i = 0; i < fileList.length; i++) {
                imgCount += 1;
                fileload(fileList[i], $("#gallery .row"), imgCount, modulePath);
            }
        });
        // ギャラリー 登録ボタン押した時
        $(document).on("click", ".gallery-saveBtn", function () {
            //ファイル選択済みかチェック
            var fileCheck = $("#image-file").val().length;
            if (fileCheck === 0) {
                alert("画像ファイルを選択してください");
                return false;
            }
            if (!confirm("こちらの画像に変更でよろしいですか？")) {
                return false;
            }
            // 新しく追加された画像のみを対象にする
            var $selecter = $(".card-img.new").find("img");

            var $form = $("#save-gallery");
            // ファイル変換
            var blobList = fileConvert("#image-canvas", $selecter);

            // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
            // POSTでリクエスト内のデータが全部なくなるので。
            // TODO: 後で対策を考えよう
            $($form).find("#image-file, .file-path").val("");

            //アップロード用blobをformDataに設定
            formData = new FormData($form.get()[0]);
            for (item of blobList) {
                formData.append("image[]", item);
            }
            // for (item of formData) {
            //   console.log(item);
            // }
            //通常のアクションをキャンセルする
            event.preventDefault();
            fileUpAjaxCommon($form, formData, $("#gallery"));
        });
        // ギャラリー やめるボタン押した時
        $(document).on("click", ".gallery-chancelBtn", function () {
            // newタグが付いたファイルを表示エリアから削除する
            $("#gallery").find(".card-img.new").remove();
            // フォーム入力も削除する
            $("#gallery").find("#image-file, .file-path").val("");
        });
        /* ギャラリー 関連処理 END */

        // 求人情報 リストから選ぶボタン押した時
        $(document).on("click", ".jobModal-callBtn", function () {
            // オブジェクトを配列に変換
            //var treatment = Object.entries(JSON.parse($(obj).find('input[name="treatment_hidden"]').val()));
            var $chips = $("#job").find(".chips");
            var $chipList = $("#modal-job").find(".chip-dummy");
            $($chips).val($(this).attr("id"));
            // 待遇フィールドにあるタグを取得して配列にセット
            var data = $($chips).material_chip("data");

            var addFlg = true;
            // 配列dataを順に処理
            // タグの背景色を初期化する
            $($chipList).each(function (i, o) {
                $(o).removeClass("back-color");
            });
            // インプットフィールドにあるタグは選択済にする
            $.each(data, function (index, val) {
                $($chipList).each(function (i, o) {
                    if ($(o).attr("id") == val.id) {
                        $(o).addClass("back-color");
                        return true;
                    }
                });
            });
        });

        // 店舗情報 クレジットタグをフォームに追加する
        $(document).on("click", ".chip-credit", function () {
            var $chips = $("#tenpo").find(".chips");
            $($chips).val($(this).children().attr("alt"));
            // クレジットフィールドにあるタグを取得して配列にセット
            var data = $($chips).material_chip("data");
            console.log(data);

            // クリックしたタグを取得
            var newTag = $(this).children().attr("alt");
            var newId = $(this).children().attr("id");
            var addFlg = true;
            // 配列dataを順に処理
            $.each(data, function (index, val) {
                if (newId == val.id) {
                    addFlg = false;
                }
            });
            // 重複したクレジットが無い、またはデータが１つも無ければクレジット追加
            if (addFlg || data.length == 0) {
                var path = $("#tenpo").find('input[name="credit_path"]').val()
                data.push({
                    tag: newTag,
                    image: path + newTag + ".png",
                    id: newId,
                });
            }
            // クレジットフィールドの初期化
            $($chips).material_chip({
                data: data,
            });
            $($chips).find("input").prop("disabled", true);
            //フレームワークmaterializecssの本来のイベントをキャンセルする
            //※ブラウザでエラー発生するため（Uncaught TypeError: Cannot read property '*' of undefined）
            event.stopImmediatePropagation();
        });
        /* 店舗情報 関連処理 END */

        /* 求人情報 関連処理 START */
        // 求人情報 変更、やめるボタン押した時
        $(document).on("click", ".job-changeBtn", function () {
            $("html,body").animate({ scrollTop: 0 });

            if ($("#save-job").css("display") == "block") {
                $("#job").find("#save-job").hide();
                $("#job").find("#show-job").show();
            } else {
                var job = JSON.parse(
                    $("#job").find('input[name="json_data"]').val()
                );
                $("#job").find('input[name="id"]').val(job["id"]);
                $("#job")
                    .find('p[name="name"]')
                    .text($("#job").find(".show-job-name").text());
                $("#job").find('select[name="industry"]').val(job["industry"]);
                $("#job").find('select[name="job_type"]').val(job["job_type"]);
                // 時間開始に初期値があればセット
                if (job["work_from_time"]) {
                    var $from = $("#work-from-time")
                        .pickatime()
                        .pickatime("picker");
                    var from = new Date(job["work_from_time"]);
                    $($from).val(
                        toDoubleDigits(from.getHours()) +
                            ":" +
                            toDoubleDigits(from.getMinutes())
                    );
                }
                // 時間終了に初期値があればセット
                if (job["work_to_time"]) {
                    var $to = $("#work-to-time")
                        .pickatime()
                        .pickatime("picker");
                    var to = new Date(job["work_to_time"]);
                    $($to).val(
                        toDoubleDigits(to.getHours()) +
                            ":" +
                            toDoubleDigits(to.getMinutes())
                    );
                }
                $("#job")
                    .find('input[name="work_time_hosoku"]')
                    .val(job["work_time_hosoku"]);
                $("#job")
                    .find('input[name="qualification_hosoku"]')
                    .val(job["qualification_hosoku"]);
                $("#job").find('select[name="from_age"]').val(job["from_age"]);
                $("#job").find('select[name="to_age"]').val(job["to_age"]);
                // NULLか空の場合は、空を代入する
                var dayArray = job["holiday"] ? job["holiday"].split(",") : "";
                $.each(dayArray, function (index, val) {
                    $("#job")
                        .find('input[name="holiday[]"]')
                        .each(function (i, o) {
                            if (val == $(o).val()) {
                                $(o).prop("checked", true);
                            }
                        });
                });

                $("#job")
                    .find('input[name="holiday_hosoku"]')
                    .val(job["holiday_hosoku"]);
                $("#job").find('input[name="treatment"]').val(job["treatment"]);
                $("#job").find('textarea[name="pr"]').val(job["pr"]);
                $("#job").find('input[name="tel1"]').val(job["tel1"]);
                $("#job").find('input[name="tel2"]').val(job["tel2"]);
                $("#job").find('input[name="email"]').val(job["email"]);
                $("#job").find('input[name="lineid"]').val(job["lineid"]);
                //待遇フィールドにあるタグを取得して配列にセット
                var data = JSON.parse(
                    $("#job").find('input[name="treatment_hidden"]').val()
                );
                // 待遇フィールドの初期化
                $("#job").find(".chips-initial").material_chip({
                    data: data,
                });
                $("#job").find("#save-job").show();
                $("#job").find("#show-job").hide();

                $("textarea").trigger("autoresize"); // テキストエリアの初期化
                Materialize.updateTextFields(); // インプットフィールドの初期化
                $("#job").find("select").material_select(); // セレクトボックスの値を動的に変えたら初期化する必要がある
                $($("#job").find('div[name="credit"]'))
                    .find("input")
                    .prop("disabled", true);
            }
        });

        // 求人情報 登録ボタン押した時
        $(document).on("click", ".job-saveBtn", function () {
            if (!confirm("こちらの求人内容でよろしいですか？")) {
                return false;
            }

            var $form = $('form[name="save_job"]');
            var tagData = $($form).find(".chips").material_chip("data");
            if (tagData.length > 0) {
                var csvTag = "";
                for (var i = 0; i < tagData.length; i++) {
                    csvTag = csvTag += tagData[i].tag + ",";
                }
                csvTag = csvTag.slice(0, -1);
                $($form).find('input[name="treatment"]').val(csvTag);
            }

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#job"));
        });

        // 求人情報 待遇タグをフォームに追加する
        $(document).on("click", ".chip-treatment", function (event) {
            var $chips = $("#job").find(".chips");
            $($chips).val($(this).attr("id"));
            // 待遇フィールドにあるタグを取得して配列にセット
            var data = $($chips).material_chip("data");

            // クリックしたタグを取得
            var newTag = $(this).attr("value");
            var newId = $(this).attr("id");
            var addFlg = true;
            var removeFlg = false;
            if ($(this).hasClass("back-color")) {
                $(this).removeClass("back-color");
                removeFlg = true;
            } else {
                $(this).addClass("back-color");
            }
            // 配列dataを順に処理
            $.each(data, function (index, val) {
                if (newId == val.id) {
                    addFlg = false;
                }
            });
            // 重複した待遇が無い、またはデータが１つも無ければ待遇追加
            if (addFlg || data.length == 0) {
                data.push({ tag: newTag, id: newId });
            }
            //タグの選択解除
            if (removeFlg) {
                $.each(data, function (index, val) {
                    if (newId == val.id) {
                        data.splice(index, 1);
                        return false;
                    }
                });
            }
            // 待遇フィールドの初期化
            $($chips).material_chip({
                data: data,
            });
            $($chips).find("input").prop("disabled", true);
            //フレームワークmaterializecssの本来のイベントをキャンセルする
            //※ブラウザでエラー発生するため（Uncaught TypeError: Cannot read property '*' of undefined）
            event.stopImmediatePropagation();
        });
        $("ul.tabs").tabs();
    }
    /* 店舗情報 画面 END */

    /* SNS 関連処理 START */
    // SNS 変更、やめるボタン押した時
    $(document).on("click", ".sns-changeBtn", function () {
        $("html,body").animate({ scrollTop: 0 });

        if ($("#save-sns").css("display") == "block") {
            $("#sns").find("#save-sns").hide();
            $("#sns").find("#show-sns").show();
        } else {
            var sns = JSON.parse(
                $("#sns").find('input[name="json_data"]').val()
            );
            if (sns != null) {
                $("#sns").find('input[name="id"]').val(sns["id"]);
                $("#sns").find('input[name="facebook"]').val(sns["facebook"]);
                $("#sns").find('input[name="twitter"]').val(sns["twitter"]);
                $("#sns").find('input[name="instagram"]').val(sns["instagram"]);
                $("#sns").find('input[name="lineid"]').val(sns["line"]);
            }
            $("#sns").find("#save-sns").show();
            $("#sns").find("#show-sns").hide();

            Materialize.updateTextFields(); // インプットフィールドの初期化
        }
    });

    // SNS 登録ボタン押した時
    $(document).on("click", ".sns-saveBtn", function () {
        if (!confirm("こちらの内容でよろしいですか？")) {
            return false;
        }
        var $form = $('form[name="save_sns"]');

        //通常のアクションをキャンセルする
        event.preventDefault();
        ajaxCommon($form, $("#sns"));
    });

    /* 店舗情報 画面 END */

    /* お知らせ 画面 START */
    if ($("#notice").length) {
        // 入力フォームに変更があった時
        $(document).on("input", "#title, #content, #image-file", function () {
            $("#edit-notice").find(".createBtn").removeClass("disabled");
            $("#edit-notice").find(".cancelBtn").removeClass("disabled");
        });
        // モーダルお知らせの入力フォームに変更があった時
        $(document).on(
            "input",
            "#modal-title, #modal-content, #modal-image-file",
            function () {
                $(".updateBtn").removeClass("disabled");
            }
        );
        // 画像を選択した時
        $(document).on("change", "#image-file", function () {
            canvasRender("#notice", this, true);
        });
        // モーダルお知らせで画像を選択した時
        $(document).on("change", "#modal-image-file", function () {
            canvasRender("#modal-notice", this, true);
        });
        // 登録ボタン押した時
        $(document).on("click", ".createBtn", function () {
            var form = $("#edit-notice");
            if (formValidete(form)) {
                return false;
            }

            if (!confirm("こちらのお知らせ内容でよろしいですか？")) {
                return false;
            }

            var fileCheck = $("#notice").find("#image-file").val().length;

            //ファイル選択済みの場合はajax処理を切り替える
            if (fileCheck > 0) {
                // 新しく追加された画像のみを対象にする
                var $selecter = $(".card-img").find("img");

                // ファイル変換
                var blobList = fileConvert("#image-canvas", $selecter);

                // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                // POSTでリクエスト内のデータが全部なくなるので。
                // TODO: 後で対策を考えよう
                $(form).find("#image-file, .file-path").val("");

                //アップロード用blobをformDataに設定
                formData = new FormData(form.get()[0]);
                for (item of blobList) {
                    formData.append("image[]", item);
                }
                // for (item of formData) {
                //     console.log(item);
                // }
                //通常のアクションをキャンセルする
                event.preventDefault();
                fileUpAjaxCommon(form, formData, $("#wrapper"));
            } else {
                ajaxCommon(form, $("#wrapper"));
            }
        });

        // 更新ボタン押した時
        $(document).on("click", ".updateBtn", function () {
            var form = $("#modal-edit-notice");
            if (formValidete(form)) {
                return false;
            }

            // アクションタイプをhiddenにセットする。コントローラー側で処理分岐のために。
            var oldImgList = $(".card-img").not(".new"); // 既に登録した画像リスト
            var newImgList = $(".card-img.new").find("img"); // 追加した画像リスト
            var delList = new Array(); // 削除対象リスト
            if (
                $("#modal-edit-notice").find("input[name='json_data']").val() !=
                ""
            ) {
                delList = JSON.parse(
                    $("#modal-edit-notice")
                        .find("input[name='json_data']")
                        .val()
                );
            }
            // 既に登録した画像リストを元に削除対象を絞る
            $(oldImgList).each(function (i, elm1) {
                $.each(delList, function (i, elm2) {
                    if ($(elm1).find("input[name='path']").val() == elm2.path) {
                        delList.splice(i, 1);
                        return false;
                    }
                });
            });
            var form = $("#modal-edit-notice");
            $(form).find("input[name='del_list']").val(JSON.stringify(delList));
            $(form)
                .find("input[name='notice_id']")
                .val($("#delete-notice").find("input[name='id']").val());
            $(form)
                .find("input[name='dir_path']")
                .val($("#delete-notice").find("input[name='dir_path']").val());
            $(form).find(".card-img input").remove();

            var fileCheck = $(form).find("#modal-image-file").val().length;
            //ファイル選択済みの場合はajax処理を切り替える
            if (fileCheck > 0) {
                // 新しく追加された画像のみを対象にする
                var $selecter = $(".card-img.new").find("img");

                // ファイル変換
                var blobList = fileConvert("#image-canvas", $selecter);

                var cloneForm = $(form).clone(true);
                // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                // POSTでリクエスト内のデータが全部なくなるので。
                // TODO: 後で対策を考えよう
                $(cloneForm)
                    .find("#modal-image-file, .modal-file-path")
                    .val("");

                //アップロード用blobをformDataに設定
                formData = new FormData(cloneForm.get()[0]);

                for (item of blobList) {
                    formData.append("image[]", item);
                }
                // for (item of formData) {
                //     console.log(item);
                // }
                //通常のアクションをキャンセルする
                event.preventDefault();
                fileUpAjaxCommon(cloneForm, formData, $("#wrapper"));
            } else {
                ajaxCommon(form, $("#wrapper"));
            }
        });
        // キャンセルボタン押した時
        $("#notice").on("click", ".cancelBtn", function () {
            if (!confirm("取り消しますか？")) {
                return false;
            }
            $("#notice").find(".createBtn").addClass("disabled");
            $("#notice").find(".updateBtn").addClass("disabled");
            $("#notice").find(".cancelBtn").addClass("disabled");
            $("#notice")
                .find("#title, #content, #image-file, #file-path")
                .val("");
            $("#notice").find(".card-img").remove();
        });

        // アーカイブお知らせをクリックした時
        $(document).on("click", ".archiveLink", function () {
            var $form = $("#view-archive-notice");
            $($form)
                .find("input[name='id']")
                .val($(this).find("input[name='id']").val());
            //通常のアクションをキャンセルする
            event.preventDefault();
            callModalNoticeWithAjax($form, null, "admin");
            $(".materialboxed").materialbox();
        });
        // モーダルお知らせの更新モードボタン押した時
        $(document).on("click", ".updateModeBtn", function () {
            $("#modal-notice").find(".updateModeBtn").addClass("hide");
            $("#modal-notice").find(".returnBtn").removeClass("hide");
            // アクションタイプをhiddenにセットする。コントローラー側で処理分岐のために。
            $("#modal-edit-notice").find("input[name='_method']").val("POST");
            $("#modal-edit-notice")
                .find("input[name='title']")
                .val($(".notice-card.clone").find("p[name='title']").text());
            $("#modal-edit-notice")
                .find("textarea[name='content']")
                .val(
                    $(".notice-card.clone")
                        .find("p[name='content']")
                        .textWithLF()
                );
            $("textarea").trigger("autoresize"); // テキストエリアを入力文字の幅によりリサイズする
            // 画像が１つ以上ある場合にmaterialboxed生成
            if (
                $("#modal-edit-notice").find("input[name='json_data']").val()
                    .length > 0
            ) {
                var images = JSON.parse(
                    $("#modal-edit-notice")
                        .find("input[name='json_data']")
                        .val()
                );
                $.get("/module/materialboxed.ctp", {}, function (html) {
                    var materialTmp = $(html).clone(); // materialboxedの部品を複製しておく
                    $(materialTmp).removeClass("new"); // newバッチを削除する
                    $(materialTmp).find("span.new").remove(); // newバッチを削除する
                    var materials = $();
                    $.each(images, function (index, image) {
                        var material = $(materialTmp).clone();
                        $(material).find("input[name='id']").val(image["id"]);
                        //$(material).find("input[name='name']").val(image['name']);
                        $(material).find("input[name='key']").val(image["key"]);
                        $(material)
                            .find("input[name='path']")
                            .val(image["path"]);
                        $(material).find("img").attr("src", image["path"]);
                        materials = materials.add(material);
                    });
                    $(".modal-edit-notice").find(".row").append(materials);
                    $(".materialboxed").materialbox();
                    Materialize.updateTextFields();
                    $(".tooltipped").tooltip({ delay: 50 });
                });
            }
            // 更新画面を表示する
            $(".modal-edit-notice").removeClass("hide");
            $("#view-notice").addClass("hide");
        });
        // モーダルお知らせの戻るボタン押した時
        $(document).on("click", ".returnBtn", function () {
            // 画像フォームをクリアする
            $("#modal-edit-notice").find(".card-img").remove();
            $("#modal-edit-notice")
                .find("#modal-image-file")
                .replaceWith($("#modal-image-file").val("").clone(true));
            $("#modal-edit-notice")
                .find("input[name='modal_file_path']")
                .val("");
            // 通常の表示モードに切り替える。
            $("#modal-notice").find(".updateModeBtn").removeClass("hide");
            $("#modal-notice").find(".returnBtn").addClass("hide");
            $(".modal-edit-notice").addClass("hide");
            $("#view-notice").removeClass("hide");
            $("#modal-notice").find(".updateBtn").addClass("disabled");
            $(".modal-edit-notice").find("input[name='title']").val("");
            $(".modal-edit-notice").find("textarea[name='content']").text("");
            $(".modal-edit-notice").find("textarea").trigger("autoresize");
            //resetModal();
        });
        // モーダルお知らせの削除ボタン押した時
        $(document).on("click", ".deleteBtn", function () {
            // 画像の削除ボタンの場合
            if ($(this).data("delete") == "image") {
                var $image = $(this).closest(".card-img");
                // var serachName = $newImage.find("input[name='name']").val();
                $(".tooltipped").tooltip({ delay: 50 });
                $image.remove();
                $("#modal-notice").find(".updateBtn").removeClass("disabled");
                return;
            }
            // お知らせ削除の場合
            if (!confirm("このお知らせを削除しますか？")) {
                return false;
            }

            var $form = $('form[id="delete-notice"]');

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#wrapper"));
            $("#modal-notice").modal("close");
        });
    }
    /* お知らせ 画面 END */
    /* 設定画面 START */
    if ($("#option").length) {
        // 入力フォームに変更があった時
        $(document)
            .find("#option")
            .on("input", function () {
                $("#option").find(".saveBtn").removeClass("disabled");
            });
        // 登録ボタン押した時
        $("#option")
            .find(".saveBtn")
            .on("click", function () {
                if (!confirm("こちらの内容でよろしいですか？")) {
                    return false;
                }
                var $form = $("#save-option");

                //通常のアクションをキャンセルする
                event.preventDefault();
                ajaxCommon($form, $("#wrapper"));
            });
    }
    /* 設定画面 END */
    /* 出勤管理 画面 START */
    if ($("#work-schedule-management").length) {
        fullcalendarSetting();

        // 出勤管理 スタッフタグを選択する
        $(document).on("click", ".chip-cast", function (event) {
            if ($(this).hasClass("back-color")) {
                $(this).removeClass("back-color");
                $(this).attr("data-select", "");
            } else {
                $(this).addClass("back-color");
                $(this).attr("data-select", $(this).data("cast_id"));
            }
        });

        // 登録,更新,削除ボタン押した時
        $(document).on("click", ".saveBtn", function () {
            if (
                !confirm(
                    "選択したスタッフが本日のメンバーでよろしいですか？\nメンバーはいつでも変更できます。"
                )
            ) {
                return false;
            }
            var csv = "";
            var selected = $(".chip-box").find(".back-color");
            $(selected).each(function (i, el) {
                csv = csv += $(el).data("select") + ",";
            });

            csv = csv.slice(0, -1);

            var $form = $("#save-work-schedule");
            $($form).find('input[name="cast_ids"]').val(csv);

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#wrapper"));
        });
    }
    /* 出勤管理 画面 END */
}

/**
 * ajax共通処理
 * @param  {Object} $form 対象のフォーム
 * @param  {Object} $tab jsonのhtmlを挿入する対象セレクタ
 */
var ajaxCommon = function ($form, $tab) {
    $.ajax({
        url: $form.attr("action"), //Formのアクションを取得して指定する
        type: $form.attr("method"), //Formのメソッドを取得して指定する
        data: $form.serialize(), //データにFormがserialzeした結果を入れる
        dataType: "json", //データにFormがserialzeした結果を入れる
        timeout: 30000,
        beforeSend: function (xhr, settings) {
            //Buttonを無効にする
            $($tab).find("button").attr("disabled", true);
            //処理中のを通知するアイコンを表示する
            $("#dummy").load("/module/Preloader.ctp");
        },
        complete: function (xhr, textStatus) {
            //処理中アイコン削除
            $(".preloader-wrapper").remove();
            $($tab).find("button").attr("disabled", false);
        },
        success: function (response, textStatus, xhr) {
            // OKの場合
            if (response.success) {
                $($tab).replaceWith(response.html);
                $.notifyBar({
                    cssClass: "success",
                    html: response.message,
                });
                crearAllevents();
                allInitialize();
            } else {
                // NGの場合
                $.notifyBar({
                    cssClass: "error",
                    html: response.message,
                });
            }
        },
        error: function (response, textStatus, xhr) {
            $($tab).find("button").attr("disabled", false);
            $.notifyBar({
                cssClass: "error",
                html: "通信に失敗しました。ステータス：" + textStatus,
            });
        },
    });
};

/** @description 画像アップロードajax共通処理
 * @param  {Object} $form 対象のフォーム
 * @param  {Object} formData 画像データを追加した$formの複製
 * @param  {Object} $tab jsonのhtmlを挿入する対象セレクタ
 */
var fileUpAjaxCommon = function ($form, formData, $tab) {
    $.ajax({
        url: $form.attr("action"), //Formのアクションを取得して指定する
        type: $form.attr("method"), //Formのメソッドを取得して指定する
        data: formData, //データにFormがserialzeした結果を入れる
        dataType: "json", //データにFormがserialzeした結果を入れる
        processData: false,
        contentType: false,
        timeout: 30000,
        beforeSend: function (xhr, settings) {
            //Buttonを無効にする
            $($tab).find("button").attr("disabled", true);
            //処理中のを通知するアイコンを表示する
            $("#dummy").load("/module/Preloader.ctp");
        },
        complete: function (xhr, textStatus) {
            //処理中アイコン削除
            $(".preloader-wrapper").remove();
            $($tab).find("button").attr("disabled", false);
        },
        success: function (response, textStatus, xhr) {
            // OKの場合
            if (response.success) {
                $($tab).replaceWith(response.html);
                $.notifyBar({
                    cssClass: "success",
                    html: response.message,
                });
                crearAllevents();
                allInitialize();
            } else {
                // NGの場合
                $.notifyBar({
                    cssClass: "error",
                    html: response.message,
                });
            }
        },
        error: function (response, textStatus, xhr) {
            $($tab).find("button").attr("disabled", false);
            $.notifyBar({
                cssClass: "error",
                html: "通信に失敗しました。ステータス：" + textStatus,
            });
        },
    });
};

/**
 * 検索ajax処理
 * @param  {} replace
 * @param  {} form
 */
var searchAjax = function (searchResult, form) {
    $.ajax({
        url: form.attr("action"), //Formのアクションを取得して指定する
        type: form.attr("method"), //Formのメソッドを取得して指定する
        data: form.serialize(), //データにFormがserialzeした結果を入れる
        dataType: "json", //データにFormがserialzeした結果を入れる
        timeout: 30000,
        beforeSend: function (xhr, settings) {
            //Buttonを無効にする
            $(document).find(".searchBtn").addClass("disabled");
            //処理中の通知するアイコンを表示する
            $("#dummy").load("/module/Preloader.ctp");
        },
        complete: function (xhr, textStatus) {
            //処理中アイコン削除
            $(".preloader-wrapper").remove();
            $(document).find(".searchBtn").removeClass("disabled");
            $("#modal-search").modal("close");
        },
        success: function (response, textStatus, xhr) {
            $(searchResult).replaceWith(response.html);
        },
        error: function (response, textStatus, xhr) {
            $.notifyBar({
                cssClass: "error",
                html: "通信に失敗しました。ステータス：" + textStatus,
            });
        },
    });
};

/**
 * @description モーダル日記表示 ユーザー、スタッフのみで使用
 * @param  {} $form
 * @param  {} userType
 */
var callModalDiaryWithAjax = function ($form, $this, userType) {
    $.ajax({
        url: $form.attr("action"), //Formのアクションを取得して指定する
        type: $form.attr("method"), //Formのメソッドを取得して指定する
        data: $form.serialize(), //データにFormがserialzeした結果を入れる
        dataType: "json", //データにFormがserialzeした結果を入れる
        timeout: 30000,
        beforeSend: function (xhr, settings) {
            // 他のアーカイブリンクを無効化する
            $(".archiveLink").each(function (i, elem) {
                $(elem).css("pointer-events", "none");
            });
            //処理中のを通知するアイコンを表示する
            $("#dummy").load("/module/Preloader.ctp");
        },
        complete: function (xhr, textStatus) {
            // 他のアーカイブリンクを有効化する
            $(".archiveLink").each(function (i, elem) {
                $(elem).css("pointer-events", "");
            });
            //処理中アイコン削除
            $(".preloader-wrapper").remove();
        },
        success: function (response, dataType) {
            $("#modal-diary").modal({
                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                opacity: 0.2, // Opacity of modal background
                inDuration: 300, // Transition in duration
                outDuration: 200, // Transition out duration
                startingTop: "4%", // Starting top style attribute
                endingTop: "10%", // Ending top style attribute
                // モーダル表示完了コールバック
                ready: function () {
                    scrollPosition = $(window).scrollTop();
                    // モーダル表示してる時は、背景画面のスクロールを禁止する
                    $("body").addClass("fixed").css({ top: -scrollPosition });
                    // スタッフの日記ディレクトリを取得する
                    var diaryDir =
                        $("input[name='cast_dir']").val() + response["dir"];
                    // 日記カードの要素を複製し、複製したやつを表示するようにする。
                    var diaryCard = $(".diary-card")
                        .clone(true)
                        .insertAfter(".diary-card")
                        .addClass("clone")
                        .removeClass("hide");
                    // 日記内容の設定
                    $(diaryCard)
                        .find("p[name='created']")
                        .text(response["ymd_created"]);
                    $(diaryCard)
                        .find("p[name='title']")
                        .text(response["title"]);
                    $(diaryCard)
                        .find("p[name='content']")
                        .textWithLF(response["content"]);
                    // お気に入り設定
                    ajaxModalFavo(diaryCard.closest('#modal-diary')
                            .find('.modal-footer'), response, 'diarys');

                    // 画像表示するグリッドを決定する
                    if (response["gallery"].length > 0) {
                        var figure = $(diaryCard).find("figure");
                        var imgClass = "";
                        $.each(response["gallery"], function (key, value) {
                            var cloneFigure = $(figure)
                                .clone(true)
                                .removeClass()
                                .insertAfter(figure);
                            $(cloneFigure)
                                .find("a")
                                .attr({ href: value["file_path"] });
                            $(cloneFigure)
                                .find("img")
                                .attr({ src: value["file_path"] });
                        });
                        $(diaryCard).find("figure.hide").remove();
                        initPhotoSwipeFromDOM(".my-gallery");
                    }

                    // 管理者の場合JSONデータを保持する
                    if (userType == "admin") {
                        var images = [];
                        $.each(response["gallery"], function (key, value) {
                            // プッシュする
                            images.push({
                                id: response["id"],
                                path: value["file_path"],
                                key: key,
                            });
                        });

                        var dir = $("#diary")
                            .find("input[name='cast_dir']")
                            .val();
                        $("#delete-diary")
                            .find("input[name='id']")
                            .val(response["id"]);
                        $("#delete-diary")
                            .find("input[name='dir_path']")
                            .val(dir + response["dir"]);
                        $("#modal-edit-diary")
                            .find("input[name='id']")
                            .val(response["id"]);
                        $("#modal-edit-diary")
                            .find("input[name='json_data']")
                            .val(JSON.stringify(images));
                    }
                },

                // モーダル非表示完了コールバック
                complete: function () {
                    // ユーザーの場合
                    if (userType == "user") {
                        console.log($this);
                        $clone = $($(this)[0]["$el"]).find(".clone");
                        $footer = $clone.closest('#modal-diary')
                            .find('.modal-footer');
                        // アーカイブリンクにモーダル表示時のイイネを反映する
                        $this.find('.count').text($footer.find('.count').text());
                        if ($footer.find('.modal-footer__a-favorite').hasClass('red')) {

                            $this.find('.li-linkbox__a-favorite').addClass('red');
                            $this.find('.li-linkbox__a-favorite').removeClass('grey');
                        } else {
                            $this.find('.li-linkbox__a-favorite').addClass('grey');
                            $this.find('.li-linkbox__a-favorite').removeClass('red');
                        }

                        // モーダル非表示した時は、背景画面のスクロールを解除する
                        $("body").removeClass("fixed").css({ top: 0 });
                        window.scrollTo(0, scrollPosition);
                        $footer.find('.count').text("");
                        $footer.find('.modal-footer__a-favorite').removeClass('red');
                        $clone.remove();
                    } else if (userType == "admin") {
                        //スタッフの場合
                        // モーダルフォームをクリアする
                        $("#modal-edit-diary").find(".card-img").remove();
                        $("#modal-edit-diary")
                            .find("#modal-image-file")
                            .replaceWith(
                                $("#modal-image-file").val("").clone(true)
                            );
                        $("#modal-edit-diary")
                            .find("input[name='modal_file_path']")
                            .val("");
                        // モーダルを初期化
                        resetModal();
                        // モーダル非表示した時は、背景画面のスクロールを解除する
                        $("body").removeClass("fixed").css({ top: 0 });
                        window.scrollTo(0, scrollPosition);
                        $(".modal-edit-diary").addClass("hide");
                        $("#view-diary").removeClass("hide");
                        $("#view-diary").find(".clone").remove();
                        $(".updateBtn").addClass("disabled");
                    }
                    $(".tooltipped").tooltip({ delay: 50 });
                },
            });
            $("#modal-diary").modal("open");
        },
        error: function (response, textStatus, xhr) {
            $.notifyBar({
                cssClass: "error",
                html: "通信に失敗しました。ステータス：" + textStatus,
            });
        },
    });
};

/**
 * @description モーダルお知らせ表示 ユーザー、店舗お知らせのみで使用
 * @param  {} $form
 * @param  {} userType
 */
var callModalNoticeWithAjax = function ($form, $this, userType) {
    $.ajax({
        url: $form.attr("action"), //Formのアクションを取得して指定する
        type: $form.attr("method"), //Formのメソッドを取得して指定する
        data: $form.serialize(), //データにFormがserialzeした結果を入れる
        dataType: "json", //データにFormがserialzeした結果を入れる
        timeout: 30000,
        beforeSend: function (xhr, settings) {
            // 他のアーカイブリンクを無効化する
            $(".archiveLink").each(function (i, elem) {
                $(elem).css("pointer-events", "none");
            });
            //処理中のを通知するアイコンを表示する
            $("#dummy").load("/module/Preloader.ctp");
        },
        complete: function (xhr, textStatus) {
            // 他のアーカイブリンクを有効化する
            $(".archiveLink").each(function (i, elem) {
                $(elem).css("pointer-events", "");
            });
            //処理中アイコン削除
            $(".preloader-wrapper").remove();
        },
        success: function (response, dataType) {
            $("#modal-notice").modal({
                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                opacity: 0.2, // Opacity of modal background
                inDuration: 300, // Transition in duration
                outDuration: 200, // Transition out duration
                startingTop: "4%", // Starting top style attribute
                endingTop: "10%", // Ending top style attribute
                // モーダル表示完了コールバック
                ready: function () {
                    scrollPosition = $(window).scrollTop();
                    // モーダル表示してる時は、背景画面のスクロールを禁止する
                    $("body").addClass("fixed").css({ top: -scrollPosition });
                    // スタッフのお知らせディレクトリを取得する
                    var noticeDir =
                        $("input[name='notice_dir']").val() + response["dir"];
                    // お知らせカードの要素を複製し、複製したやつを表示するようにする。
                    var noticeCard = $(".notice-card")
                        .clone(true)
                        .insertAfter(".notice-card")
                        .addClass("clone")
                        .removeClass("hide");
                    // お知らせ内容の設定
                    $(noticeCard)
                        .find("p[name='created']")
                        .text(response["ymd_created"]);
                    $(noticeCard)
                        .find("p[name='title']")
                        .text(response["title"]);
                    $(noticeCard)
                        .find("p[name='content']")
                        .textWithLF(response["content"]);
                    ajaxModalFavo(noticeCard.closest('#modal-notice')
                            .find('.modal-footer'), response, 'shop_infos');

                    // 画像表示するグリッドを決定する
                    if (response["gallery"].length > 0) {
                        var figure = $(noticeCard).find("figure");
                        var imgClass = "";
                        $.each(response["gallery"], function (key, value) {
                            var cloneFigure = $(figure)
                                .clone(true)
                                .removeClass()
                                .insertAfter(figure);
                            $(cloneFigure)
                                .find("a")
                                .attr({ href: value["file_path"] });
                            $(cloneFigure)
                                .find("img")
                                .attr({ src: value["file_path"] });
                        });
                        $(noticeCard).find("figure.hide").remove();
                        initPhotoSwipeFromDOM(".my-gallery");
                    }

                    // 管理者の場合JSONデータを保持する
                    if (userType == "admin") {
                        var images = [];
                        $.each(response["gallery"], function (key, value) {
                            // プッシュする
                            images.push({
                                id: response["id"],
                                path: value["file_path"],
                                key: key,
                            });
                        });

                        var dir = $("#notice")
                            .find("input[name='notice_dir']")
                            .val();
                        $("#delete-notice")
                            .find("input[name='id']")
                            .val(response["id"]);
                        $("#delete-notice")
                            .find("input[name='dir_path']")
                            .val(dir + response["dir"]);
                        $("#modal-edit-notice")
                            .find("input[name='id']")
                            .val(response["id"]);
                        $("#modal-edit-notice")
                            .find("input[name='json_data']")
                            .val(JSON.stringify(images));
                    }
                },

                // モーダル非表示完了コールバック
                complete: function () {
                    // ユーザーの場合
                    if (userType == "user") {
                        console.log($this);
                        $clone = $($(this)[0]["$el"]).find(".clone");
                        // アーカイブリンクにモーダル表示時のイイネを反映する
                        $this.find('.count').text($clone.closest('#modal-notice')
                            .find('.modal-footer').find('.count').text());
                        if ($clone.closest('#modal-notice')
                                .find('.modal-footer__a-favorite').hasClass('red')) {

                            $this.find('.li-linkbox__a-favorite').addClass('red');
                            $this.find('.li-linkbox__a-favorite').removeClass('grey');
                        } else {
                            $this.find('.li-linkbox__a-favorite').addClass('grey');
                            $this.find('.li-linkbox__a-favorite').removeClass('red');
                        }

                        // モーダル非表示した時は、背景画面のスクロールを解除する
                        $("body").removeClass("fixed").css({ top: 0 });
                        window.scrollTo(0, scrollPosition);
                        $clone.remove();
                    } else if (userType == "admin") {
                        //スタッフの場合
                        // モーダルフォームをクリアする
                        $("#modal-edit-notice").find(".card-img").remove();
                        $("#modal-edit-notice")
                            .find("#modal-image-file")
                            .replaceWith(
                                $("#modal-image-file").val("").clone(true)
                            );
                        $("#modal-edit-notice")
                            .find("input[name='modal_file_path']")
                            .val("");
                        // モーダルを初期化
                        resetModal();
                        // モーダル非表示した時は、背景画面のスクロールを解除する
                        $("body").removeClass("fixed").css({ top: 0 });
                        window.scrollTo(0, scrollPosition);
                        $(".modal-edit-notice").addClass("hide");
                        $("#view-notice").removeClass("hide");
                        $("#view-notice").find(".clone").remove();
                        $(".updateBtn").addClass("disabled");
                    }
                    $(".tooltipped").tooltip({ delay: 50 });
                },
            });
            $("#modal-notice").modal("open");
        },
        error: function (response, textStatus, xhr) {
            $.notifyBar({
                cssClass: "error",
                html: "通信に失敗しました。ステータス：" + textStatus,
            });
        },
    });
};

/**
 * @description モーダルお知らせ表示 ユーザー、店舗お知らせのみで使用
 * @param  {} $form
 * @param  {} userType
 */
var callModalNewsWithAjax = function ($form, $this, userType) {
    $.ajax({
        url: $form.attr("action"), //Formのアクションを取得して指定する
        type: $form.attr("method"), //Formのメソッドを取得して指定する
        data: $form.serialize(), //データにFormがserialzeした結果を入れる
        dataType: "json", //データにFormがserialzeした結果を入れる
        timeout: 30000,
        beforeSend: function (xhr, settings) {
            // 他のアーカイブリンクを無効化する
            $(".archiveLink").each(function (i, elem) {
                $(elem).css("pointer-events", "none");
            });
            //処理中のを通知するアイコンを表示する
            $("#dummy").load("/module/Preloader.ctp");
        },
        complete: function (xhr, textStatus) {
            // 他のアーカイブリンクを有効化する
            $(".archiveLink").each(function (i, elem) {
                $(elem).css("pointer-events", "");
            });
            //処理中アイコン削除
            $(".preloader-wrapper").remove();
        },
        success: function (response, dataType) {
            $("#modal-news").modal({
                dismissible: true, // Modal can be dismissed by clicking outside of the modal
                opacity: 0.2, // Opacity of modal background
                inDuration: 300, // Transition in duration
                outDuration: 200, // Transition out duration
                startingTop: "4%", // Starting top style attribute
                endingTop: "10%", // Ending top style attribute
                // モーダル表示完了コールバック
                ready: function () {
                    scrollPosition = $(window).scrollTop();
                    // モーダル表示してる時は、背景画面のスクロールを禁止する
                    $("body").addClass("fixed").css({ top: -scrollPosition });
                    // スタッフのお知らせディレクトリを取得する
                    var newsDir =
                        $("input[name='news_dir']").val() + response["dir"];
                    // お知らせカードの要素を複製し、複製したやつを表示するようにする。
                    var newsCard = $(".news-card")
                        .clone(true)
                        .insertAfter(".news-card")
                        .addClass("clone")
                        .removeClass("hide");
                    // お知らせ内容の設定
                    $(newsCard)
                        .find("p[name='created']")
                        .text(response["ymd_created"]);
                    $(newsCard)
                        .find("p[name='title']")
                        .text(response["title"]);
                    $(newsCard)
                        .find("p[name='content']")
                        .textWithLF(response["content"]);
                    ajaxModalFavo(newsCard.closest('#modal-news')
                            .find('.modal-footer'), response, 'shop_infos');

                    // 画像表示するグリッドを決定する
                    if (response["gallery"].length > 0) {
                        var figure = $(newsCard).find("figure");
                        var imgClass = "";
                        $.each(response["gallery"], function (key, value) {
                            var cloneFigure = $(figure)
                                .clone(true)
                                .removeClass()
                                .insertAfter(figure);
                            $(cloneFigure)
                                .find("a")
                                .attr({ href: value["file_path"] });
                            $(cloneFigure)
                                .find("img")
                                .attr({ src: value["file_path"] });
                        });
                        $(newsCard).find("figure.hide").remove();
                        initPhotoSwipeFromDOM(".my-gallery");
                    }

                    // 管理者の場合JSONデータを保持する
                    if (userType == "admin") {
                        var images = [];
                        $.each(response["gallery"], function (key, value) {
                            // プッシュする
                            images.push({
                                id: response["id"],
                                path: value["file_path"],
                                key: key,
                            });
                        });

                        var dir = $("#news")
                            .find("input[name='news_dir']")
                            .val();
                        $("#delete-news")
                            .find("input[name='id']")
                            .val(response["id"]);
                        $("#delete-news")
                            .find("input[name='dir_path']")
                            .val(dir + response["dir"]);
                        $("#modal-edit-news")
                            .find("input[name='id']")
                            .val(response["id"]);
                        $("#modal-edit-news")
                            .find("input[name='json_data']")
                            .val(JSON.stringify(images));
                    }
                },

                // モーダル非表示完了コールバック
                complete: function () {
                    // ユーザーの場合
                    if (userType == "user") {
                        console.log($this);
                        $clone = $($(this)[0]["$el"]).find(".clone");
                        // アーカイブリンクにモーダル表示時のイイネを反映する
                        $this.find('.count').text($clone.closest('#modal-news')
                            .find('.modal-footer').find('.count').text());
                        if ($clone.closest('#modal-news')
                                .find('.modal-footer__a-favorite').hasClass('red')) {

                            $this.find('.li-linkbox__a-favorite').addClass('red');
                            $this.find('.li-linkbox__a-favorite').removeClass('grey');
                        } else {
                            $this.find('.li-linkbox__a-favorite').addClass('grey');
                            $this.find('.li-linkbox__a-favorite').removeClass('red');
                        }

                        // モーダル非表示した時は、背景画面のスクロールを解除する
                        $("body").removeClass("fixed").css({ top: 0 });
                        window.scrollTo(0, scrollPosition);
                        $clone.remove();
                    } else if (userType == "admin") {
                        //スタッフの場合
                        // モーダルフォームをクリアする
                        $("#modal-edit-news").find(".card-img").remove();
                        $("#modal-edit-news")
                            .find("#modal-image-file")
                            .replaceWith(
                                $("#modal-image-file").val("").clone(true)
                            );
                        $("#modal-edit-news")
                            .find("input[name='modal_file_path']")
                            .val("");
                        // モーダルを初期化
                        resetModal();
                        // モーダル非表示した時は、背景画面のスクロールを解除する
                        $("body").removeClass("fixed").css({ top: 0 });
                        window.scrollTo(0, scrollPosition);
                        $(".modal-edit-news").addClass("hide");
                        $("#view-news").removeClass("hide");
                        $("#view-news").find(".clone").remove();
                        $(".updateBtn").addClass("disabled");
                    }
                    $(".tooltipped").tooltip({ delay: 50 });
                },
            });
            $("#modal-news").modal("open");
        },
        error: function (response, textStatus, xhr) {
            $.notifyBar({
                cssClass: "error",
                html: "通信に失敗しました。ステータス：" + textStatus,
            });
        },
    });
};

/**
 * @description モーダルニュース、日記のお気に入り設定
 * @param  {} $like
 */
var ajaxModalFavo = function ($element, data, alias) {
    $element.find('.count').text(0);
    $element.find('.modal-footer__a-favorite').addClass('grey');
    if (alias == 'shop_infos') {
        $element.find('.modal-footer__a-favorite').data('shop_info_id', data['id']);
    } else if (alias == 'diarys') {
        $element.find('.modal-footer__a-favorite').data('diary_id', data['id']);
    }
    if (data['shop_info_likes']) {

        $element.find('.modal-footer__a-favorite').addClass('grey');

        if (data['shop_info_likes'].length == 0) {
            $element.find('.count').text(0);
        } else {
            $element.find('.count').text(data['shop_info_likes'][0]['total']);
            if (data['shop_info_likes'][0]['is_like'] == 1) {
                $element.find('.modal-footer__a-favorite').removeClass('grey');
                $element.find('.modal-footer__a-favorite').addClass('red');
            }
        }
    } else if (data['diary_likes']) {

        $element.find('.modal-footer__a-favorite').addClass('grey');

        if (data['diary_likes'].length == 0) {
            $element.find('.count').text(0);
        } else {
            $element.find('.count').text(data['diary_likes'][0]['total']);
            if (data['diary_likes'][0]['is_like'] == 1) {
                $element.find('.modal-footer__a-favorite').removeClass('grey');
                $element.find('.modal-footer__a-favorite').addClass('red');
            }
        }
    }

}

/**
 * スタッフ画面の初期化処理
 */
function initializeCast() {
    // 通常モーダルの初期化処理(個別に設定する場合は、この処理の下に再初期化すること)
    $(".modal").modal({
        ready: function () {
            scrollPosition = $(window).scrollTop();
            // モーダル表示してる時は、背景画面のスクロールを禁止する
            $("body").addClass("fixed").css({ top: -scrollPosition });
        },
        // モーダル非表示完了コールバック
        complete: function () {
            // モーダル非表示した時は、背景画面のスクロールを解除する
            $("body").removeClass("fixed").css({ top: 0 });
            window.scrollTo(0, scrollPosition);
        },
    });

    birthdayPickerIni();

    /* ダッシュボード 画面 START */
    if ($("#dashboard").length) {
        fullcalendarSetting();

        // 登録,更新,削除ボタン押した時
        $(document).on(
            "click",
            ".createBtn, .updateBtn, .deleteBtn",
            function () {
                var $dashboard = $("#dashboard");
                var $form = $("#edit-calendar");
                var action = $(this).data("action");
                var radio = $($form)
                    .find('input[name="title"]:checked')
                    .attr("id");
                var timeStart = $($form)
                    .find('select[name="time_start"]')
                    .val();
                var timeEnd = $($form).find('select[name="time_end"]').val();
                if (timeStart != null) {
                    $($form)
                        .find("input[name='start']")
                        .val(
                            $($form).find("input[name='start']").val() +
                                " " +
                                timeStart
                        );
                }
                // TODO: sart日時は必ず生成されるけど、end日時はstartのHH:MMを超えると生成される。
                if (timeEnd != null) {
                    $($form)
                        .find("input[name='end']")
                        .val(
                            $($form).find("input[name='end']").val() +
                                " " +
                                timeEnd
                        );
                }
                $($form)
                    .find("input[type='hidden'] + input[name='all_day']")
                    .val(function () {
                        return $($form)
                            .find("input[id='all-day']")
                            .prop("checked")
                            ? 1
                            : 0;
                    });
                // アクションタイプをhiddenにセットする。コントローラー側で処理分岐のために。
                $($form).find("input[name='crud_type']").val(action);
                if (action == "create" || action == "update") {
                    if (radio == "work") {
                        if (timeStart == null) {
                            alert(
                                "仕事の場合、最低でも出勤時間は選択して下さい。"
                            );
                            return;
                        }
                    }
                }
                $.ajax({
                    url: $form.attr("action"), //Formのアクションを取得して指定する
                    type: $form.attr("method"), //Formのメソッドを取得して指定する
                    data: $form.serialize(), //データにFormがserialzeした結果を入れる
                    dataType: "json", //データにFormがserialzeした結果を入れる
                    timeout: 30000,
                    beforeSend: function (xhr, settings) {
                        //Buttonを無効にする
                        $($form).find("button").attr("disabled", true);
                        $("#modal-calendar").modal("close");
                        //処理中を通知するアイコンを表示する
                        $("#dummy").load("/module/Preloader.ctp");
                    },
                    complete: function (xhr, textStatus) {
                        //Buttonを有効にする
                        $(".preloader-wrapper").remove();
                        $($form).find("button").attr("disabled", false);
                        $("#calendar").fullCalendar("refetchEvents");
                    },
                    success: function (response, textStatus, xhr) {
                        // OKの場合
                        if (response) {
                            $.notifyBar({
                                cssClass: "success",
                                html: response.message,
                            });
                        } else {
                            // NGの場合
                            $.notifyBar({
                                cssClass: "error",
                                html: response.error,
                            });
                        }
                    },
                    error: function (response, textStatus, xhr) {
                        $.notifyBar({
                            cssClass: "error",
                            html:
                                "通信に失敗しました。ステータス：" + textStatus,
                        });
                    },
                });
            }
        );
    }
    /* ダッシュボード 画面 END */

    /* プロフィール 画面 START */
    if ($("#profile").length) {
        var $profile = $("#profile");
        var profile = JSON.parse(
            $($profile).find('input[name="json_data"]').val()
        );
        var birthday = $("#birthday").pickadate("picker"); // Date Picker
        birthday.set("select", [2000, 1, 1]);
        birthday.set("select", new Date(2000, 1, 1));
        birthday.set("select", profile["birthday"], { format: "yyyy-mm-dd" });
        $("textarea").trigger("autoresize"); // テキストエリアを入力文字の幅によりリサイズする
        $("select").material_select();

        // 画像を選択した時
        $(document).on("change", "#image-file", function () {
            var $form = $(this).closest("form");
            var file = this.files[0];
            var img = new Image();
            loadImage.parseMetaData(file, (data) => {
                var options = {
                    canvas: true,
                };
                if (data.exif) {
                    options.orientation = data.exif.get("Orientation");
                }
                loadImage(
                    file,
                    (canvas) => {
                        var dataUri = canvas.toDataURL("image/jpeg");

                        img.src = dataUri;
                        $(document).find("img").attr({ src: dataUri });
                    },
                    options
                );
                // 画像が読み込まれてから処理
                img.onload = function () {
                    // IMGのセレクタ取得
                    var $selecter = $(document).find("img");
                    // ファイル変換
                    var blobList = fileConvert("#image-canvas", $selecter);

                    // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                    // POSTでリクエスト内のデータが全部なくなるので。
                    // TODO: 後で対策を考えよう
                    $($form).find("#image-file, .file-path").val("");

                    // アップロード用blobをformDataに設定
                    var formData = new FormData($form.get()[0]);
                    formData.append("image", blobList[0]);

                    //通常のアクションをキャンセルする
                    event.preventDefault();
                    fileUpAjaxCommon($form, formData, $("#wrapper"));
                };
            });
        });
        // 入力フォームに変更があった時
        $(document)
            .find($profile)
            .on("input", function () {
                $($profile).find(".saveBtn").removeClass("disabled");
            });
        // リストボックスを変更した時
        $(document).on("change", "select", function () {
            $($profile).find(".saveBtn").removeClass("disabled");
        });
        // 登録ボタン押した時
        $($profile)
            .find(".saveBtn")
            .on("click", function () {
                if (!confirm("こちらのプロフィール内容でよろしいですか？")) {
                    return false;
                }
                var $form = $("#save-profile");

                //通常のアクションをキャンセルする
                event.preventDefault();
                ajaxCommon($form, $("#wrapper"));
            });
    }
    /* プロフィール 画面 END */

    /* トップ画像 関連処理 START */
    if ($("#top-image").length) {
        // トップ画像 変更、やめるボタン押した時
        $(document).on("click", ".changeBtn", function () {
            // 画像をクリアする
            $("#top-image")
                .find("#top-image-show")
                .attr({ width: "", height: "", src: "" });
            $("#top-image").find('[name="top_image"]').val("");

            // 編集フォームが表示されている場合
            if ($("#save-top-image").css("display") == "block") {
                // ビュー表示
                $("#top-image").find("#save-top-image").hide();
                $("#top-image").find("#show-top-image").show();
            } else {
                // 編集表示
                $("#top-image").find("#save-top-image").show();
                $("#top-image").find("#show-top-image").hide();
            }
        });
        // トップ画像 登録ボタン押した時
        $(document).on("click", ".saveBtn", function () {
            //ファイル選択済みかチェック
            var fileCheck = $("#top-image-file").val().length;
            if (fileCheck === 0) {
                alert("画像ファイルを選択してください");
                return false;
            }
            if (!confirm("こちらの画像に変更でよろしいですか？")) {
                return false;
            }

            var $form = $("#save-top-image");

            // blobファイル変換
            var blobList = fileConvert(
                "#top-image-canvas",
                ".top-image-preview"
            );

            // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
            // POSTでリクエスト内のデータが全部なくなるので。
            // TODO: 後で対策を考えよう
            $($form).find('input[name="top_image_file"]').val("");

            // アップロード用blobをformDataに設定
            var formData = new FormData($form.get()[0]);
            formData.append("top_image_file", blobList[0]);
            for (item of formData) {
                console.log(item);
            }
            //通常のアクションをキャンセルする
            event.preventDefault();
            fileUpAjaxCommon($form, formData, $("#wrapper"));
        });
    }
    /* トップ画像 関連処理 END */
    /* 日記 画面 START */
    if ($("#diary").length) {
        // 入力フォームに変更があった時
        $(document).on("input", "#title, #content", function () {
            $("#edit-diary").find(".createBtn").removeClass("disabled");
            $("#edit-diary").find(".cancelBtn").removeClass("disabled");
        });
        // モーダル日記の入力フォームに変更があった時
        $(document).on("input", "#modal-title, #modal-content", function () {
            $(".updateBtn").removeClass("disabled");
        });
        // 画像を選択した時
        $(document).on("change", "#image-file", function () {
            $("#edit-diary").find(".createBtn").removeClass("disabled");
            $("#edit-diary").find(".cancelBtn").removeClass("disabled");
            canvasRender("#diary", this, true);
        });
        // モーダル日記で画像を選択した時
        $(document).on("change", "#modal-image-file", function () {
            $(".updateBtn").removeClass("disabled");
            canvasRender("#modal-diary", this, true);
        });

        // 登録ボタン押した時
        $(document).on("click", ".createBtn", function () {
            var form = $("#edit-diary");
            if (formValidete(form)) {
                return false;
            }

            if (!confirm("こちらの日記内容でよろしいですか？")) {
                return false;
            }

            var fileCheck = $("#diary").find("#image-file").val().length;

            //ファイル選択済みの場合はajax処理を切り替える
            if (fileCheck > 0) {
                // 新しく追加された画像のみを対象にする
                var $selecter = $(".card-img").find("img");

                // ファイル変換
                var blobList = fileConvert("#image-canvas", $selecter);

                // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                // POSTでリクエスト内のデータが全部なくなるので。
                // TODO: 後で対策を考えよう
                $(form).find("#image-file, .file-path").val("");

                //アップロード用blobをformDataに設定
                formData = new FormData(form.get()[0]);
                for (item of blobList) {
                    formData.append("image[]", item);
                }
                // for (item of formData) {
                //     console.log(item);
                // }
                //通常のアクションをキャンセルする
                event.preventDefault();
                fileUpAjaxCommon(form, formData, $("#wrapper"));
            } else {
                ajaxCommon(form, $("#wrapper"));
            }
        });
        // 更新ボタン押した時
        $(document).on("click", ".updateBtn", function () {
            var form = $("#modal-edit-diary");
            if (formValidete(form)) {
                return false;
            }

            // アクションタイプをhiddenにセットする。コントローラー側で処理分岐のために。
            var oldImgList = $(".card-img").not(".new"); // 既に登録した画像リスト
            var newImgList = $(".card-img.new").find("img"); // 追加した画像リスト
            var delList = new Array(); // 削除対象リスト
            if (
                $("#modal-edit-diary").find("input[name='json_data']").val() !=
                ""
            ) {
                delList = JSON.parse(
                    $("#modal-edit-diary").find("input[name='json_data']").val()
                );
            }
            // 既に登録した画像リストを元に削除対象を絞る
            $(oldImgList).each(function (i, elm1) {
                $.each(delList, function (i, elm2) {
                    if ($(elm1).find("input[name='path']").val() == elm2.path) {
                        delList.splice(i, 1);
                        return false;
                    }
                });
            });
            var form = $("#modal-edit-diary");
            $(form).find("input[name='del_list']").val(JSON.stringify(delList));
            $(form)
                .find("input[name='diary_id']")
                .val($("#delete-diary").find("input[name='id']").val());
            $(form)
                .find("input[name='dir_path']")
                .val($("#delete-diary").find("input[name='dir_path']").val());
            $(form).find(".card-img input").remove();

            var fileCheck = $(form).find("#modal-image-file").val().length;
            //ファイル選択済みの場合はajax処理を切り替える
            if (fileCheck > 0) {
                // 新しく追加された画像のみを対象にする
                var $selecter = $(".card-img.new").find("img");

                // ファイル変換
                var blobList = fileConvert("#image-canvas", $selecter);

                var cloneForm = $(form).clone(true);
                // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                // POSTでリクエスト内のデータが全部なくなるので。
                // TODO: 後で対策を考えよう
                $(cloneForm)
                    .find("#modal-image-file, .modal-file-path")
                    .val("");

                //アップロード用blobをformDataに設定
                formData = new FormData(cloneForm.get()[0]);

                for (item of blobList) {
                    formData.append("image[]", item);
                }
                // for (item of formData) {
                //     console.log(item);
                // }
                //通常のアクションをキャンセルする
                event.preventDefault();
                fileUpAjaxCommon(cloneForm, formData, $("#wrapper"));
            } else {
                ajaxCommon(form, $("#wrapper"));
            }
        });
        // キャンセルボタン押した時
        $("#diary").on("click", ".cancelBtn", function () {
            if (!confirm("取り消しますか？")) {
                return false;
            }
            $("#diary").find(".createBtn").addClass("disabled");
            $("#diary").find(".updateBtn").addClass("disabled");
            $("#diary").find(".cancelBtn").addClass("disabled");
            $("#diary")
                .find("#title, #content, #image-file, #file-path")
                .val("");
            $("#diary").find(".card-img").remove();
        });

        // アーカイブ日記をクリックした時
        $(document).on("click", ".archiveLink", function () {
            var $form = $("#view-archive-diary");
            $($form)
                .find("input[name='id']")
                .val($(this).find("input[name='id']").val());
            //通常のアクションをキャンセルする
            event.preventDefault();
            callModalDiaryWithAjax($form, null, "admin");
            $(".materialboxed").materialbox();
        });
        // モーダル日記の更新モードボタン押した時
        $(document).on("click", ".updateModeBtn", function () {
            $("#modal-diary").find(".updateModeBtn").addClass("hide");
            $("#modal-diary").find(".returnBtn").removeClass("hide");
            // アクションタイプをhiddenにセットする。コントローラー側で処理分岐のために。
            $("#modal-edit-diary").find("input[name='_method']").val("POST");
            $("#modal-edit-diary")
                .find("input[name='title']")
                .val($(".diary-card.clone").find("p[name='title']").text());
            $("#modal-edit-diary")
                .find("textarea[name='content']")
                .val(
                    $(".diary-card.clone")
                        .find("p[name='content']")
                        .textWithLF()
                );
            $("textarea").trigger("autoresize"); // テキストエリアを入力文字の幅によりリサイズする
            // 画像が１つ以上ある場合にmaterialboxed生成
            if (
                $("#modal-edit-diary").find("input[name='json_data']").val()
                    .length > 0
            ) {
                var images = JSON.parse(
                    $("#modal-edit-diary").find("input[name='json_data']").val()
                );
                $.get("/module/materialboxed.ctp", {}, function (html) {
                    var materialTmp = $(html).clone(); // materialboxedの部品を複製しておく
                    $(materialTmp).removeClass("new"); // newバッチを削除する
                    $(materialTmp).find("span.new").remove(); // newバッチを削除する
                    var materials = $();
                    $.each(images, function (index, image) {
                        var material = $(materialTmp).clone();
                        $(material).find("input[name='id']").val(image["id"]);
                        //$(material).find("input[name='name']").val(image['name']);
                        $(material).find("input[name='key']").val(image["key"]);
                        $(material)
                            .find("input[name='path']")
                            .val(image["path"]);
                        $(material).find("img").attr("src", image["path"]);
                        materials = materials.add(material);
                    });
                    $(".modal-edit-diary").find(".row").append(materials);
                    $(".materialboxed").materialbox();
                    Materialize.updateTextFields();
                    $(".tooltipped").tooltip({ delay: 50 });
                });
            }
            // 更新画面を表示する
            $(".modal-edit-diary").removeClass("hide");
            $("#view-diary").addClass("hide");
        });
        // モーダル日記の戻るボタン押した時
        $(document).on("click", ".returnBtn", function () {
            // 画像フォームをクリアする
            $("#modal-edit-diary").find(".card-img").remove();
            $("#modal-edit-diary")
                .find("#modal-image-file")
                .replaceWith($("#modal-image-file").val("").clone(true));
            $("#modal-edit-diary")
                .find("input[name='modal_file_path']")
                .val("");
            // 通常の表示モードに切り替える。
            $("#modal-diary").find(".updateModeBtn").removeClass("hide");
            $("#modal-diary").find(".returnBtn").addClass("hide");
            $(".modal-edit-diary").addClass("hide");
            $("#view-diary").removeClass("hide");
            $("#modal-diary").find(".updateBtn").addClass("disabled");
            $(".modal-edit-diary").find("input[name='title']").val("");
            $(".modal-edit-diary").find("textarea[name='content']").text("");
            $(".modal-edit-diary").find("textarea").trigger("autoresize");
            //resetModal();
        });
        // モーダル日記の削除ボタン押した時
        $(document).on("click", ".deleteBtn", function () {
            // 画像の削除ボタンの場合
            if ($(this).data("delete") == "image") {
                var $image = $(this).closest(".card-img");
                // var serachName = $newImage.find("input[name='name']").val();
                $(".tooltipped").tooltip({ delay: 50 });
                $image.remove();
                $("#modal-diary").find(".updateBtn").removeClass("disabled");
                return;
            }
            // 日記削除の場合
            if (!confirm("この日記を削除しますか？")) {
                return false;
            }

            var $form = $('form[id="delete-diary"]');

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#wrapper"));
            $("#modal-diary").modal("close");
        });
    }
    /* 日記 画面 END */
    /* ギャラリー 画面 START */
    if ($("#gallery").length) {
        // ギャラリー 削除ボタン押した時
        $(document).on("click", ".deleteBtn", function () {
            var filePath = $(this).data("delete");

            if (!confirm("選択したギャラリーを削除してもよろしいですか？")) {
                return false;
            }
            var $form = $('form[id="delete-gallery"]');
            $($form).find("input[name='file_path']").val(filePath);

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#wrapper"));
        });
        // ギャラリー 画像を選択した時
        $(document).on("change", "#image-file", function () {
            if ($("#image-file").prop("files").length == 0) {
                $(".cancelBtn").addClass("disabled");
                $(".createBtn").addClass("disabled");
            } else {
                $(".cancelBtn").removeClass("disabled");
                $(".createBtn").removeClass("disabled");
            }
            $(document).find(".card-img.new").remove();
            var fileList = $("#image-file").prop("files");
            var imgCount = $(".card-img").length;
            var fimeMax = $("input[name='file_max']").val();
            var modulePath = "/module/materialboxed.ctp";

            $.each(fileList, function (index, file) {
                //画像ファイルかチェック
                if (
                    file["type"] != "image/jpeg" &&
                    file["type"] != "image/png" &&
                    file["type"] != "image/gif"
                ) {
                    alert("jpgかpngかgifファイルを選択してください");
                    $("#image-file").val("");
                    return false;
                }
            });
            // ファイル数を制限する
            if (fileList.length + imgCount > fimeMax) {
                alert(
                    "アップロードできる画像は" + fimeMax + "ファイルまでです。"
                );
                resetBtn($(document), true);
                return false;
            }
            for (var i = 0; i < fileList.length; i++) {
                imgCount += 1;
                fileload(fileList[i], $("#gallery .row"), imgCount, modulePath);
            }
        });
        // ギャラリー 登録ボタン押した時
        $(document).on("click", ".saveBtn", function () {
            //ファイル選択済みかチェック
            var fileCheck = $("#image-file").val().length;
            if (fileCheck === 0) {
                alert("画像ファイルを選択してください");
                return false;
            }
            if (!confirm("こちらの画像に変更でよろしいですか？")) {
                return false;
            }
            // 新しく追加された画像のみを対象にする
            var $selecter = $(".card-img.new").find("img");

            var $form = $("#save-gallery");
            // ファイル変換
            var blobList = fileConvert("#image-canvas", $selecter);

            // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
            // POSTでリクエスト内のデータが全部なくなるので。
            // TODO: 後で対策を考えよう
            $($form).find("#image-file, .file-path").val("");

            //アップロード用blobをformDataに設定
            formData = new FormData($form.get()[0]);
            for (item of blobList) {
                formData.append("image[]", item);
            }
            // for (item of formData) {
            //     console.log(item);
            // }
            //通常のアクションをキャンセルする
            event.preventDefault();
            fileUpAjaxCommon($form, formData, $("#wrapper"));
        });
        // ギャラリー やめるボタン押した時
        $(document).on("click", ".chancelBtn", function () {
            // newタグが付いたファイルを表示エリアから削除する
            $("#gallery").find(".card-img.new").remove();
            // フォーム入力も削除する
            $("#gallery").find("#image-file, .file-path").val("");
        });
    }
    /* ギャラリー 画面 END */
    /* SNS 画面 START */
    if ($("#sns").length) {
        var $sns = $("#sns");
        $("textarea").trigger("autoresize"); // テキストエリアを入力文字の幅によりリサイズする

        // 入力フォームに変更があった時
        $(document)
            .find($sns)
            .on("input", function () {
                $($sns).find(".saveBtn").removeClass("disabled");
            });

        // 登録ボタン押した時
        $($sns)
            .find(".saveBtn")
            .on("click", function () {
                if (!confirm("こちらの内容でよろしいですか？")) {
                    return false;
                }
                var $form = $("#save-sns");

                //通常のアクションをキャンセルする
                event.preventDefault();
                ajaxCommon($form, $("#wrapper"));
            });
    }
    /* SNS 画面 END */
}

/**
 * デベロッパ画面の初期化処理
 */
function initializeDeveloper() {
    /* ニュース 画面 START */
    if ($("#news").length) {
        // 入力フォームに変更があった時
        $(document).on("input", "#title, #content, #image-file", function () {
            $("#edit-news").find(".createBtn").removeClass("disabled");
            $("#edit-news").find(".cancelBtn").removeClass("disabled");
        });
        // モーダルニュースの入力フォームに変更があった時
        $(document).on(
            "input",
            "#modal-title, #modal-content, #modal-image-file",
            function () {
                $(".updateBtn").removeClass("disabled");
            }
        );
        // 画像を選択した時
        $(document).on("change", "#image-file", function () {
            canvasRender("#news", this, true);
        });
        // モーダルニュースで画像を選択した時
        $(document).on("change", "#modal-image-file", function () {
            canvasRender("#modal-news", this, true);
        });
        // 登録ボタン押した時
        $(document).on("click", ".createBtn", function () {
            var form = $("#edit-news");
            if (formValidete(form)) {
                return false;
            }

            if (!confirm("こちらのニュース内容でよろしいですか？")) {
                return false;
            }

            var fileCheck = $("#news").find("#image-file").val().length;

            //ファイル選択済みの場合はajax処理を切り替える
            if (fileCheck > 0) {
                // 新しく追加された画像のみを対象にする
                var $selecter = $(".card-img").find("img");

                // ファイル変換
                var blobList = fileConvert("#image-canvas", $selecter);

                // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                // POSTでリクエスト内のデータが全部なくなるので。
                // TODO: 後で対策を考えよう
                $(form).find("#image-file, .file-path").val("");

                //アップロード用blobをformDataに設定
                formData = new FormData(form.get()[0]);
                for (item of blobList) {
                    formData.append("image[]", item);
                }
                // for (item of formData) {
                //     console.log(item);
                // }
                //通常のアクションをキャンセルする
                event.preventDefault();
                fileUpAjaxCommon(form, formData, $("#wrapper"));
            } else {
                ajaxCommon(form, $("#wrapper"));
            }
        });

        // 更新ボタン押した時
        $(document).on("click", ".updateBtn", function () {
            var form = $("#modal-edit-news");
            if (formValidete(form)) {
                return false;
            }

            // アクションタイプをhiddenにセットする。コントローラー側で処理分岐のために。
            var oldImgList = $(".card-img").not(".new"); // 既に登録した画像リスト
            var newImgList = $(".card-img.new").find("img"); // 追加した画像リスト
            var delList = new Array(); // 削除対象リスト
            if (
                $("#modal-edit-news").find("input[name='json_data']").val() !=
                ""
            ) {
                delList = JSON.parse(
                    $("#modal-edit-news")
                        .find("input[name='json_data']")
                        .val()
                );
            }
            // 既に登録した画像リストを元に削除対象を絞る
            $(oldImgList).each(function (i, elm1) {
                $.each(delList, function (i, elm2) {
                    if ($(elm1).find("input[name='path']").val() == elm2.path) {
                        delList.splice(i, 1);
                        return false;
                    }
                });
            });
            var form = $("#modal-edit-news");
            $(form).find("input[name='del_list']").val(JSON.stringify(delList));
            $(form)
                .find("input[name='news_id']")
                .val($("#delete-news").find("input[name='id']").val());
            $(form)
                .find("input[name='dir_path']")
                .val($("#delete-news").find("input[name='dir_path']").val());
            $(form).find(".card-img input").remove();

            var fileCheck = $(form).find("#modal-image-file").val().length;
            //ファイル選択済みの場合はajax処理を切り替える
            if (fileCheck > 0) {
                // 新しく追加された画像のみを対象にする
                var $selecter = $(".card-img.new").find("img");

                // ファイル変換
                var blobList = fileConvert("#image-canvas", $selecter);

                var cloneForm = $(form).clone(true);
                // サイズの大きい画像は、POSTで弾かれるので、フォーム内容は消す。
                // POSTでリクエスト内のデータが全部なくなるので。
                // TODO: 後で対策を考えよう
                $(cloneForm)
                    .find("#modal-image-file, .modal-file-path")
                    .val("");

                //アップロード用blobをformDataに設定
                formData = new FormData(cloneForm.get()[0]);

                for (item of blobList) {
                    formData.append("image[]", item);
                }
                // for (item of formData) {
                //     console.log(item);
                // }
                //通常のアクションをキャンセルする
                event.preventDefault();
                fileUpAjaxCommon(cloneForm, formData, $("#wrapper"));
            } else {
                ajaxCommon(form, $("#wrapper"));
            }
        });
        // キャンセルボタン押した時
        $("#news").on("click", ".cancelBtn", function () {
            if (!confirm("取り消しますか？")) {
                return false;
            }
            $("#news").find(".createBtn").addClass("disabled");
            $("#news").find(".updateBtn").addClass("disabled");
            $("#news").find(".cancelBtn").addClass("disabled");
            $("#news")
                .find("#title, #content, #image-file, #file-path")
                .val("");
            $("#news").find(".card-img").remove();
        });

        // アーカイブニュースをクリックした時
        $(document).on("click", ".archiveLink", function () {
            var $form = $("#view-archive-news");
            $($form)
                .find("input[name='id']")
                .val($(this).find("input[name='id']").val());
            //通常のアクションをキャンセルする
            event.preventDefault();
            callModalNewsWithAjax($form, null, "admin");
            $(".materialboxed").materialbox();
        });
        // モーダルニュースの更新モードボタン押した時
        $(document).on("click", ".updateModeBtn", function () {
            $("#modal-news").find(".updateModeBtn").addClass("hide");
            $("#modal-news").find(".returnBtn").removeClass("hide");
            // アクションタイプをhiddenにセットする。コントローラー側で処理分岐のために。
            $("#modal-edit-news").find("input[name='_method']").val("POST");
            $("#modal-edit-news")
                .find("input[name='title']")
                .val($(".news-card.clone").find("p[name='title']").text());
            $("#modal-edit-news")
                .find("textarea[name='content']")
                .val(
                    $(".news-card.clone")
                        .find("p[name='content']")
                        .textWithLF()
                );
            $("textarea").trigger("autoresize"); // テキストエリアを入力文字の幅によりリサイズする
            // 画像が１つ以上ある場合にmaterialboxed生成
            if (
                $("#modal-edit-news").find("input[name='json_data']").val()
                    .length > 0
            ) {
                var images = JSON.parse(
                    $("#modal-edit-news")
                        .find("input[name='json_data']")
                        .val()
                );
                $.get("/module/materialboxed.ctp", {}, function (html) {
                    var materialTmp = $(html).clone(); // materialboxedの部品を複製しておく
                    $(materialTmp).removeClass("new"); // newバッチを削除する
                    $(materialTmp).find("span.new").remove(); // newバッチを削除する
                    var materials = $();
                    $.each(images, function (index, image) {
                        var material = $(materialTmp).clone();
                        $(material).find("input[name='id']").val(image["id"]);
                        //$(material).find("input[name='name']").val(image['name']);
                        $(material).find("input[name='key']").val(image["key"]);
                        $(material)
                            .find("input[name='path']")
                            .val(image["path"]);
                        $(material).find("img").attr("src", image["path"]);
                        materials = materials.add(material);
                    });
                    $(".modal-edit-news").find(".row").append(materials);
                    $(".materialboxed").materialbox();
                    Materialize.updateTextFields();
                    $(".tooltipped").tooltip({ delay: 50 });
                });
            }
            // 更新画面を表示する
            $(".modal-edit-news").removeClass("hide");
            $("#view-news").addClass("hide");
        });
        // モーダルニュースの戻るボタン押した時
        $(document).on("click", ".returnBtn", function () {
            // 画像フォームをクリアする
            $("#modal-edit-news").find(".card-img").remove();
            $("#modal-edit-news")
                .find("#modal-image-file")
                .replaceWith($("#modal-image-file").val("").clone(true));
            $("#modal-edit-news")
                .find("input[name='modal_file_path']")
                .val("");
            // 通常の表示モードに切り替える。
            $("#modal-news").find(".updateModeBtn").removeClass("hide");
            $("#modal-news").find(".returnBtn").addClass("hide");
            $(".modal-edit-news").addClass("hide");
            $("#view-news").removeClass("hide");
            $("#modal-news").find(".updateBtn").addClass("disabled");
            $(".modal-edit-news").find("input[name='title']").val("");
            $(".modal-edit-news").find("textarea[name='content']").text("");
            $(".modal-edit-news").find("textarea").trigger("autoresize");
            //resetModal();
        });
        // モーダルニュースの削除ボタン押した時
        $(document).on("click", ".deleteBtn", function () {
            // 画像の削除ボタンの場合
            if ($(this).data("delete") == "image") {
                var $image = $(this).closest(".card-img");
                // var serachName = $newImage.find("input[name='name']").val();
                $(".tooltipped").tooltip({ delay: 50 });
                $image.remove();
                $("#modal-news").find(".updateBtn").removeClass("disabled");
                return;
            }
            // ニュース削除の場合
            if (!confirm("このニュースを削除しますか？")) {
                return false;
            }

            var $form = $('form[id="delete-news"]');

            //通常のアクションをキャンセルする
            event.preventDefault();
            ajaxCommon($form, $("#wrapper"));
            $("#modal-news").modal("close");
        });
    }
    /* ニュース 画面 END */
}


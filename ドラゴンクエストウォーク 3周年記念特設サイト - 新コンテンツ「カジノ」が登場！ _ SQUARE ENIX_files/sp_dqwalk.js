// 各タイトルごとにフッタ要素を変更
// Lightbox的にも出せるようにAJAX化
$(function(){
	sqexfooter_loaded();

});

function sqexfooter_loaded() {

var sqexFooter = {
    // footer html
    html: '<div id="sqex-footer-contents">'
        + '<div id="sqex-footer-contents-inner" class="clearfix">'
        + '<div class="sqex-footer-logos">'
        //プラットフォーム
        + '<img src="https://www.jp.square-enix.com/common/templates/images/footer/logo/sp_iphone_w.gif" alt="iPhone">'
        + '<img src="https://www.jp.square-enix.com/common/templates/images/footer/logo/sp_android_w.gif" alt="Android">'
        + '</div>'//end sqex-footer-logos
        + '<div class="sqex-footer-shares-wrap clearfix">'//without platform ver, add classname "logoless"
        + '<dl class="sqex-footer-shares">'
        + '<dd><a href="javascript:void(0);" class="facebook" onClick="gtag(\'event\', \'Facebook\', {\'event_category\' : \'FooterShareButton\', \'event_label\' : location.href });" title="Facebookでシェア"><img src="https://www.jp.square-enix.com/common/templates/images/footer/share_fb.png" alt="Facebookにシェアする" height="25"></a></dd>'
        + '<dd><a href="javascript:void(0);" class="twitter" onClick="gtag(\'event\', \'twitter\', {\'event_category\' : \'FooterShareButton\', \'event_label\' : location.href });" title="Twitterでシェア"><img src="https://www.jp.square-enix.com/common/templates/images/footer/share_tw.png" alt="Twitterにシェアする" height="25"></a></dd>'
        + '<dd><a href="http://line.naver.jp/R/msg/text/?%e3%83%89%e3%83%a9%e3%82%b4%e3%83%b3%e3%82%af%e3%82%a8%e3%82%b9%e3%83%88%e3%82%a6%e3%82%a9%e3%83%bc%e3%82%af%20%e5%85%ac%e5%bc%8f%e3%83%97%e3%83%ad%e3%83%a2%e3%83%bc%e3%82%b7%e3%83%a7%e3%83%b3%e3%82%b5%e3%82%a4%e3%83%88%20%7c%20SQUARE%20ENIX%20https%3a%2f%2fwww%2edragonquest%2ejp%2fwalk%2f" class="line" onClick="gtag(\'event\', \'LINE\', {\'event_category\' : \'FooterShareButton\', \'event_label\' : location.href });" target="_blank"><img src="https://www.jp.square-enix.com/common/templates/images/footer/share_ln.png" alt="LINEで送る" title="LINEで送る" style="vertical-align:top!important; width:25px;"></a></dd>'
        + '</dl>'
        + '</div>'//end sqex-footer-shares-wrap
        + '</div>'//end sqex-footer-contents-inner

        + '<ul class="clearfix">'
        + '<li><a href="https://www.jp.square-enix.com/caution.html" class="caution" target="_blank">著作権について</a></li>'
        + '<li><a href="https://www.dragonquest.jp/walk/privacy/" target="_blank">プライバシーポリシー</a></li>'
        + '<li><a href="https://support.jp.square-enix.com/jump.php" target="_blank">サポートセンター</a></li>'
        + '</ul>'
        + '<div class="sqex-footer-copy-logo"><p class="sqex-footer-copyright">&copy; 2019-2022 ARMOR PROJECT/BIRD STUDIO/SQUARE ENIX All Rights Reserved.</p></div>'
        + '</div>',//end sqex-footer-contents

    // dialog
    showDialog: function(contents) {
        $("#sqexFooterDialog").empty().html(contents).dialog({modal:true});
    }

};


    $("#sqexFooter").empty().html(sqexFooter.html);
	//$(".sqex-footer-white").addClass("column3");
    $("<div>").attr("id", "sqexFooterDialog").appendTo("body");
    // dialogs
    $("#sqexFooterItem, #sqexFooterBuy, #sqexFooter dl.sqex-footer-shares dd a").bind("click", function() {
        // some ajax code here to fetch contents
        // show dialog
        //sqexFooter.showDialog( $(this).attr("class") );
    })

    // Facebook
    $("#sqexFooter a.facebook").bind("click", function() {
        window.open(
            'http://www.facebook.com/sharer.php?u=https%3A%2F%2Fwww.jp.square-enix.com%2Fcommon%2Fr%2Fshare%2Fsp_dqwalk%2Fr_fb.html',
            'winFacebook',
            'toolbar=no,status=no,location=no,directories=no,menubar=no,scrollbars=no,width=558,height=360'
        );
    });
    // Twitter
    $("#sqexFooter a.twitter").bind("click", function() {
        window.open(
            'https://twitter.com/intent/tweet?text=%e3%83%89%e3%83%a9%e3%82%b4%e3%83%b3%e3%82%af%e3%82%a8%e3%82%b9%e3%83%88%e3%82%a6%e3%82%a9%e3%83%bc%e3%82%af%20%e5%85%ac%e5%bc%8f%e3%83%97%e3%83%ad%e3%83%a2%e3%83%bc%e3%82%b7%e3%83%a7%e3%83%b3%e3%82%b5%e3%82%a4%e3%83%88%20%7c%20SQUARE%20ENIX%20https://sqex.to/mhL5r',
            'winTwitter',
            'toolbar=no,status=no,location=no,directories=no,menubar=no,scrollbars=no,width=558,height=360'
        );
    });

}

(function($) {
  $.fn.cycle = function(arr, options) {
    var settings = {
        'delay': 2500,
        'transitionDuration': 200,
        'transitionEasing': 'linear'
    };

    if (options) $.extend(settings, options);
    return this.each(function(ndx, el) {
      $(el).data('cycle:i', 0);
      setInterval(function(el, settings, arr) {
          $(el).fadeOut(settings['transitionDuration'], settings['transitionEasing'], function() {
              var t = $(this);
              var i = t.data('cycle:i');
              i = i == arr.length - 1 ? 0 : i+1;
              t.data('cycle:i', i)
                  .html(arr[i])
                  .fadeIn(settings['transitionDuration'], settings['transitionEasing']);
              });
      }, settings['delay'], el, settings, arr);
    });
  };
})(jQuery);
var words =[
'請輸入文字，例如：朕知道了',
'請輸入文字，例如：朕看報紙才知道',
'請輸入文字，例如：都退下吧',
'請輸入文字，例如：愛卿多慮了',
'請輸入文字，例如：來人把他押下去',
'請輸入文字，例如：朕的坐騎是你',
'請輸入文字，例如：朕今日不早朝不批奏摺',
'請輸入文字，例如：朕肚子餓',
'請輸入文字，例如：胖知道了',
'請輸入文字，例如：君要臣死，臣欲仙欲死',
'請輸入文字，例如：朕要瘦身',
'請輸入文字，例如：娘娘請息怒',
'請輸入文字，例如：何苦為難本宮呢',
'請輸入文字，例如：奴婢今天找朕有事嗎',
'請輸入文字，例如：朕只幫正妹修電腦',
'請輸入文字，例如：朕要招少俠為武狀元',
'請輸入文字，例如：簡直是造反了',
'請輸入文字，例如：太后有旨，明日修養生息一日',
'請輸入文字，例如：朕只想要廢',
'請輸入文字，例如：朕胖了',
'請輸入文字，例如：朕嚇到了',
'請輸入文字，例如：朕還沒看新聞',
'請輸入文字，例如：朕宣布下班',
'請輸入文字，例如：知道了，跪安吧！',
'請輸入文字，例如：朕要睡到自然醒',
'請輸入文字，例如：本宮得試試這洋人的玩意',
'請輸入文字，例如：來人啊！把朕的鍘刀取來！',
'請輸入文字，例如：朕就是這樣的漢子',
'請輸入文字，例如：大膽，竟敢直喚本宮的小名！',
'請輸入文字，例如：明天上朝來見朕',
'請輸入文字，例如：誰快來幫朕關天窗',
'請輸入文字，例如：朕用此字，天下太平',
'請輸入文字，例如：朕怒了！',
'請輸入文字，例如：朕今日吃素',
'請輸入文字，例如：朕說這個星期天放假一日',
'請輸入文字，例如：丞相大人真精',
'請輸入文字，例如：朕明日欲微服出巡',
'請輸入文字，例如：朕今晚加班，晚膳命御膳房撤了吧！',
'請輸入文字，例如：朕認為此東西是好物，可永留',
'請輸入文字，例如：朕今日想去東郊狩獵',
'請輸入文字，例如：肥滿退散，欽此',
'請輸入文字，例如：朕成功了，朕驚了，朕客爽了',
'請輸入文字，例如：愛妃今日來朕這兒嗎？',
'請輸入文字，例如：本宮乏了',
'請輸入文字，例如：朕要廣納天下美女為妃',
'請輸入文字，例如：皇后讓奴才們都退下',
'請輸入文字，例如：朕近日龍體欠安',
'請輸入文字，例如：朕懶得理你',
'請輸入文字，例如：哀家鳳體微恙',
'請輸入文字，例如：你是朕的',
'請輸入文字，例如：朕要睡了，都跪安吧',
'請輸入文字，例如：朕近日龍體發福，臣工們有何良策？',
'請輸入文字，例如：朕每天早上都被自己帥醒',
'請輸入文字，例如：胖不給的，你不能要',
'請輸入文字，例如：皇上該翻牌子了',
'請輸入文字，例如：朕難過',
'請輸入文字，例如：朕在忙',
'請輸入文字，例如：朕在放空',
'請輸入文字，例如：所有人都給朕跪下',
'請輸入文字，例如：朕今日不想翻牌子，朕想翻桌子',
'請輸入文字，例如：有事稟報，無事退朝',
'請輸入文字，例如：朕說呵呵，卿還不呵',
'請輸入文字，例如：朕要上朝了',
'請輸入文字，例如：朕賜你一百甲良田，黃金萬兩',
'請輸入文字，例如：有了康熙字典體，即使大便也文青',
'請輸入文字，例如：你竟敢對朕下藥',
'請輸入文字，例如：朕今日早朝就想發廢文'
];
function shuffle(array) {
  var currentIndex = array.length
    , temporaryValue
    , randomIndex
    ;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

$('#placeholder').cycle(shuffle(words));


$(document).ready(function(){
	$("#placeholder").click(function() {
		$("#placeholder").css("z-index","-999");
		$('textarea#usertext').focus().attr("placeholder","請輸入文字");
	});
	$("textarea#usertext").click(function() {
		$('#placeholder').css("z-index","-999");
		$('textarea#usertext').attr("placeholder","請輸入文字");
	});


	//click outside to do something
	$('html').click(function() {
		if($('textarea#usertext').val()=='') {
			$('textarea#usertext').attr("placeholder","");
			$('#placeholder').css("z-index","999");
		}
	});
	$('textarea#usertext, #placeholder, #previewbtn').click(
		function(event){
		event.stopPropagation();
	});
});

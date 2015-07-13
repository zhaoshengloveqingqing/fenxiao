<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
  function _report(a,c){
  	<?php if ($lang['is_record']) {  ?>
	  	$.post('<?php echo $lang['ajax_url'] ?>', {"action": "<?php echo $lang['ajax_params']['action'] ?>","type": a,"msg": c, "thisurl": "<?php echo $lang['ajax_params']['thisurl'] ?>","imgurl": "<?php echo $lang['ajax_params']['imgurl'] ?>", "title": "<?php echo $lang['ajax_params']['title'] ?>"},function(data){
		});
  	<?php } ?>
  }
  <?php
	  $t = mktime();
      $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
      $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	  $signature = sha1('jsapi_ticket='.$lang['jsapi_ticket'].'&noncestr='.$lang['nonceStr'].'&timestamp='.$t.'&url='.$url);
  ?>		
  wx.config({
      debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
      appId: '<?php echo $lang['appid'];?>', // 必填，公众号的唯一标识
      timestamp: '<?php echo $t;?>', // 必填，生成签名的时间戳
      nonceStr: '<?php echo $lang['nonceStr'];?>', // 必填，生成签名的随机串
      signature: '<?php echo $signature;?>',// 必填，签名，见附录1
      jsApiList: ['onMenuShareAppMessage','onMenuShareTimeline','onMenuShareQQ'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
  });

  var imgUrl = "<?php echo $lang['imgUrl']; ?>",
  		 title = "<?php echo $lang['title']; ?>",
  		 desc = "<?php echo $lang['desc']; ?>",
   		 link = "<?php echo $lang['link']; ?>";
	 

  wx.ready(function () {
  	wx.onMenuShareAppMessage({
  		title: title, // 分享标题
  		desc: desc, // 分享描述
  		link: link, // 分享链接
  		imgUrl:imgUrl, // 分享图标
  		success: function () { 
  			// 用户确认分享后执行的回调函数
  			_report('send_msg', 'st:ok');
  		},
  		cancel: function () { 
  			// 用户取消分享后执行的回调函数
  		}
  	});
  });

  wx.onMenuShareTimeline({
      title: title, // 分享标题
      desc: desc, // 分享描述
  	  link:link, // 分享链接
  	  imgUrl:imgUrl, // 分享图标
      success: function () { 
  			// 用户确认分享后执行的回调函数
  			 _report('timeline', 'st:ok');
  		},
  		cancel: function () { 
  			// 用户取消分享后执行的回调函数
  		}
  });
</script>
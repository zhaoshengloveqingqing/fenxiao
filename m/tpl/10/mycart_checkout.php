<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/top_bottom.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/10/css/mycart_checkout.css" media="all" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_URL;?>tpl/15/css.css" media="all" />
<div id="shopping-list">
	<div class="list">
		<i class="gouwuche"></i>
		<h3>共<span>2</span>件商品</h3>
		<a class="contiune" href="#">继续购物</a>
	</div>
	<div class="myaddress">
		<form>
			<div class="am-form-group">
				<div class="am-u-sm-10">
					<input type="radio" id="doc-ipt-pwd-2">
					<div class="user_info">
						<span>江苏省苏州市创意产业园区  数码路  123号</span>
						<span class="name">李明	15873423523</span>
					</div>
				</div>
			</div>
			<div class="am-form-group add">
				<div class="am-u-sm-10">
					<input type="radio" id="doc-ipt-pwd-2">
					添加新地址
				</div>
			</div>
			<div class="edit">
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">姓名：</label>
					<div class="am-u-sm-10">
						<input type="email" id="doc-ipt-3" placeholder="输入你的姓名">
					</div>
				</div>

				<div class="am-form-group">
					<label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">区域：</label>
					<select id="doc-select-1">
						<option value="option1">选项一...</option>
						<option value="option2">选项二.....</option>
						<option value="option3">选项三........</option>
					</select>
					<span class="am-form-caret"></span>
					<select id="doc-select-1">
						<option value="option1">选项一...</option>
						<option value="option2">选项二.....</option>
						<option value="option3">选项三........</option>
					</select>
					<span class="am-form-caret"></span>
				</div>
				<div class="am-form-group">
					<label for="doc-ipt-3" class="am-u-sm-2 am-form-label">地址：</label>
					<div class="am-u-sm-10">
						<input type="email" id="doc-ipt-3" placeholder="输入详细地址">
					</div>
				</div>

				<div class="am-form-group">
					<label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">
						电话：
					</label>
					<div class="am-u-sm-10">
						<input type="password" id="doc-ipt-pwd-2" placeholder="输入11位电话号码">
					</div>
				</div>
			</div>
			<p class="title"><a href="#">添加</a></p>
			<div class="product">
				<ul>
					<li class="clearfix">
						<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
						<div class="product_detail">
							<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
							<p class="price">零售价：<em>86元</em>本店价：<em>48元</em></p>
							<div class="opreation">

								<a class="delete" href="#">删除</a>
							</div>
						</div>
					</li>
					<li class="clearfix">
						<img src="<?php echo ADMIN_URL;?>tpl/10/images/product.png"/>
						<div class="product_detail">
							<h3>2015年新茶正宗西湖龙井绿茶茶叶500g袋装</h3>
							<p class="price">零售价：<em>86元</em>本店价：<em>48元</em></p>
							<div class="opreation">

								<a class="delete" href="#">删除</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="empty clearfix">
				<a class="empty_btn">清空</a>
			</div>
			<div class="way">
				<div class="pay_way">
					<span>支付方式</span>
					<div class="am-radio">
						<label>
							<input type="radio" name="doc-radio-1" value="option1">
							微信支付
						</label>
					</div>
				</div>
				<div class="deliver_way">
					<span>配送方式</span>
					<div class="am-radio">
						<label>
							<input type="radio" name="doc-radio-2" value="option2">
							快递配送
						</label>
					</div>
				</div>
			</div>
			<p class="total">实付金额:
				<span class="ztotals">￥<?php echo $zp;?>ss</span>
				<span class="freeshopp">+￥<?php echo $free[0];?>(邮费)=</span><span class="freeshoppandprice"><?php echo ($zp+$free[0]);?>元</span>
			</p>
			<p class="action">
				<input class="submit" value="提交订单" type="submit" onclick="return checkvar()"/>
			</p>
		</form>
	</div>
</div>
<?php $this->element('10/footer',array('lang'=>$lang)); ?>
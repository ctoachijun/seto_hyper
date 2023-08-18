<?
	if(!$nowp) $nowp = "L";
	if(!$now_step) $now_step = "L";

	if($nowp == "L" || $now_step == "L"){
		$ldisp = "";
		$odisp = "ndisp";
	}else if($nowp == "O" || $now_step == "O"){
		$ldisp = "ndisp";
		$odisp = "";
	}else{
		echo "<script>alert('프리오더인데 잘못연결됨.')</script>";
		exit;
	}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>리버시블백 NIID S7</title>
	<meta name="description" content=""/>
	<meta property="image" content="">
	<meta property="og:type" content="website" />
	<meta property="og:title" content="" />
	<meta property="og:url" content="" />
	<meta property="og:description" content="" />
	<meta property="og:image" content="" />
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="630" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<link rel="stylesheet" href="/setoLand/niid/assets/css/style.css">
	<script>
	  (function(d) {
	    var config = {
	      kitId: 'xlw2cuc',
	      scriptTimeout: 3000,
	      async: true
	    },
	    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
	  })(document);
	</script>
	<style>
		.ndisp{display:none;}
		.btn{width:300px;height:80px;margin-top:100px;border-radius:10px;font-size:1.3rem;cursor:pointer;box-shadow:1px 1px #777;}
		.btn:active{transform: translate(1px,1px);box-shadow:0 0 #fff;}
		.btn-primary{background: #1e8cec;color:#fff;}
	</style>
</head>
<body>
	<div class="wrap">
		<div class="section section-1">
			<header>
				<div class="container">
					<a href="/" class="logo"><img src="/setoLand/niid/assets/images/logo.png" alt="NIID"></a>
					<ul class="links">
						<li>S6 HYBRID SLING</li>
						<li class="active">S7 TOTE</li>
						<li>CACHE HYBRID SLING</li>
					</ul>
					<a href="#" class="btn-menu"></a>
				</div>
				<ul class="links-mobile">
					<li>S6 HYBRID SLING</li>
					<li class="active">S7 TOTE</li>
					<li>CACHE HYBRID SLING</li>
				</ul>
			</header>
			<div class="content <?=$ldisp?>">
				<div class="main-video-bg" id="mainBg"></div>
				<div class="headline">
					<h2>4 in 1 스타일과 압도적인 실용성</h2>
					<h1>리버시블백 NIID S7</h1>
					<h5>데일리백의 상식을 뒤집다! <br class="mobile">글로벌 50만명의 선택 NIID S7 최초공개</h5>
				</div>
				<div class="subscribe-block">
					<p class="instruction">이메일을 등록하시면, 체험단·기브어웨이 등의 이벤트와 <br class="mobile">예약구매일정 등 최신 소식을 가장 빠르게 받아보실 수 있습니다.</p>
					<div class="input-field">
						<input type="text" id="userEmail" class="input-email" maxlength="50" placeholder="Enter Your Email Address" name="email1">
						<button class="btn-submit ems1" id="btnSubscribe" onclick="collectEmail('AB13_717UeVknwXiLcg',this)">SUBMIT</button>
					</div>
					<div class="checkbox-field">
						<input type="checkbox" name="terms1" id="terms1" value="1" checked>
						<label for="terms1" class="checkbox"></label>
						<a class="check-label"> 마케팅 활용 동의 (필수)</a>	
					</div>
				</div>
			</div>
			
			
			<div class="content <?=$odisp?>">
				<div class="main-video-bg" id="mainBg"></div>
				<div class="headline">
					<h2>지금 펀딩 오픈중요</h2>
					<h4>아래 버튼을 누르면 펀딩페이지로 슝~</h4>
					<h4>당장 펀딩안해도 관심있으면 메일 슝~</h4>
					<a href="<?=$funding_url?>" target="_blank"><input type="button" class="btn btn-primary" value="펀딩 보러 가기" /><a>
				</div>
				<div class="subscribe-block">
				</div>
			</div>
			
			
		</div> <!-- section1 -->
		<div class="section <?=$ldisp?>  section-2">
			<div class="container">
				<h2>More than<br>Just one form</h2>
				<h5>2가지 색상과 4가지 스타일이 하나의 제품에</h5>
				<div class="slider-block">
					<ul class="slider-nav">
						<li id="sliderNav1" class="slider-nav-item active" data-id="0">White & Navy</li>
						<li id="sliderNav2" class="slider-nav-item" data-id="1">Graphite & Navy</li>
						<li id="sliderNav3" class="slider-nav-item" data-id="2">Khaki & Olive</li>
						<li id="sliderNav4" class="slider-nav-item" data-id="3">Cool Gray & <br class="mobile">Butter Cup</li>
					</ul>
					<div class="bags-block">						
						<div class="slider-bags">
							<ul class="bags">
								<li class="bags-image">
									<p><img id="bag0" src="/setoLand/niid/assets/images/bag/0_0.png" alt="NIID S7"></p>
									<span class="bag-name">TOTE</span>
								</li>
								<li class="bags-image">
									<p><img id="bag1" src="/setoLand/niid/assets/images/bag/0_1.png" alt="NIID S7"></p>
									<span class="bag-name">TOTE <br class="mobile">(REVERSED)</span>
								</li>
								<li class="bags-image">
									<p><img id="bag2" src="/setoLand/niid/assets/images/bag/0_2.png" alt="NIID S7"></p>
									<span class="bag-name">MESSENGER</span>
								</li>
								<li class="bags-image">
									<p><img id="bag3" src="/setoLand/niid/assets/images/bag/0_3.png" alt="NIID S7"></p>
									<span class="bag-name">MESSENGER <br class="mobile">(REVERSED)</span>
								</li>
							</ul>
							<div class="colors-pallate">
								<span id="color-y"></span>
								<p class="color-list">
									<span id="color0"></span>
									<span id="color1"></span>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- section2 -->
		<div class="section <?=$ldisp?>  section-3">
			<div class="container">
				<h2>
					<span class="text">Key Points</span>
					<span class="color"></span>
				</h2>
				<ul class="points-block">
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p1.png" alt="2가지 색상과 4가지 스타일이 하나로"></p>
						<p class="title">Point 01.</p>
						<span class="text">2가지 색상과 4가지 <br class="mobile">스타일이 하나로</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p2.png" alt="뒤집기만 하면 완전히 새로운 스타일"></p>
						<p class="title">Point 02.</p>
						<span class="text">뒤집기만 하면 <br class="mobile">완전히 새로운 스타일</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p3.png" alt="3분할 수납공간"></p>
						<p class="title">Point 03.</p>
						<span class="text">3분할 <br class="mobile">수납공간</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p4.png" alt="조절 가능한 사이즈"></p>
						<p class="title">Point 04.</p>
						<span class="text">조절 가능한 사이즈</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p5.png" alt="더블락 잠금 고리"></p>
						<p class="title">Point 05.</p>
						<span class="text">더블락 잠금 고리</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p6.png" alt="견고한 오토락 스트랩"></p>
						<p class="title">Point 06.</p>
						<span class="text">견고한 <br class="mobile">오토락 스트랩</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p7.png" alt="넓고 편안한 어깨 패드"></p>
						<p class="title">Point 07.</p>
						<span class="text">넓고 편안한 <br class="mobile">어깨 패드</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p8.png" alt="고강도 생활방수 소재"></p>
						<p class="title">Point 08.</p>
						<span class="text">고강도 <br class="mobile">생활방수 소재</span>
					</li>
					<li class="points-item">
						<p class="img"><img src="/setoLand/niid/assets/images/sec3_p9.png" alt="YKK RC 지퍼"></p>
						<p class="title">Point 09.</p>
						<span class="text">YKK RC 지퍼</span>
					</li>
				</ul>

			</div>
		</div> <!-- section3 -->
		<div class="section <?=$ldisp?>  section-4">

		</div> <!-- section4 -->
		<div class="section <?=$ldisp?>  section-5">
			<div class="features-block">
				<div class="slider-features slider-features-0" id="featureImg0">
					<div class="feature-text feature-text-1">
						<h3>YKK RC 지퍼</h3>
						<p>RC지퍼는 여행용 캐리어에 사용되는 지퍼로<br> 충격과 마모에 강한 특수 지퍼입니다.</p>
					</div>
				</div>
				<div class="slider-features slider-features-1">
					<div class="feature-text feature-text-2">
						<h3>두껍고 견고한 알루미늄 스트랩</h3>
						<p>낙하산에서나 볼법한 두꺼운 스트랩은 5kg 넘는 <br>무거운 하중도 충분히 견뎌냅니다.</p>
					</div>
				</div>
				<div class="slider-features slider-features-2">
					<div class="feature-text feature-text-1">
						<h3>더블락 잠금 고리</h3>
						<p>더블락 잠금 고리는 내용물이 쉽게 빠지지 않도록 <br>도와줍니다.</p>
					</div>
				</div>
				<div class="slider-features slider-features-3">
					<div class="feature-text feature-text-3">
						<h3>넓고 편안한 어깨 패드</h3>
						<p>도톰한 어깨 패드는 넓은 범위에 하중을 분산시켜 <br>오랜 시간 메고 다녀도 피로가 적습니다.</p>
					</div>
				</div>
				<div class="slider-features slider-features-4">
					<div class="feature-text feature-text-2 w">
						<h3>고강도 생활방수 소재</h3>
						<p>S7의 외피는 생활방수 처리로 물기로부터 내용물을 <br>안전하게 지켜줍니다.</p>
					</div>
				</div>
				<div class="slider-features slider-features-5">
					<div class="feature-text feature-text-1 w">
						<h3>튼튼한 내구성</h3>
						<p>고강도 에코 폴리 소재의 내피는 튼튼한 내구성을 <br>자랑합니다.</p>
					</div>
				</div>
			</div>
			<div class="slider-features-arrow">
				<button class="slider-arrow prev" id="arrowPrev"></button>
				<button class="slider-arrow next" id="arrowNext"></button>
			</div>
			<div class="slider-features-dots"></div>
		</div> <!-- section5 -->
		<div class="section <?=$ldisp?>  section-6">
			<div class="container">
				<h2>
					<span class="text">Specification</span>
					<span class="color"></span>
				</h2>
				<div class="bag-img">
					<img src="/setoLand/niid/assets/images/sec6_1.png" alt="NIID S7">
					<img src="/setoLand/niid/assets/images/sec6_2.png" alt="NIID S7">
				</div>
				<div class="spec-block">
					<div class="row">
						<p class="title">모델명</p>
						<p class="text">NIID S7</p>
					</div>
					<div class="row">
						<p class="title">소재</p>
						<p class="text">에코폴리에스터 , 나일론 , 알루미늄</p>
					</div>
					<div class="row">
						<p class="title">무게</p>
						<p class="text">475g</p>
					</div>
					<div class="row">
						<p class="title">크기</p>
						<p class="text">
							<span><strong>Tote</strong>46 X (12-30) X 33cm</span>
							<span><strong>Hobo</strong>25-43 X (3-17) X 28cm</span>
						</p>
					</div>
					<div class="row">
						<p class="title">용량</p>
						<p class="text">
							<span><strong>Tote</strong>13L</span>
							<span><strong>Hobo</strong>9.5L</span>
						</p>
					</div>
					<div class="row">
						<p class="title">제조자</p>
						<p class="text">NIID</p>
					</div>
					<div class="row">
						<p class="title">색상</p>
						<p class="text">White & Navy / Graphite & Navy / Khaki & Olive / Cool Gray & Butter Cup</p>
					</div>
				</div>
			</div>
		</div> <!-- section6 -->

		<footer>
			<div class="container">
				<div class="logo-block">
					<img src="/setoLand/niid/assets/images/logo.png" alt="NIID">
				</div>
				<div class="subscribe-block">
					<p class="instruction">이메일을 등록하시면, 체험단·기브어웨이 등의 이벤트와 예약구매일정 등 최신 소식을 가장 빠르게 받아보실 수 있습니다.</p>
					<div class="input-field">
						<input type="text" id="userEmailBtm" class="input-email" maxlength="50" placeholder="Enter Your Email Address" name="email2">
						<button id="btnSubscribeBtm" class="btn-submit ems2" onclick="collectEmail('AB13_717UeVknwXiLcg',this)">SUBMIT</button>
					</div>
					<div class="checkbox-field">
						<input type="checkbox" name="terms2" id="terms2" value="1" checked>
						<label for="terms2" class="checkbox"></label>
						<a class="check-label"> 마케팅 활용 동의 (필수)</a>	
					</div>
				</div>
				<div class="contact-block">
					<p>CONTACT US</p>
					<span>support@niid.kr</span>
					<ul class="social-links">
						<li><a href="" target="_blank" class="fb">Facebook</a></li>
						<li><a href="" target="_blank" class="ig">Instagram</a></li>
					</ul>
				</div>
			</div>
			<p class="copyright">© Setoworks Co., Ltd.</p>
		</footer>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver"></script>
	<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<!-- <script src="/setoLand/niid/assets/lib/mobile-detect.min.js"></script>  -->
	<script src="/setoLand/niid/assets/js/index.js"></script>
	<script src="/setoLand/js/setoLand.js"></script>
</body>
</html>
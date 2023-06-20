let player = {};
let flag_scroll = false, flag_resize = false;
const viewers = document.querySelectorAll(".image-compare");
const dragOptions = {
  // UI Theme Defaults
  controlColor: "#fafafa",
  controlShadow: false,
  addCircle: true,
  addCircleBlur: true,

  // Smoothing
  smoothing: true,
  smoothingAmount: 100,

  // Other options
  hoverStart: true,
  verticalMode: false,
  startingPoint: 50,
  fluidMode: false
};
const slickSettings = {
  arrows: true,
  prevArrow: "#sliderPrev",
  nextArrow: "#sliderNext",
  draggable: true,
  infinite: true,
  respondTo: "window",
  rows: 1,
  slidesToShow: 2,
  slidesToScroll: 1,
  centerMode: true,
  centerPadding: '80px',
  initialSlide: 1,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        centerPadding: '40px',
        initialSlide: 0
      }
    }
  ]
};
let canvasImages = {};
let canvasImgPath = 'assets/img/';
let canvasSources = {
    camera_1: canvasImgPath + 'intro/rotate01.png',
    camera_2: canvasImgPath + 'intro/rotate02.png',
    camera_3: canvasImgPath + 'intro/rotate03.png',
    camera_4: canvasImgPath + 'intro/rotate04.png',
    camera_5: canvasImgPath + 'intro/rotate05.png'
};
let _canvasW = 0, _canvasH = 0;
let introCanvas = document.getElementById('introCanvas'), ctx;
let img1 = new Image();
    img1.src = canvasSources.camera_1;
let img2 = new Image();
    img2.src = canvasSources.camera_2;
let img3 = new Image();
    img3.src = canvasSources.camera_3;
let img4 = new Image();
    img4.src = canvasSources.camera_4;
let img5 = new Image();
    img5.src = canvasSources.camera_5;
let PIXEL_RATIO = function (ctx) {
    let dpr = window.devicePixelRatio || 1,
        bsr = ctx.webkitBackingStorePixelRatio ||
              ctx.mozBackingStorePixelRatio ||
              ctx.msBackingStorePixelRatio ||
              ctx.oBackingStorePixelRatio ||
              ctx.backingStorePixelRatio || 1;
    return dpr / bsr;
};
let createHiDPICanvas = function(w, h, ratio, can, cxt) {
    if (!ratio) { ratio = PIXEL_RATIO(cxt); }
    can.width = w * ratio;
    can.height = h * ratio;
    can.style.width = w + "px";
    can.style.height = h + "px";
    cxt.setTransform(ratio, 0, 0, ratio, 0, 0);
    return can;
};
viewers.forEach((element) => {
  let view = new ImageCompare(element, dragOptions).mount();
});

(function(){
  initYoutube();
  detectScroll();
  $('.intro').addClass('show');
  $('.detail-slider').slick(slickSettings);
  initCanvas();  
  window.addEventListener('resize', resizeCanvas, false);
})();


$('#btnSubscribe').on('click', function(e){
  e.preventDefault();
  let email = $('#userEmail').val();
  let emailReg = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
  if (email.length < 1) {
    alert('Email *Required*');
    return false;
  } else if (!emailReg.test(email)) {
    alert('Email format incorrect! Please check again.');
    return false;
  }
  $('#btnSubscribe').addClass('disabled');
  $('#userEmail').attr('disabled', 'true');
  let data = { 'email' : email };
  sendInfo(data, function(){
    alert('Thanks for Subscribing!');
    $('#userEmail').val('');
    $('#btnSubscribe').removeClass('disabled');
    $('#userEmail').removeAttr('disabled');
  });
});

$('#btnSubscribeBtm').on('click', function(e){
  e.preventDefault();
  let idx = $("input[name=product_index").val();
  let email = $('#userEmailBtm').val();
  let emailReg = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
  let consetAgree = $('#terms:checked').val();
  if (email.length < 1) {
    alert('이메일 주소를 입력 해 주세요.');
    return false;
  } else if (!emailReg.test(email)) {
    alert('이메일 형식이 올바르지 않습니다.');
    return false;
  }
  if (consetAgree == undefined) {
    alert('마케팅 활용 동의 선택 필수');
    $('#terms').prop("checked",true);
    return false;
  }
  $('#btnSubscribeBtm').addClass('disabled');
  $('#userEmailBtm').attr('disabled', 'true');
  let data = { 'email' : email, "w_mode" : "regEmail", "iidx" : idx };
  // sendInfo(data, function(){
  //   alert('등록 되었습니다. 감사합니다.');
  //   $('#userEmailBtm').val('');
  //   $('#btnSubscribeBtm').removeClass('disabled');
  //   $('#userEmailBtm').removeAttr('disabled');
  // });
  
  $.ajax({
    url : "../ajax_setoLand.php",
    type: "post",
    data: data,
    success: function(result){
      let json = JSON.parse(result);
      // console.log(json);
      if(json.state === "Y"){
        alert("등록 되었습니다. 감사합니다.");
        $('#userEmailBtm').val('');
        $('#btnSubscribeBtm').removeClass('disabled');
        $('#userEmailBtm').removeAttr('disabled');
      }else{
        alert("등록에 실패하였습니다.\n반복 될 경우 문의 주시길 바랍니다.");
      }
    }
  })
  
});

$('.detail-slider').on('afterChange', function(event, slick, currentSlide, nextSlide){
  console.log('nextSlide');
  gtag('event', 'slide_changed', { 'slide_changed' : 'slider_slide_changed'});

});
function sendInfo (sendData, successFunc) {
  // let sendURL = 'https://script.google.com/macros/s/AKfycbwq2fwKYUmQKG14ZHaylVFBfL6rjpjmYBS7uuIK0c0Gq0UnZnsR8988AJMtMGkz09p_wg/exec';
  let sendURL = ""
  $.ajax({
    type: 'POST',
    url: sendURL,
    data: sendData,
    success: function(response){      
      let data = response;
      if(data.result === 'success'){
        successFunc();
        console.log('send success');
      } else {
        alert('Something wrong.')
        console.log('error');       
        console.log(data);
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert('Something wrong.');
      // console.log(jqXHR);
    }
  });
}
$('#btnPlayVideo').on('click', function(e) {
  player.playVideo();
});
$(document).scroll(function() {
  detectScroll();
});
$('.check-label').on('click', function(e){
  e.preventDefault();
  $('.lightbox-overlay').fadeIn();
});
$('.btn-close, .btn-confirm').on('click', function(e){
  e.preventDefault();
  $('.lightbox-overlay').fadeOut();
});

function detectScroll() {
  if (flag_scroll) return;

  let scrollTop = $(window).scrollTop();

}
function initCanvas() {
  let list = [img1, img2, img3, img4, img5];
  let index = 0;
  _canvasW = $('.camera').width();
  _canvasH = $('.camera').height();

  if (introCanvas && introCanvas.getContext) {
    introCanvas.width = _canvasW;
    introCanvas.width = _canvasW;  
    ctx = introCanvas.getContext('2d');
    createHiDPICanvas(_canvasW, _canvasH, 2, introCanvas, ctx);
  }
  ctx.drawImage(img1, 0, 0, _canvasW, _canvasH);

  let canvasChange = function() {
    if (index > 3) {
        index = -1;
    }
    index++;
    ctx.drawImage(list[index], 0, 0, _canvasW, _canvasH);
  };
  let interval = window.setInterval(function(){
    canvasChange();
  }, 300);
}
function resizeCanvas() {
  if (flag_resize) return;
  ctx.clearRect(0, 0, _canvasW, _canvasH);
  _canvasW = $('.camera').width();
  _canvasH = $('.camera').height();
  introCanvas.width = _canvasW;
  introCanvas.height = _canvasH;
  ctx = introCanvas.getContext('2d');
  createHiDPICanvas(_canvasW, _canvasH, 2, introCanvas, ctx);
}
function initYoutube() {
    let tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    let firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}
function onYouTubeIframeAPIReady() {
  player = new YT.Player('videoPlayer', {
      videoId: 'Jvv7STNqB-g',
      modestbranding: 1,
      wmode: 'transparent',
      playerVars: {
          'playsinline': 1,
          'rel': 0,
          'showinfo': 0,
          'allowfullscreen': 0
      },
      events: {
          'onReady': onPlayerReady,
          'onStateChange': onPlayerStateChange
      }
  });
}
function onPlayerReady(event) {
  // event.target.mute().playVideo();
  $('#videoPlayer').removeClass('hide');
}
function onPlayerStateChange(event) {
  if (event.data == YT.PlayerState.PLAYING) {
    $('#videoPlayer').removeClass('hide');
    $('.video-playBtn').addClass('hide');
  }
  if (event.data == YT.PlayerState.ENDED) {
    //event.target.playVideo();
    $('.video-playBtn').removeClass('hide');
  }
  if (event.data == YT.PlayerState.BUFFERING) {
    $('#videoPlayer').addClass('hide');
  }
}
function stopVideo() {
  player.stopVideo();
}
function loadImages(sources, callagain) {
  let loadedImages = 0;
  let numImages = 0;

  for(let src in sources) {
    numImages++;
  }
  for(let src in sources) {
    images[src] = new Image();
    images[src].crossOrigin = 'Anonymous';
    images[src].onload = function() {
        if(++loadedImages >= numImages) {
            callagain(images);
        }
    };
    images[src].src = path + sources[src];
  }
}
let player = {};
let flag_scroll = false;
const bagImagePath = 'assets/images/bag/';
let images = {};
let sources = {
  img0_0: bagImagePath + '0_0.png',
  img0_1: bagImagePath + '0_1.png',
  img0_2: bagImagePath + '0_2.png',
  img0_3: bagImagePath + '0_3.png',
  img1_0: bagImagePath + '1_0.png',
  img1_1: bagImagePath + '1_1.png',
  img1_2: bagImagePath + '1_2.png',
  img1_3: bagImagePath + '1_3.png',
  img2_0: bagImagePath + '2_0.png',
  img2_1: bagImagePath + '2_1.png',
  img2_2: bagImagePath + '2_2.png',
  img2_3: bagImagePath + '2_3.png',
  img3_0: bagImagePath + '3_0.png',
  img3_1: bagImagePath + '3_1.png',
  img3_2: bagImagePath + '3_2.png',
  img3_3: bagImagePath + '3_3.png'
};
const colorsPallateAry = {
  color0: ['#F4F4F4', '#000000', '#A5A082', '#8D9999'],
  color1: ['#19319B', '#F4F4F4', '#686F5B', '#DCC670']
};
const slickSettings = {
  arrows: true,
  prevArrow: "#arrowPrev",
  nextArrow: "#arrowNext",
  draggable: true,
  infinite: true,
  respondTo: "window",
  rows: 1,
  slidesToShow: 1,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        autoplay: true,
        arrows: false,
        dots: true,
        appendDots: ".slider-features-dots"
      }
    }
  ]
};
(function(){
  // initYoutube();
  // detectScroll();
  loadImages(sources, function(images) {
    console.log('images loaded!!');
  });
  $('.features-block').slick(slickSettings);
  
})();
$('.slider-nav-item').on('click', function(e) {
  e.preventDefault();
  let id = $(this).data('id');
  $('.slider-nav-item').removeClass('active');
  $(this).addClass('active');
  let color0 = colorsPallateAry.color0[id],
      color1 = colorsPallateAry.color1[id];
  
  $('#color0').css('background-color', color0);
  $('#color1').css('background-color', color1);

  $('#bag0').attr('src', images['img' + id + '_0'].src);
  $('#bag1').attr('src', images['img' + id + '_1'].src);
  $('#bag2').attr('src', images['img' + id + '_2'].src);
  $('#bag3').attr('src', images['img' + id + '_3'].src);
});

$('.btn-menu').on('click', function(e){
  e.preventDefault();
  $(this).toggleClass('active');
  $('.links-mobile').toggleClass('active');
});

$('#btnSubscribe').on('click', function(e){
  e.preventDefault();
  let email = $('#userEmail').val();
  let emailReg = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
  let consetAgree = $('#terms1:checked').val();
  if (email.length < 1) {
    alert('Email *Required*');
    return false;
  } else if (!emailReg.test(email)) {
    alert('Email format incorrect! Please check again.');
    return false;
  }
  if (consetAgree == undefined) {
    alert('마케팅 활용 동의 선택 필수');
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
  let email = $('#userEmailBtm').val();
  let emailReg = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
  let consetAgree = $('#terms2:checked').val();
  if (email.length < 1) {
    alert('Email *Required*');
    return false;
  } else if (!emailReg.test(email)) {
    alert('Email format incorrect! Please check again.');
    return false;
  }
  if (consetAgree == undefined) {
    alert('마케팅 활용 동의 선택 필수');
    return false;
  }
  $('#btnSubscribeBtm').addClass('disabled');
  $('#userEmailBtm').attr('disabled', 'true');
  let data = { 'email' : email };
  sendInfo(data, function(){
    alert('Thanks for Subscribing!');
    $('#userEmailBtm').val('');
    $('#btnSubscribeBtm').removeClass('disabled');
    $('#userEmailBtm').removeAttr('disabled');
  });
});

function sendInfo (sendData, successFunc) {
  // let sendURL = 'https://script.google.com/macros/s/AKfycbwq2fwKYUmQKG14ZHaylVFBfL6rjpjmYBS7uuIK0c0Gq0UnZnsR8988AJMtMGkz09p_wg/exec';
  // $.ajax({
  //   type: 'POST',
  //   url: sendURL,
  //   data: sendData,
  //   success: function(response){      
  //     let data = response;
  //     if(data.result === 'success'){
  //       successFunc();
  //       console.log('send success');
  //     } else {
  //       alert('Something wrong.')
  //       console.log('error');       
  //       console.log(data);
  //     }
  //   },
  //   error: function(jqXHR, textStatus, errorThrown){
  //     alert('Something wrong.');
  //     // console.log(jqXHR);
  //   }
  // });
}
$(document).scroll(function() {
  detectScroll();
});

function detectScroll() {
  if (flag_scroll) return;

  let scrollTop = $(window).scrollTop();

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
  var loadedImages = 0;
  var numImages = 0;

  for(var src in sources) {
    numImages++;
  }
  for(var src in sources) {
    images[src] = new Image();
    images[src].crossOrigin = 'Anonymous';
    images[src].onload = function() {
        if(++loadedImages >= numImages) {
            callagain(images);
        }
    };
    images[src].src = sources[src];
  }
}
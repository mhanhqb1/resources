var ua = navigator.userAgent.toLowerCase();
$.ua = {
  isWindows: /windows/.test(ua),  // Windows
  isMac: /macintosh/.test(ua),  // Mac
  isIE: /msie (\d+)/.test(ua),  // IE
  isIE6: /msie (\d+)/.test(ua) && RegExp.$1 == 6,  // IE6
  isIE7: /msie (\d+)/.test(ua) && RegExp.$1 == 7,  // IE7
  isLtIE9: /msie (\d+)/.test(ua) && RegExp.$1 < 9,  // IE9未満
  isFirefox: /firefox/.test(ua),  // Firefox
  isWebKit: /applewebkit/.test(ua),  // WebKit
  isTouchDevice: 'ontouchstart' in window,  // touchDevice
  isIOS: /i(phone|pod|pad)/.test(ua),  // iOS
  isIPhone: /i(phone|pod)/.test(ua),   // iPhone, iPod touch
  isIPad: /ipad/.test(ua),  // iPad
  isAndroid: /android/.test(ua),  // Android
  isAndroidMobile: /android(.+)?mobile/.test(ua)  // Android mobile
};

if($.ua.isAndroid || $.ua.isIOS){
  location.href = './sp/';
}

var el = $("<div>");
$.support.transform  = typeof el.css("transform") === "string";
$.support.transition = typeof el.css("transitionProperty") === "string";

soundManager.setup({
  url: 'common/sounds/soundmanager2.swf',
  flashVersion: 9,
  useHighPerformance: true,
  useHTML5Audio: true,
  debugMode: false,
  flashLoadTimeout: 0,
  wmode: 'transparent',
  bgColor: '#000000',
  ontimeout: function() {
    alert('Sound Player is not ready.');
  }
});


var ashikusa = {

  timer: {},
  win: $(window),
  imagesCompleat : false,
  SE : {
    itemLength : 17,
    loaded : 0
  },
  flag: {
    firstVisit: true,
    showTitle: false
  },
  pattern: {
    man: [2,6,7,8,9,12,13,16,25,29,31,32],
    woman: [1,3,4,5,10,11,14,15,17,18,19,20,21,22,23,24,26,27,28,30]
  },
  init : function(){
    for (var key in this) {
      var member = this[key];
      if (typeof member != 'object') {
        continue;
      }
      member.root = this;
    }
    var self = this;
    self.setBodyClass();
    self.loadSounds();
    $(function(){
      self.winInit();
      self.loading();
      //self.scene1();
      //self.sceneChange('scene2');
      self.soundStatus();
      self.addEvent();
      self.snsBtn();
    });
  },

  loading : function(){
    var self = this;
    $('body').imagesLoaded({
      callback: function($images, $proper, $broken){
        self.imagesCompleat = true;
        self.checkSoundLoad();
      } 
    });
  },

  checkSoundLoad : function(){
    var self = this;
    if(self.SE.itemLength == self.SE.loaded && self.imagesCompleat ){

      var res = getUrlVars('result');
      if ( res ){
        _gaq.push(['_trackPageview', '/8x4/ashikusa/from_sns_result_'+res]);
        self.flag.directResult = true;
        self.result = res;
        self.introFirst();
        self.directScene3();
      } else {
        self.scene1();
      }
      
    }
  },

  setBodyClass: function(){
    if($.ua.isLtIE9){
      $('html').addClass('ltIE9');
    }
    if($.ua.isIE7){
      $('html').addClass('IE7');
    }
  },

  loadSounds : function(){
    var self = this;

    soundManager.onready(function(){

      self.SE.Don_short = soundManager.createSound({
        id: 'Don_short',
        url: 'common/sounds/Se0302Don_short.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.walk01 = soundManager.createSound({
        id: 'walk01',
        url: 'common/sounds/SEwalk01.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.walk02 = soundManager.createSound({
        id: 'walk02',
        url: 'common/sounds/SEwalk02.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.walk03 = soundManager.createSound({
        id: 'walk03',
        url: 'common/sounds/SEwalk03.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.walk04 = soundManager.createSound({
        id: 'walk04',
        url: 'common/sounds/SEwalk04.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.walk05 = soundManager.createSound({
        id: 'walk05',
        url: 'common/sounds/SEwalk05.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.walk06 = soundManager.createSound({
        id: 'walk06',
        url: 'common/sounds/SEwalk05.mp3',
        autoLoad: true,
        volume: 200,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.walkJumpdown = soundManager.createSound({
        id: 'walkJumpdown',
        url: 'common/sounds/SEwalkjumpdown.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.opening = soundManager.createSound({
        id: 'opening',
        url: 'common/sounds/84Opening01A.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });
    
      self.SE.SprayA = soundManager.createSound({
        id: 'SprayA',
        url: 'common/sounds/Se0302SprayA.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.IyoVoice = soundManager.createSound({
        id: 'IyoVoice',
        url: 'common/sounds/Se0302IyoVoice.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.SprayB = soundManager.createSound({
        id: 'SprayB',
        url: 'common/sounds/Se0302SprayB.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.shake = soundManager.createSound({
        id: 'shake',
        url: 'common/sounds/84Se01A_OmikujiShake.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });
    
      self.SE.ohayashi = soundManager.createSound({
        id: 'ohayashi',
        url: 'common/sounds/84Omi0501_Ohayashi.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        },
        onfinish: function(){
          this.play();
        }
      });

      self.SE.get = soundManager.createSound({
        id: 'get',
        url: 'common/sounds/84Se01A_OmikujiGet.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        },
        onfinish: function(){
          this.play();
        }
      });

      self.SE.IyoB = soundManager.createSound({
        id: 'IyoB',
        url: 'common/sounds/Se0302IyoBom.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });

      self.SE.cleaning = soundManager.createSound({
        id: 'cleaning',
        url: 'common/sounds/84Se01A_Miko.mp3',
        autoLoad: true,
        onload: function(){
          self.SE.loaded++;
          self.checkSoundLoad();
        }
      });
    });
  },

  winInit: function(){
    var self = this;
    $scene01 = $('#scene01');
    self.win.scroll = {
      top : 0,
      top_x : 0,
      direction : 'down',
      direction_x : 'down'
    };
    self.container = $('#container');
    self.win.on({
      resize: function(){
        self.win.h = $(this).height();
        self.win.h = self.win.h < 670 ? 670 : self.win.h;
        self.win.w = $(this).width();
        self.container.css({minHeight:self.win.h-20});
        $scene01.css({height:self.win.h-20});
      }
    }).resize();
  },

  addEvent: function(){
    var self = this;
    $('.over').rollover();
    $('#balloonMan a').on({
      mouseenter: function(){
        self.SE.SprayA.play();
        $('#charaMan').attr('src','common/images/man_over.png');
      },
      mouseleave: function(){
        $('#charaMan').attr('src','common/images/man.png');
      }
    });

    $('#balloonWoman a').on({
      mouseenter: function(){
        self.SE.SprayA.play();
        $('#charaWoman').attr('src','common/images/woman_over.png');
      },
      mouseleave: function(){
        $('#charaWoman').attr('src','common/images/woman.png');
      }
    });
    
    $('#footSpray').on({
      click : function(){
        $('#footKira').fadeIn(500);
        self.SE.SprayB.play();
        self.$snsBtnBtm.animate({bottom: 35},700,'easeOutCubic');
      }
    });
    $('#to8_4').on({
      click: function(){
        _gaq.push(['_trackPageview', '/8x4/ashikusa/to_procut_page']);
      }
    });
    $('#smallLogo a').on({
      click: function(){
        _gaq.push(['_trackPageview', '/8x4/ashikusa/HOME_button']);
      }
    });
  },
  
  setResult: function( type ){
    var self = this;
    clearTimeout(self.timer.floating);
    var resType = self.pattern[type];
    var len = resType.length;
    var num = Math.floor(Math.random()*len);
    self.result = resType[num];
    self.SE.IyoVoice.play();
    self.toriiJump();
    if ( !$.ua.isLtIE9 ){
      $('#omikuji_shadow').stop().delay(2000).animate({
          opacity: 0
      },800,'easeInOutCubic');
    }
    $('#omikuji').stop().delay(2000).animate({
      marginTop: '-100%'
    },800,'easeInCubic',function(){
      setTimeout(function(){
        self.sceneChange('scene2');
      },500);
    });
  },

  soundStatus: function(){
    var self = this;
    if ( $.cookie('soundMute') == 'mute' ){
      self.SE.mute = true;
      soundManager.onready(function(){ soundManager.mute(); });
    }
    if( self.SE.mute == true ){
      $('#soundBtn').addClass('mute');
    }
    $('#soundBtn').on({
      click: function(){
        if ( self.SE.mute == true ) {
          $(this).removeClass('mute');
          $.cookie('soundMute', 'unmute', { expires: 7, path: '/' });
          soundManager.onready(function(){ soundManager.unmute(); });
          self.SE.mute = false;
        } else {
          $(this).addClass('mute');
          $.cookie('soundMute', 'mute', { expires: 7, path: '/' });
          soundManager.onready(function(){ soundManager.mute(); });
          self.SE.mute = true;
        }
      }
    });
  },

  snsBtn: function(){
    var self = this;
    var shareURL = 'http://www.kao.co.jp/8x4/ashikusa/';
    var snsBtns = '<li><a href="http://mixi.jp/share.pl" class="mixi-check-button" data-url="'+ shareURL +'" data-button="button-6" data-key="ab94c872138c6a04e3bb93a2978cb37bba84f5f1">mixiチェック</a><script type="text/javascript" src="http://static.mixi.jp/js/share.js"></script></li>'+
                  '<li class="fbBtn"><iframe src="//www.facebook.com/plugins/like.php?href='+ encodeURIComponent(shareURL) +'&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:70px; height:21px;" allowTransparency="true"></iframe></li>'+
                  //'<li><div class="fb-like" data-href="'+shareURL+'" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false"></div></li>'+
                  '<li><a href="https://twitter.com/share" class="twitter-share-button" data-url="'+ shareURL +'" data-text="【8×4Foot】スペシャルコンテンツ公開！『あしくさ神社のあしくさおみくじ』で足のニオイのピンチに効く教えを授かろう。" data-lang="ja" data-count="none" data-hashtags="ashikusa">ツイート</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script></li>'+
                  '<li class="addThis"><a class="addthis_button_more"><img src="http://www.kao.com/common/jp/ja/imgs/add_button.gif" alt="More..." /></a></li><script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4dae47645d13c7e7"></script>';
    $('#snsBtn,#snsBtnBtm').prepend(snsBtns);
    
  },

  sceneChange: function(sceneName,fn){
    var self = this;
    if ( sceneName == 'scene1'){
      self.flag.firstVisit = false;
      self.flag.directResult = false
      self.SE.ohayashi.stop();
    }
    self.flag.cleanable = false;
    self.flag.showTitle = false;
    var sceneSelector = {
      scene1: '#scene01',
      scene2: '#scene02',
      scene3: '#scene03'
    }
    var id = sceneSelector[sceneName];
    var h = $(id).height() - 20;
    $('.scene').each(function(i){
      $(this).animate({ top: - $(this).height() },500,function(){
        $(this).hide();
      });
    });
    setTimeout(function(){
      if (sceneName == 'scene1'){
        $('#title').css({ marginTop: '-100%' });
        $('#contentsBg, #balloonMan, #balloonWoman').hide();
        $('#charaMan').css({
          left: 60,
          top: 90
        }).hide();
        $('#charaWoman').css({
          right: 40,
          top: 70
        }).hide();
        $('body').css({paddingBottom: 0});
      } else {
        $('#contentsBg').show();
      }
      self.container.stop().animate({
        height: h
      },1000,'easeInOutCubic');
      $(id).stop().show().animate({
        top: '0%'
      },1000,'easeInOutCubic', function(){
        self[sceneName]();
      });
    }, 600);

  },

  don: function( selector, se ){
    var self = this;
    var val = 10;
    var soundName = se ? se : 'Don_short';
    self.SE[soundName].play();
    $(selector).animate({
      marginTop: val  
    },50,'linear',function(){
      $(selector).animate({
        marginTop: 0  
      },50,'linear',function(){
        $(selector).animate({
          marginTop: val/2  
        },50,'linear',function(){
          $(selector).animate({
            marginTop: 0  
          },50,'linear');
        });
      });
    });
  },

  pon: function( imgWrapSelector, pointLeft, pointTop , fn ){
    var self = this;
    var $selector = $(imgWrapSelector);
    var $img = $(imgWrapSelector).find('img');
    var w = $img.width();
    var h = $img.height();
    $selector.css({ width: w, height: h});
    $img.width(0);
    $img.height(0);
    $img.css({
      position: 'absolute',
      left: pointLeft,
      top: pointTop
    });
    $img.animate({
      left: 0,
      top: 0,
      width: w,
      height: h
    },300,'easeOutCubic', fn );
  },

  scene1: function(){
    var self = this;
    self.flag.introSkip = false;
    self.flag.cleanable = true;
    $('#balloonMan a').off('click').one({
      click: function(){
        _gaq.push(['_trackPageview', '/8x4/ashikusa/chose_men']);
        self.setResult('man');
        return false;
      }
    });

    $('#balloonWoman a').off('click').one({
      click: function(){
        _gaq.push(['_trackPageview', '/8x4/ashikusa/chose_woman']);
        self.setResult('woman');
        return false;
      }
    });

    var intro = {
      textInterval : 500,
      textSpeed: 2,
      walkInterval: 400,
      walkFps: 100,
      transition: '300ms ease-out 200ms'
    };
    $('#btnSkip').click(function(){
      self.flag.introSkip = true;
      intro = {
        textInterval : 0,
        textSpeed: 0,
        walkInterval: 200,
        walkFps: 20,
        transition: '200ms ease-out 0ms'
      }; 
      $(this).hide();
    });

    if ( self.flag.firstVisit == true ){
      miko();
      $('#loadingText').fadeOut(1000,function(){
        wipeLeadText(function(){
          toriiComingUp(function(){
            self.toriiJump(function(){
              showTitle(function(){
              });
            });
          });
        });
      });
    } else {
      self.showButtonWait = 1000;
        showTitle(function(){
        });
    }

    function miko(){
      $miko = $('#miko');
      function mikoMove(){
        var senryuW; 
        var senryuNum = Math.floor(Math.random()*10);
        var $img = $('<img src="common/images/senryu'+ senryuNum +'.png" alt="" />');
        $img.imagesLoaded(function(){
          $('#senryuLeft').empty().append($img);
          senryuW = $img.width();
        });
        var senryuRW; 
        var senryuNumR = Math.floor(Math.random()*10);
        var $imgR = $('<img src="common/images/senryu'+ senryuNumR +'.png" alt="" />');
        $imgR.imagesLoaded(function(){
          $('#senryuRight').empty().append($imgR);
          senryuRW = $imgR.width();
        });

        self.flag.readingSenryu = false;
        $miko.animate({
          left: 221
        },8000,'linear', function(){
          var delayLeft;
          if ( self.flag.showTitle == true ){
            self.flag.readingSenryu = true;
            $('#senryuLeft').delay(1000).animate({
              width: senryuW
            },2000,'linear',function(){
              $('#senryuLeft').delay(1000).animate({
                width: 0
              },0,function(){
                self.flag.readingSenryu = false;
                cleaning();
              })
            });
            delayLeft = 5000;
          } else {
            delayLeft = 1000;
          }

          $miko.delay(delayLeft).animate({
            left: 621
          },8000,'linear', function(){

            var delayRight;
            if ( self.flag.showTitle == true ){
              self.flag.readingSenryu = true;
              $('#senryuRight').delay(1000).animate({
                width: senryuRW
              },2000,'linear',function(){
                $('#senryuRight').delay(1000).animate({
                  width: 0
                },0,function(){
                  self.flag.readingSenryu = false;
                  cleaning()
                });
              });
              delayRight = 5000;
            } else {
              delayRight = 1000;
            }
            setTimeout( function(){
              mikoMove();
            }, delayRight)
          });
        });
      }
      function cleaning(){
        if ( self.flag.showTitle == true && self.flag.cleanable == true ){
          self.SE.cleaning.play({ volume: 10 });
        }
        $miko.spriteAnimate({
          delay: 300,
          interval: 100,
          start: 0,
          end: 3,
          loops: 1,
          after: function(){
            if ( self.flag.readingSenryu == false ){
              $miko.spriteAnimate({
                interval: 200,
                start: 3,
                end: 4,
                loops: 1,
                after: function(){
                  cleaning();
                }
              });
            }
          }
        });
      }
      mikoMove();
      cleaning();
    }
    
    function showTitle(fn){
      setTimeout(function(){
        self.SE.opening.play({
          onfinish: function(){
            self.flag.showTitle = true;
          }
        });
      },900);
      $('#title').delay(500).animate({
        marginTop: '0%'
      },500,'linear',function(){
        self.introFirst();
        self.don('#scene01','walkJumpdown');
//        self.flag.showTitle = true;
        if ( !$.ua.isLtIE9 ){
          $('#omikuji_shadow').show().stop().animate({
              opacity: 1
          },1000,'easeInOutCubic');
        } else {
          $('#omikuji_shadow').show().css({
              opacity: 1
          });
        }
        $('#omikuji').animate({
          marginTop: '0%'
        },1000,'easeOutCubic',function(){
          self.showButtonWait = self.SE.mute ? 0 : 
                                self.showButtonWait ? 1000 : 6000;
          setTimeout(function(){
            $('#balloonMan,#balloonWoman').show();
            self.pon('#balloonMan a', '240px', '170px',function(){
              $('#charaMan').show().animate({
                top: 0,
                left: 0
              },300,'easeOutCubic');
            });
            self.pon('#balloonWoman a', '0px', '170px', function(){
              $('#charaWoman').show().animate({
                top: 0,
                right: -16
              },300,'easeOutCubic');
            });
            fn();
          },self.showButtonWait);
          floating();
        });
      });
    }

    //ふわふわ
    function floating(){
      if ( !$.ua.isLtIE9 ){
        $('#omikuji_shadow').stop().animate({
            opacity: 0.5
        },1000,'easeInOutCubic');
      }
      $('#omikuji').stop().animate({
          marginTop: '-10px'
      },1000,'easeInOutCubic',function(){
        if ( !$.ua.isLtIE9 ){
          $('#omikuji_shadow').stop().animate({
              opacity: 1
          },1000,'easeInOutCubic');
        }

        $('#omikuji').stop().animate({
          marginTop: '0px'
        },1000,'easeInOutCubic',function(){
          self.timer.floating = setTimeout(floating, 0);
        });
      });
    }


    // オープニングテキスト表示
    function wipeLeadText(fn){
      var $lead = $('#lead');
      var $paragraph = $lead.find('span');
      var len = $paragraph.length;
      var cnt = 0;
      function textLoop(){
        var $this = $paragraph.eq(cnt);
        var imgHeight = $this.find('img').height();
        $this.delay(intro.textInterval).animate({
          height : imgHeight
        },imgHeight * intro.textSpeed,'linear',function(){
          if ( cnt+1 >= len ){
            $lead.delay(intro.textInterval).fadeOut(intro.textInterval*2,fn);
          } else {
            cnt++;
            textLoop();
          }
        });
      }
      textLoop();
      $('#btnSkip').show();
      self.pon('#btnSkip', '106px', '42px');
    }

    // 鳥居登場
    function toriiComingUp(fn){
      $torii = $('#torii');
      if ( $.support.transform == true ) {
        var cnt = 4; 
        $torii.css({
          marginTop: '-100%',
          transform: 'scale('+(cnt*cnt)*0.01+')'
        });
        $torii.animate({
          marginTop: '0%' 
        },1000,'linear',function(){
          self.don('#scene01','walkJumpdown');
          setTimeout(function(){
            sprite();
          }, 500);
        });
      } else {
        var cnt = 10; 
        $('#toriiFixSet').show();
        fn();
      }
      var soundNum = 1;
      function sprite(){
        var options = cnt % 2 == 0 
          ? { start: 0, end: 5, loops: 1, interval: intro.walkFps }
          : { start: 6, end: 11, loops: 1, interval: intro.walkFps };
        $torii.spriteAnimate(options);
        cnt++;
        $torii.css({
          transition: intro.transition,
          transform: 'scale('+(cnt*cnt)*0.01+')'
        });
        setTimeout(function(){
          self.don('#scene01', 'walk0'+soundNum);
          soundNum++;
        }, intro.walkInterval ); 
        if ( cnt >= 10 ){
          self.timer.torii = setTimeout(function(){
            $torii.spriteAnimate({
              interval: intro.walkFps,
              start: 0,  // 6
              end: 2,  // 8
              loops: 1,
              after: fn
            });
          }, intro.walkInterval);
        } else {
          self.timer.torii = setTimeout(sprite, intro.walkInterval);
        }
      }
    }
  },

  introFirst: function ( fn ){
    $('#bottle,#footerLink').animate({ bottom: 10 },200,'easeOutCubic');
    $('header').animate({ top: 0 },200,'easeOutCubic',fn );
  },

  //鳥居ジャンプ
  toriiJump: function (fn){
    var self = this;
    $('#btnSkip').hide();
    $('#torii').hide();
    $('#toriiFixSet').show();
    $toriiFixImg = $('#toriiFix').find('img');
    $toriiFixImg.animate({
      height: 300
    },500,'easeInOutCubic',function(){
      $toriiFixImg.delay(200).animate({
        height: 422
      },200,'easeInCubic',function(){
        if ( !$.ua.isLtIE9 ){
          $('#toriiShadow').animate({
            opacity: 0.2
          },500,'easeOutCubic');
        }
        $('#toriiFix').animate({
          marginTop: '-300px'
        },500,'easeOutCubic',function(){
          if ( !$.ua.isLtIE9 ){
            $('#toriiShadow').delay(100).animate({
              opacity: 1
            },500,'easeInCubic');
          }
          $(this).delay(100).animate({
            marginTop: '0px'
          },500,'easeInCubic',function(){
            $toriiFixImg.animate({
              height: 380
            },200,'easeOutCubic',function(){
              $(this).delay(200).animate({
                height: 422
              },200,'easeInOutCubic',fn);
            });
            self.don('#scene01','walkJumpdown');
          });
        });
      });
    });
  },

  scene2: function(){
    var self = this;
    _gaq.push(['_trackPageview', '/8x4/ashikusa/omikuji_play']);

    //selectorをセット
    self.$htmlbody = $('html,body');
    self.$omikuji = $('#omikujiFixed');
    self.$omikuji.$box = $('#omikujiFixed .box');
    self.$omikuji.$inner = $('#omikujiFixed .boxInner');
    self.$omikuji.bar = $('#omikujiFixed .bar');
    self.$snsBtnBtm = $('#snsBtnBtm');
    self.$resultBody = $('#resultBody');
    self.$resultRoll = $('#resultRoll');
    self.$splayImg = $('#contentsBg .spray img');
    self.$smallLogo = $('#smallLogo');

    //shake初期値
    self.shake = {
      timer : 0,
      level : 1,
      vertical : 3,
      degree : 0.5,
      interval : 200,
      max : 30,
      time : 0
    };

    //導入
    self.$resultBody.empty();
    self.$resultRoll.show().css({top: 20});
    $('body').css({paddingBottom: 100});
    self.container.css({zIndex:2});
    self.$snsBtnBtm.show();
    $('#bottomIllust').show();
    self.$omikuji.animate({top: '50%'},500,'easeOutCubic');
    self.$smallLogo.delay(500).animate({top: 14},500,'easeOutCubic');
    self.$splayImg.each(function(i){
      $(this).delay(i*50).animate({marginTop:0},500,'easeOutCubic');
    });
    self.SE.ohayashi.play();

    //スクロールファンクション
    self.win.on({
      scroll: function(event){
        if( self.shake.level < self.shake.max ){
          self.win.scroll.top = $(this).scrollTop();
          var diff = self.win.scroll.top - self.win.scroll.top_x;
          self.win.scroll.direction = diff > 0 ? 'down' : 'up';
          if( self.win.scroll.direction_x != self.win.scroll.direction){
            self.scrollChange();
          }
          self.win.scroll.top_x = self.win.scroll.top;
          self.win.scroll.direction_x = self.win.scroll.direction;
        } else {
          clearTimeout(self.shakeTimer);
        }
      }
    });
  },
  scrollChange : function(){
    var self = this;
    var direction = self.win.scroll.direction == 'down' ? -1 : 1;
    
    var vertical = direction * self.shake.vertical * self.shake.level;
    self.shake.time = self.shake.level % 2 == 0 ? self.shake.time +1 : self.shake.time;
    var degreedirection = self.shake.time % 2 == 0 ? 1 : -1;
    var degree = direction * degreedirection * self.shake.degree * self.shake.level;
    self.SE.shake.stop();
    self.SE.shake.play({volume: self.shake.level*25 });

    self.$omikuji.$inner.css({ transform: 'rotate('+ degree +'deg)'});
    self.$omikuji.$box.stop().css({
      top : vertical
    }).stop().animate({
      top: 0
    },{
      duration: 300,
      eashing:'easeOutCubic',
      step: function(curentTop){
        var currentDeg = curentTop / vertical * degree;
        self.$omikuji.$inner.css({transform: 'rotate('+ currentDeg +'deg)'});
      },
      complete: function(){
        $(this).animate({
          top : vertical
        },{
          duration: 300,
          easing: 'easeInCubic',
          step: function(curentTop){
            //var currentDeg = curentTop / vertical * degree;
            //$(this).find('.img').css({transform: 'rotate('+ - currentDeg +'deg)'});
          },
          complete: function(){
            //おみくじ成功判定
            if( self.shake.level == self.shake.max ){
              self.$omikuji.bar.stop().animate({height: 164, bottom:2000},300,'easeInOutCubic',function(){
                self.$omikuji.stop().delay(1000).animate({top: '-50%'},500,'easeInOutCubic',function(){
                  self.$omikuji.bar.css({height: 0, bottom:400});
                  self.SE.ohayashi.stop();
                  self.sceneChange('scene3');
                });
              });
              self.$htmlbody.stop().animate({scrollTop: 0},500,'easeInOutCubic');
              //setTimeout(function(){self.shake.level = 1;}, 1000);
              
            } else {
              self.$omikuji.bar.stop().animate({height: 0},300,'easeInOutCubic');
            }

            $(this).animate({
              top: 0,
            },{
              duration: 300,
              eashing:'easeOutCubic',
              step: function(curentTop){
                //var currentDeg = curentTop / vertical * degree;
                //$(this).find('.img').css({transform: 'rotate('+ - currentDeg +'deg)'});
              },
              complete: function(){
              }
            });
          }
        });
      }
    });

    var barHeight = 164 / self.shake.max * self.shake.level;
    self.$omikuji.bar.css({height: barHeight,bottom:400});

    self.shake.level++;
    clearTimeout(self.shakeTimer);
    self.shakeTimer = setTimeout(function(){
      self.shake.level = 1;
    }, self.shake.interval);

  },
  
  directScene3 : function(){
    var self = this;
    //selectorをセット
    self.$htmlbody = $('html,body');
    self.$omikuji = $('#omikujiFixed');
    self.$omikuji.$box = $('#omikujiFixed .box');
    self.$omikuji.$inner = $('#omikujiFixed .boxInner');
    self.$omikuji.bar = $('#omikujiFixed .bar');
    self.$snsBtnBtm = $('#snsBtnBtm');
    self.$resultBody = $('#resultBody');
    self.$resultRoll = $('#resultRoll');
    self.$splayImg = $('#contentsBg .spray img');
    self.$smallLogo = $('#smallLogo');
    self.sceneChange('scene3');

  },

  scene3 : function(){
    var self = this;

      self.$splayImg.each(function(i){
        $(this).delay(i*50).animate({marginTop:0},500,'easeOutCubic');
      });
      if(!self.flag.directResult){
        _gaq.push(['_trackPageview', '/8x4/ashikusa/omikuji_result_'+self.result]);
      }

    self.win.off('scroll');
    self.$resultBody.load('result_'+self.result+'.html #result',function(){
      $(this).imagesLoaded(function(){
        $(this).find('#shareTw').on({
          click: function(){
            _gaq.push(['_trackPageview', '/8x4/ashikusa/result_share_twitter']);
          }
        });
        $(this).find('#shareFb').on({
          click : function(){
            _gaq.push(['_trackPageview', '/8x4/ashikusa/result_share_facebook']);
          }
        });


        //おみくじオープン
        self.SE.get.play();
        $(this).find('#resultWrapper').animate({height: 1798},1000,'linear');
        self.$resultRoll.animate({top: 1818},1000,'linear');
        

        setTimeout(function(){
          self.$resultRoll.hide();
          self.SE.get.stop();
        }, 1000);

        setTimeout(function(){
          self.SE.IyoB.play();
        }, 500);


        self.$htmlbody.delay(500).animate({scrollTop: 1798},1000,'linear');

        setTimeout(function(){
          self.$htmlbody.stop().animate({scrollTop: 0},500,'easeInOutCubic');
        }, 1750);

        //シェアボタンオーバー
        $(this).find('.opa').on({
          mouseenter : function(){
            $(this).css({opacity: 0.6});
          },
          mouseleave : function(){
            $(this).css({opacity: 1});
          }
        });

        $('#resultBack a').rollover();
        self.resultCleaning( $('#resMiko') );
        $(this).find('#resultBack a').on({
          click : function(){
            _gaq.push(['_trackPageview', '/8x4/ashikusa/replay']);
            self.SE.Don_short.play();
            self.$htmlbody.stop().animate({scrollTop: 0},500,'easeInOutCubic');
            self.$smallLogo.delay(500).animate({top: -100},500,'easeOutCubic');
            $(self.$splayImg.get().reverse()).each(function(i){
              $(this).delay(i*50 + 500).animate({marginTop:1500},500,'easeInCubic');
            });

            if ( self.flag.directResult ){
              location.href = './';
              return false;
            } else {
              setTimeout(function(){
                self.sceneChange('scene1');
              }, 2000);
              return false;
            }
          },
          mouseenter : function(){
//            $(this).find('img').css({opacity: 0.6});
          },
          mouseleave : function(){
//            $(this).find('img').css({opacity: 1});
          }
        });

      });
    });
  },


  resultCleaning: function ($target){
    var self = this
    $target.spriteAnimate({
      delay: 300,
      interval: 100,
      start: 0,
      end: 3,
      loops: 1,
      after: function(){
        $target.spriteAnimate({
          interval: 200,
          start: 3,
          end: 4,
          loops: 1,
          after: function(){
            self.resultCleaning($target);
          }
        });
      }
    });
  }

};

ashikusa.init();


//rollover
$.fn.rollover = function(suffix, hoverClass, opacity ) {
  var suffix = suffix || '_over';
  var hoverClass = hoverClass ? hoverClass.replace('.','') : 'hover'
  var opa = opacity ? opacity : '0.5';
  var target = this;
  return target.each(function() {
    if ( ( $(this).is('img') == true || $(this).is('input[type=image]') == true )    && $(this).not ('[src*="'+ suffix +'."]') ){
//        $(this).not ('[src*="'+ suffix +'."]').each(function(j) {
        var img = $(this);
        var src = img.attr('src');
        var _on = [
          src.substr(0, src.lastIndexOf('.')),
          src.substring(src.lastIndexOf('.'))
        ].join(suffix);
        $('<img>').attr('src', _on);
        img.on({
          mouseenter: function(){
            img.attr('src', _on);
          },
          mouseleave: function(){
            img.attr('src', src);
          }
        });
//        });
    } else {
      $(this).find('img').not ('[src*="'+ suffix +'."]').each(function(j) {
        var img = $(this);
        var src = img.attr('src');
        var _on = [
          src.substr(0, src.lastIndexOf('.')),
          src.substring(src.lastIndexOf('.'))
        ].join(suffix);
        if ( !($(this).hasClass('ovOpa')) && !($(this).hasClass('noOv')) ){
          $('<img>').attr('src', _on);
        }
        target.on({
          'mouseenter': function(){
            $(this).find(img).each(function(i){
              if ($(this).hasClass('ovOpa')){
                $(this).css({ opacity: opa });
              } else if ($(this).hasClass('noOv')) {
              } else {
                $(this).attr('src', _on);
              }
            });
          },
          mouseleave: function(){
            $(this).find(img).each(function(i){
              if ($(this).hasClass('ovOpa')){
                $(this).css({ opacity: 1 });
              } else if ($(this).hasClass('noOv')) {
              } else {
                $(this).attr('src', src);
              }
            });
          }
        });
      });
      target.on({
        mouseenter: function(){
          $(this).addClass(hoverClass);
        },
        mouseleave: function(){
          $(this).removeClass(hoverClass);
        }
      });
    }
  });
}

$.fn.spriteAnimate = function( options ){
  var defaultOptions = {
    width: null,    // number
    interval: 100,  // number
    start: null,    // number
    end: null,      // number
    loops: null,    // number
    delay: 0,    // number
    element: null,  // '.example' or '#example'
    after: function(){}     // function
  };
  var pref = {};
  $.extend( pref, defaultOptions, options );
  var timerID;
  var w = pref.width ? pref.width : $(this).width();
  var len = Math.round( $(this).children('img').width() / w );
  var item = pref.element ? $(this).find( pref.element ) : $(this).children();
  var i = pref.start ? pref.start : 0;
  var start = i;
  var end = pref.end ? pref.end+1 : len;
  var loops = pref.loops ? pref.loops : null;
  var loopNum = 0;
  clearTimeout(timerID);
  if ( $.support.transform == true ){
    item.css({ transform: 'translate( ' + (-w * i) + 'px, 0 )' });
  } else {
    item.css({ 'margin-left': -w * i });
  }
  setTimeout( charloopCallback ,pref.delay);
  function charloopCallback(){
    if ( loops && i == start ){
      if ( loopNum >= loops ){
        pref.after();
        return false;
      }
      loopNum++;
    }
  //    item.css({ 'margin-left': -w * i });
  if ( $.support.transform == true){
    item.css({ transform: 'translate('+ -w * i +'px,0)' });
  } else {
    item.css({ 'margin-left': -w * i });
  }
    timerID = setTimeout( charloopCallback ,pref.interval);
    i = (end-1) > i ? i+1 : start;
  }
};

function getUrlVars( key ){
  var vars = {}, val;
  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for(var i = 0; i < hashes.length; i++){
    val = hashes[i].split('=');
    vars[val[0]] = val[1];
  }
  if ( key ){ return vars[key]; }
  return vars;
}

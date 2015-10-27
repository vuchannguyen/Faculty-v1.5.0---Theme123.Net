(function($, window, document, undefined){
	

	$.fn.exists = function () {
	    return this.length > 0 ? this : false;
	}


	//Handle window resize
	var resizeFlag=0;  
	$(window).resize(function(){
	    resizeFlag=1;
	})
	checkSizeChange();
	function checkSizeChange(){
	    if (resizeFlag) {
	      resizeFlag=0;
	      $(window).trigger('resized');
	    }
	    setTimeout(function(){
	      checkSizeChange();
	    }, 200);
	}



	$(window).on('newContent',function(){
		initiate();
	});

	$(document).ready(function(){
		initiate();
	});

	function initiate(){
		//tooltips
		$(".tooltips").tooltip();

		//accardeion setup
		$("ul.timeline").children().eq(0)
			.find(".text").slideDown()
			.addClass("open");

		//labcarousel init
		generateLabCarousel();


		//remix the publications
		buildMixitup();

		//magnific on gallery
		magnificPopup();

		//stellar ~ depricated since 1.4.0
		//sterllarIt();

		//masonry for gallery
		galleyMasonry();
	}


	var generateLabCarousel= function() {
		
		prepareCarousel();
		function prepareCarousel(){
			var $carouselContainer = $('#labp-heads-wrap'),
				$dummyItems=$('.dummy-lab-item'),
				$imageWrapper=$('#lab-carousel'),
				$contentWrapper=$('#lab-details');

			$dummyItems.each(function(){
				$(this).children().eq(0).appendTo($imageWrapper);
				$(this).children().eq(0).appendTo($contentWrapper);
				$(this).remove();
			});
		}
		var defaultCss = {
			width: 100,
			height: 100,
			marginTop: 50,
			marginRight: 0,
			marginLeft: 0,
			opacity: 0.2
		};
		var selectedCss = {
			width: 150,
			height: 150,
			marginTop: 30,
			marginRight: -25,
			marginLeft: -25,
			opacity: 1
		};
		var aniOpts = {
			queue: false,
			duration: 300,
			//easing: 'cubic'
		};
		var $car = $('#lab-carousel');
		$car.find('img').css('zIndex', 1).css( defaultCss );

		$car.children('div').each(function(i){
			$(this).data('index',i);
		});

		$car.carouFredSel({
			circular: true,
			infinite: true,
			width: '100%',
			height: 250,
			items: {
				visible:3,
				start:1
			},
			prev: '#prev',
			next: '#next',
			auto: false,
			swipe : {
				onTouch :true,
				onMouse :true
			},
			scroll: {
				items: 1,
				duration: 300,
				//easing: 'cubic',
				onBefore: function( data ) {
					var $comming = data.items.visible.eq(1),
						$going = data.items.old.eq(1),
						$commingdetail = $("div#lab-details div").eq($comming.data('index')),
						$goingdetail = $("div#lab-details div").eq($going.data('index'));

					
					$goingdetail.fadeOut(100,function(){
						$goingdetail.siblings().hide();
						$commingdetail.fadeIn(300);
					});
					

					$comming.find('img').css('zIndex', 2).animate( selectedCss, aniOpts );
					data.items.old.eq(1).find('img').css('zIndex', 1).animate( defaultCss, aniOpts );
				}
			}

		});
	}

	var magnificPopup = function(){
		$('.popup-with-move-anim').magnificPopup({
			type: 'image',

			fixedContentPos: false,
			fixedBgPos: true,

			overflowY: 'auto',

			closeBtnInside: true,
			preloader: false,
			
			midClick: true,
			removalDelay: 400,
			mainClass: 'my-mfp-slide-bottom'
		});
	}

	//depricated since 1.4.0
	// var sterllarIt = function(){
	// 	$(".stellar").stellar({
	//   		verticalOffset: -100,
	//   		horizontalScrolling: false,
	// 	});
	// }

	var galleyMasonry = function(){
		
		var $container = $('#grid');
		// initialize
		$container.imagesLoaded(function(){
			$container.masonry({
			  itemSelector: 'li'
			});
		});
		
	}

	
	/**
	*	Utility function to add extera css and js to the DOM
	*	$head : the cached jquery object of <head> of parrent page
	*	$foot : the cached jquery object of footer of parrent page
	*	$dt : htmlDoc of the loaded page
	**/
	var apperndCssJs = function($head,$foot,$dt){
		
		
		//handel linked styles
		$dt.find("link").each(function() {

			var cssLink = $(this).attr('href');
			var isnew = 0;

			if ($head.children('link[href="' + cssLink + '"]').length == 0 && $foot.children('link[href="' + cssLink + '"]').length == 0)
				isnew = 1;
			if (isnew == 1)
				$head.append($(this)[0]);
			
		});

		// handel linked scripts files
		$dt.find("script").each(function() {
			
			//console.log($(this)[0]);
			var jsLink = $(this).attr('src');
			
			//we dont have bussiness with inline scripts of new page
			if (typeof jsLink != 'undefined'){
				if ($head.children('script[src="' + jsLink + '"]').length == 0 && $foot.children('script[src="' + jsLink + '"]').length == 0){
					$foot.append($(this)[0]);
				}	
			}
		});
	}


	var pager = {
		pageContainer : $("div#main"),
		pages : $("div.fac-page"),
		menuItems: $("ul#navigation"),
		overlay : $("div#overlay"),
		topz : "500",

		init: function(){

			var self = this;
			self.menuItems.on('click','li.ajax-fac', function(e){
				
				e.preventDefault();
				var $li = $(this),
					target_url = $li.children('a').attr('href'),
					$target = $('div[data-url="'+target_url+'"]').first(),
					currentPosition = $target.attr('data-pos') || 'ajax', 
					$secondary = $("div#main").children(".currentpage");

				

				if ( currentPosition == 'ajax') 
				{

					$target = $('<div class="fac-page" data-url="'+target_url+'"><div class="loading"></div></div>').appendTo(self.pageContainer);
					currentPosition = "p1";
				}


				switch (currentPosition){
					case "home" :
						self.reset();
						break;
					case "p1" :
						self.forward($target,$secondary,target_url);
						break;
					case "p3" :
						//console.log(self.maxz());
						if ( parseInt($target.attr('data-order')) === self.maxz() )
						{	
							// var $gotop2 = $target,
							// 	$gotop1 = $secondary;
							self.backward($target,$secondary);
						} else {
							self.forward($target,$secondary);
						}
					break;
					default:
						return false;
				}
			});

			self.overlay.on('click',function(){
				var $secondary = $("div#main").children(".currentpage");
				var $target = $("div#main").children("[data-order="+self.maxz()+"]");
				self.backward($target,$secondary);
			});

		},

		reset : function (){

			//this.overlay.hide();
			
			/*var $gotop1 = $("div.fac-page");
			$gotop1.attr('data-pos','p1').removeAttr('data-order');
			TweenLite.to($gotop1,0.4,{left:"100%",zIndex:0, onComplete:function(){
				$gotop1.remove();	
			}});*/
			
			// this.hanndelMenu();
		},

		forward : function(gotop2 , /* optional */ gotop3, url){

			var self = this;
			self.hanndelMenu(gotop2);
			self.overlay.show();
			var maxz = self.maxz();
			gotop2.addClass('currentpage');
			gotop2.attr('data-pos','p2').removeAttr('data-order');
			gotop3.attr('data-pos','p3').attr('data-order',maxz+1);
			

			( new TimelineLite() )
				.set(gotop2,{ left:"100%",zIndex:300})
				.set(gotop3,{zIndex:maxz+1})
				.to(gotop2,0.4,{left:"15%"})
				.to(gotop3,0.3,{ left:0 , onComplete:function(){
					gotop3.removeClass('currentpage');
					
					if (url){
						self.makeAjax(url,gotop2,function(){
							$(window).trigger('newContent');
						});	
					}
					
				} },"-=0.2");
		},

		makeAjax: function(url,$el,callback){
			
			var self= this;

			$.ajax({
				url : url,
				type : "GET",
				dataType : "html"
			})
			.done(function(data) {
				
				
				//current head and foot of the page
				var $head = $('head'),
					$foot = $("#facwpfooter");

				//add extera css and js to the DOM
				apperndCssJs($head,$foot,$(data));
				
				//inject into html
				var $contents = $(data).find('#inside');
				$el.html($contents);

			})
			.fail(function() {
				alert( "error" );
			})
			.always(function() {
				if ( typeof callback == 'function')
					callback();
			});
		},
		backward : function (gotop2,gotop1){
			

			this.hanndelMenu(gotop2);
			gotop2.exists() || this.overlay.hide();
			gotop2.addClass('currentpage').removeAttr('data-order').attr('data-pos',"p2");
			
			(new TimelineLite())
				.set(gotop2,{zIndex:301})
				.to(gotop2,0.4,{left:"15%"})
				.to(gotop1,0.5,
					{
						left:"100%",
						onComplete : function(){
							gotop1.remove();
						}
					},
				"-=0.3");

		},

		maxz : function(){
			
			var levelArray = $("div.fac-page").map( function() {
			    return $(this).attr('data-order');
			}).get();
			maxz = levelArray.length && Math.max.apply( Math, levelArray );
			return maxz;
		},

		hanndelMenu : function(){
			

			var menuIndex = ( arguments.length ) ? ( (arguments[0].length) ? arguments[0].attr('data-url') : 0 ):0,
				$find = this.menuItems.children('li').find('a[href="'+menuIndex+'"]'),
				$currentmenu;
			
			if ($find.length == 1)
			{
				$currentmenu = $find.parent("li");

			} else {
				$currentmenu = this.menuItems.children().eq(menuIndex);	
			}
			
			$currentmenu
				.addClass('current-menu-item')
				.siblings().removeClass('current-menu-item');
			

		}
	}
	pager.reset();
	pager.init();

	var buildMixitup = function(){
		$('div#pub-grid').mixitup({
			layoutMode: 'list',
			easing : 'snap',
			transitionSpeed :600,
			onMixEnd: function(){
				$(".tooltips").tooltip();
			}
		}).on('click','div.pubmain',function(){
			var $this = $(this), 
				$item = $this.closest(".item");
			
			$item.find('div.pubdetails').slideToggle(function(){
				$this.children("i").toggleClass('icon-collapse-alt icon-expand-alt');
			},function(){
				$this.children("i").toggleClass('icon-expand-alt icon-collapse-alt');
			});
		});

		//default filtering based on theme options
		if ( pubsFilter != 'false'){
			$('div#pub-grid').mixitup('filter',pubsFilter);	
			$("#miu-filter").find("[value='"+pubsFilter+"']").addClass('active').siblings().removeClass('active');
		}
		

		$( '#cd-dropdown' ).dropdownit( {
			gutter : 0
		} );

		$("[name=cd-dropdown]").on("change",function(){
			var item = this.value;		
			$('div#pub-grid').mixitup('filter',item);
		});

		$("#miu-filter").on('click','span',function(){
			
			var item = $(this).attr('value');
			console.log(item);
			$('div#pub-grid').mixitup('filter',item);
			$(this).addClass('active').siblings().removeClass('active');
		})
	}

	

	/*++++++++++++++++++++++++++++++++++++
		sidebar
	++++++++++++++++++++++++++++++++++++++*/
	var sideS, sidebar = {
		settings : {
			$side : $(".social-icons, #main-nav"),
			$main : $("#main"),
			$trigger : $("a.mobilemenu"),
			$totaltrigger : $(".social-icons, #main-nav, #main"),
		},

		init : function(){
			sideS = this.settings;
			this.bindUiActions();

			//Remove Social icons
			var $socialIcons=$('.social-icons');
			if ($socialIcons.find('li').length==0){
				$socialIcons.css('display','none');
				$('#main-nav').css('bottom','0px');
			}
		},

		isIn : function(){
			var isIn = false;
			if (sideS.$main.hasClass("sideIn"))
				isIn = true;
			return isIn;
		},

		bindUiActions : function(){
			var self = this;
			sideS.$trigger.click(function(){
				if (self.isIn()){
					self.sideOut();
				}else{
					self.sideIn();
				}
			});
			sideS.$totaltrigger.click(function(){
				if ($(window).width() < 960 && self.isIn())
					self.sideOut(); 
			});

			$(window).on('resized',function(){
				var winWidth = $(window).width();
				//console.log(winWidth);
				if ( $(window).width() > 960 ){
					self.reset();
				}else{
					self.gomobile();
				}
			});
		},

		sideIn : function() {
			var self = this;
			var SidebarAnimIn = new TimelineLite({onComplete:function(){
				//console.log('side is in');
			}});
			SidebarAnimIn
				.to(sideS.$side,0.2,{left:0})
				.to(sideS.$main,0.2,{left:250,right:-250},"-=0.2");
			sideS.$main.addClass('sideIn');
		},

		sideOut : function(){
			var self = this;
			var SidebarAnimOut = new TimelineLite({onComplete:function(){
				//console.log('side is out');
			}});
			SidebarAnimOut
				.to(sideS.$side,0.2,{left:-250})
				.to(sideS.$main,0.2,{left:0,right:0},"-=0.2");
			sideS.$main.removeClass('sideIn');
		},

		reset : function(){
			sideS.$main.css({left:250, right:0});
			sideS.$side.css({left:0});
		},

		gomobile : function (){
			sideS.$main.css({left:0, right:0});
			sideS.$side.css({left:-250});	
		}

	}
	sidebar.init();





	/*++++++++++++++++++++++++++++++++++++++++++++++
		custom scrolls with perfectScroll plugin
	++++++++++++++++++++++++++++++++++++++++++++++++*/
	
	perfectScrollIt();
	$(window).on('newContent',function(){
		perfectScrollIt();		
	});

	function perfectScrollIt(){

		var $main_nav=$('#main-nav'),
			$fac_page=$('.fac-page');

		$main_nav.perfectScrollbar({
			wheelPropagation:true,
			wheelSpeed:80
		});

		if (perfectScroll=='on'){
			$fac_page.perfectScrollbar({
				wheelPropagation:true,
				wheelSpeed:80
			});			
		}
	}
	



	/*++++++++++++++++++++++++++++++++++++
		click event on ul.timeline titles
	++++++++++++++++++++++++++++++++++++++*/
	$("body").on("click","ul.timeline li", function(){
		$this = $(this);
		$this.find(".text").slideDown();
		$this.find(".text").addClass("open");
		$this.siblings('li').find(".text").slideUp();
		$this.siblings('li .text').removeClass("open");
	}).on('mouseenter','ul.timeline li',function(){
		$this = $(this);
		var anim = new TweenLite($(this).find(".subject"),0.4,{'padding-left':20, paused:true});
		($this.hasClass('open')) || anim.play();
	}).on('mouseleave','ul.timeline li',function(){
		var anim = new TweenLite($(this).find(".subject"),0.2,{'padding-left':0});
	});

	/*++++++++++++++++++++++++++++++++++++
		ul-withdetails details show/hide
	++++++++++++++++++++++++++++++++++++++*/
	
	$(window).on('newContent', function(){
		$("ul.ul-withdetails .imageoverlay").css("left",'-100%');
	});
	
	$("body").on('click','ul.ul-withdetails li .row',function(){
		$(this).closest("li").find(".details")
	        .stop(true, true)
	        .animate({
	            height:"toggle",
	            opacity:"toggle"
	        },300);
	}).on('mouseenter','ul.ul-withdetails li .row',function(){
		$this = $(this);
		var anim = new TweenLite($(this).closest("li").find(".imageoverlay"),0.4,{left:0});
	}).on('mouseleave', 'ul.ul-withdetails li .row', function(){
		var anim = new TweenLite($(this).closest("li").find(".imageoverlay"),0.2,{left:"-102%"});
	});

	/*++++++++++++++++++++++++++++++++++++
		gallery overlays and popups
	++++++++++++++++++++++++++++++++++++++*/ 
	$("body").on("mouseenter",".grid li",function(){
		new TweenLite($(this).find(".over"),0.4,{bottom:0,top:0});
	}).on("mouseleave",".grid li",function(){
		new TweenLite($(this).find(".over"),0.4,{bottom:"-100%", top:"100%"});
	});


	var bs,blog={
		settings : {
			triggerAnchor : $('.ajax-single'),
			triggerDiv : $('.post-ajax'),
			singleContainer : $("#ajax-single-post"),
			blogNavigation : $("#blog-navigation")
		},
		init: function(){

			bs=this.settings;
			this.handlePaginationOnSinglePage();
			this.bindUiActions();
			this.prepareLayout();
			this.handleComments();
			this.perfectScrollIt('sidebar');
			this.perfectScrollIt();
			

		},
		decide : function(){
			
			var hash = window.location.hash;

			if ( hash == "")
			{
				bs.triggerAnchor.first().trigger('firstload');
			}else{
				this.getByHash(hash);
			}
		},
		bindUiActions: function(){
			var self = this;

			$(window).on('blogdecide',function(){
				self.decide();
			});

			
			$("body").on('click firstload','.post-ajax',function(e){
				
				
				if (blogAjaxState != "off" || e.type != 'click'){
					
					e.preventDefault();
					var url = $(this).children('a').attr('data-url');
					var hash = "#"+$(this).attr("id");
					self.makeAjax(url,hash);
					
					$(this).addClass('active').siblings().removeClass('active');
				}
					
			});	
			
			

			$('window').on('resized',function(){
				self.prepareLayout();
			});

			$("body").on('newPost',function(){
        		self.handleComments();
        		self.handlePaginationOnSinglePage();
        		self.perfectScrollIt();
			});
			

			//blog navigation
			$("body").on('click','#blog-navigation a',function(e){
				
				e.preventDefault();

				var href = $(this).attr('href');

				var $container = $("#postlist");
                    	
            	self.appendLoading($container);

            	var children = [];
            	$container.find('.post').each(function(){
            		children.push(this);
            	});
            	TweenMax.staggerTo(children, 0.7, {left:"300%", onComplete:function(){

            	}}, 0.1);

				$.ajax({
                    type: 'get',
                    url: href,
                    error: function(XMLHttpRequest, textStatus, errorThrown){
                            $("#archive-content").prepend('<p class="alert alert-danger">'+errorThrown+'</p>');
                    },
                    success: function(data){
                    	
                    	$container.html(data);

						children = [];
						$container.find('.post').each(function(){
							children.push(this);
      					});

      					TweenMax.staggerFrom(children, 0.7, {left:"300%", ease: Power4.easeOut, onComplete:function(){
      						self.removeLoading($container);
      					}}, 0.1);
      					self.perfectScrollIt('sidebar');
                    }
                });

			});// ->blog navigation
			
			
			//sidebar hide
			$("body").on( 'click',"a#hideshow",function(event){
			    event.preventDefault();
			    if ($(this).hasClass("isOut") ) {
			    	$(this).children("span").fadeOut();
			    	$(this).children("i").addClass('fa-chevron-circle-right').removeClass('fa-chevron-circle-left');
			    	TweenLite.to($(this),0.5,{right:-35, ease:Power2.easeOut});
			        TweenLite.to($("#blog-side"),0.5,{right:0, ease:Power2.easeOut});
			        TweenLite.to($("#blog-content"),0.5,{width:"75%", ease:Power2.easeOut});
			        $(this).removeClass("isOut");
			    } else {
			    	$(this).children("span").fadeIn();
			    	$(this).children("i").addClass('fa-chevron-circle-left').removeClass('fa-chevron-circle-right');
			    	TweenLite.to($(this),0.5,{right:0, ease:Power2.easeOut});
			        TweenLite.to($("#blog-side"),0.5,{right:-$("#blog-side").width(), ease:Power2.easeOut});
			        TweenLite.to($("#blog-content"),0.5,{width:"100%", ease:Power2.easeOut});   
			        $(this).addClass("isOut");
			    }
			    return false;
			});
			
			//if you want to hide the blog sidebar by default, uncommnet this
			// $(document).ready(function(){
			// 	$("a#hideshow").trigger('click');	
			// });
			

			$(window).on('resized',function(){
				self.prepareLayout();
			});
			
		},
		getByHash: function(hash){

			$div = bs.triggerDiv.filter(hash);
			if ($div.length == 1){
				$div.trigger('click');
			}else{
				var url = siteUrl+hash.substring(1);
				this.makeAjax(url,hash); 
			}
		},
		makeAjax: function(url,hash){


			var self= this;

			$.ajaxSetup({cache:false});
			self.appendLoading(bs.singleContainer.parent());
			TweenLite.to(bs.singleContainer,0.5,{top:-200,autoAlpha:0, onComplete:function(){
				bs.singleContainer.css('top',"200px");
				
				$.ajax({
					type: "GET",
					url: url,
					dataType: "html",
					success: function (response) {

						//current head and foot of the page
						var $head = $('head'),
							$foot = $("#facwpfooter");

					

						//add extera css and js to the DOM
						apperndCssJs($head,$foot,$(response));

						//update content
						bs.singleContainer.html(
							$(response).find("#blog-content").html()
						);
						self.removeLoading(bs.singleContainer.parent());
						TweenLite.to(bs.singleContainer,0.5,{top:0,autoAlpha:1});
						
						//update page title
						var pageTitle = $(response).find("h2.title").text();
						if (typeof pageTitle != 'undefined'){
							document.title = pageTitle;
						}

						//update url
						window.location.hash = hash;
						
						//trigger 
						$('body').trigger('newPost');    
					},
					error: function (xhr, ajaxOptions, thrownError) {
						//alert(thrownError);
						self.removeLoading(bs.singleContainer.parent());
						bs.triggerAnchor.first().trigger('click');			
					}
			    });
			}});
				
		},
		appendLoading:function($el){
			$el.append('<div class="loading"></div>');
		},
		removeLoading : function($el){
			$el.find('.loading').remove();
		},
		//adjust the height of the sidebar for archives pages
		prepareLayout : function(){
			$("#archive-content").height($(document).height() - $('#archive-header').outerHeight() - $("#blog-navigation").outerHeight());
		},
		handleComments : function(){

			var commentform=$('#commentform'); // find the comment form
		        
	        commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors  
	        var statusdiv=$('#comment-status'); // define the infopanel
	  
	        commentform.submit(function(e){
	            
                e.preventDefault();

                //serialize and store form data in a variable
                var formdata=commentform.serialize();
                //Add a status message
                statusdiv.html('<p class="alert alert-info">Processing...</p>');
                //Extract action URL from commentform
                var formurl=commentform.attr('action');
                //Post Form with data
                $.ajax({
                        type: 'post',
                        url: formurl,
                        data: formdata,
                        error: function(XMLHttpRequest, textStatus, errorThrown){
                                statusdiv.html('<p class="alert alert-danger">You might have left one of the fields blank, or be posting too quickly</p>');
                        },
                        success: function(data, textStatus){
                                if(data=="success"){
                                    statusdiv.html('<p class="alert alert-success" >Thanks for your comment. We appreciate your response.</p>');
                                    
                                }else{
                                    statusdiv.html('<p class="alert alert-danger" >Please wait a while before posting your next comment</p>');
                                }
                                commentform.find('textarea[name=comment]').val('');
                        }
                });
                return false;
	        });
		},
		handlePaginationOnSinglePage : function(){
			
			if (typeof isSingle == 'boolean')
			{
				//see if we have pagination
				$("#blog-navigation a").each(function(){
					var url = $(this).attr('href');
					var parts = url.split( '/' );
					parts[parts.length-4] = 'blog';
					var newPathname = "";
					for ( i = 0; i < parts.length-1; i++ ) {
					  newPathname += parts[i];
					  newPathname += "/";
					}
					$(this).attr('href',newPathname);
				});
			}	
		},
		perfectScrollIt:function(){
			var scrollWrapper;
			if (arguments.length==0){
				scrollWrapper=$('#blog-content');
			}else{
				scrollWrapper=$('#archive-content');
			}
			
			scrollWrapper.scrollTop(0);
			
			if (perfectScroll=='on'){

				scrollWrapper.perfectScrollbar('destroy').perfectScrollbar({
					wheelPropagation:true,
					wheelSpeed:80
				});
			}
		}

	}

	blog.init();




})(jQuery, window, document);


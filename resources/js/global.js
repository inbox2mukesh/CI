$(document).ready(function() {

	if( $('.has-datetimepicker').length )
	{
	   $('.has-datetimepicker').datetimepicker();
	}

	if( $('.has-datepicker').length )
	{
	   $('.has-datepicker').datetimepicker({format: 'DD-MM-YYYY'});
	}

});



//common search
$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
       });
    });
});



//$("ul").empty();




//08feb2020
jQuery(function($){

    var pageURL = $(location).attr("href");
    let urllink = pageURL;
    let urlclass = urllink.replace("http://western-overseas.com/", " ");
    let urlcfinal = urlclass.replace(/\//g, " ").replace(/\?/g, " ");
    $('body').addClass(urlcfinal);

   	//end:urlClass

	//left side menu event + click
	$(".main-header .logo").before("<div class='header-menu-toggle'></div>");

	$(".header-menu-toggle").on('click', function(){
		$(".main-sidebar").addClass("active");
		$(".adminController").toggleClass("show-menu");
		$(this).toggleClass("active");
		//$('.main-sidebar').modal("show");
		$(".wrapper").before("<div class='modal-backdrop in'></div>");
		$('.modal-backdrop.in').click(function(){
			$('.modal-backdrop.in').remove();
   			$(".header-menu-toggle").removeClass("active");
			$("body").removeClass("show-menu");
			$('.main-sidebar').modal("hide");
			console.log(this);

  		});
    });





//document load 2second after
setTimeout(function(){


	//megamenu:active
	// $(".sidebar-menu li.mega-menu .treeview-menu").each(function(){
	//     if ( $(this).children().length > 0 ) {
	// 			//alert("value")
	// 		$(this).parent().parent().parent().addClass('emyes');
	// 	}
	// });



	//on page load html add
	$(".sidebar").before("<div class='siderbar-search'><form><input class='form-control' type='text' placeholder='Quick search page '><sapn class='clearInt'><i class='fa fa-times'></i></span><form></div>");
	$(".sidebar").after("<div class='header-menu-open close'></div>");
	$(".sidebar").after("<div class='help-support'></div>");
	$(".sidebar-menu").before("<div class='all-menu'><i class='fa fa-solid fa-house'></i>All</div>");

	//on page load style add
	$(".treeview-menu[style='display: block;']").parent().addClass("active");
	$(".treeview-menu[style='display: block;']").parent("sidebar-menu > li").css('display','none');
	$('.sidebar-menu li:has(.treeview-menu)').addClass('mClick');

	//compare condition
	if($(".sidebar-menu > li").hasClass('active')){
		$(".sidebar-menu > li").css('display','none');
		$(".sidebar-menu > li.active").css('display','block');
	}

	//for hide menu which have no child
	// $(".sidebar-menu > li > ul").each(function(i){
	// 		$(this).parent().addClass("isul");
	// });

	// $(".sidebar-menu > li:not(.isul)").addClass("noul").css("display","none");
	//$(".sidebar-menu > li > .treeview-menu").addClass("noul").css("display","none");


	// close left sidebar
	$(".header-menu-open").click(function(){
		$(".header-menu-toggle").removeClass("active");
		$("body").removeClass("show-menu");
		 $('.main-sidebar').modal("hide");
		 $('.modal-backdrop.in').remove();
	});


   //search_menu : start ========

	// 1: function main search
	let searchInput = document.querySelector('.siderbar-search .form-control');
	searchInput.addEventListener('keyup', menusearch);

	// get all title
	let titles = document.querySelectorAll('ul.sidebar-menu > li > a');
	let searchTerm = '';
	let tit = '';

	function menusearch(e) {
	  // get input fieled value and change it to lower case
	  searchTerm = e.target.value.toLowerCase();
	  var fileName = $(".siderbar-search .form-control").val();

	  titles.forEach((title) => {
	    // navigate to p in the title, get its value and change it to lower case
	    tit = title.textContent.toLowerCase();
	    // it search term not in the title's title hide the title. otherwise, show it.
	    tit.includes(searchTerm) ? title.style.display = 'block' : title.style.display = 'none';

	   	 if( !$(".siderbar-search .form-control").val() ) {
				$(".treeview-menu").css("display","none");
				$(".sidebar").removeClass('search-active');

			} else {
				$(".treeview-menu").css("display","block");
				$(".sidebar-menu > li.mClick").css('display','block');
				$(".sidebar-menu > li").css('display','block');
				$(".sidebar").addClass('search-active');

			}
		 });
	}


	// 2:function sub search
	let searchInput1 = document.querySelector('.siderbar-search .form-control');
	searchInput1.addEventListener('keyup', menussearch);
	let titles1 = document.querySelectorAll('ul.sidebar-menu li  a');

	function menussearch(e) {
	  // get input fieled value and change it to lower case
	  searchTerm = e.target.value.toLowerCase();
	  var fileName = $(".siderbar-search .form-control").val();
	  titles1.forEach((title) => {
	    // navigate to p in the title, get its value and change it to lower case
	    tit = title.textContent.toLowerCase();
	    // it search term not in the title's title hide the title. otherwise, show it.
	    tit.includes(searchTerm) ? title.style.display = 'block' : title.style.display = 'none';
		$(".sidebar-menu > li").removeClass('active');

		if( !$(".siderbar-search .form-control").val() ) {
			$(".sidebar-menu > li > a").css("display","block");
		} else {
			$(".sidebar-menu > li > a").css("display","none");
		}
	    });
	}


	//clear:inputSearch
	$(".clearInt").click(function(){
		$('.siderbar-search .form-control').val("");
		$('ul.sidebar-menu li a').css('display','block');
	});

	//search_menu : end =======

	$( ".sidebar-menu > li" ).addClass(function( index ) {

	    // click events
		$(".all-menu").click(function(){
			$(".treeview-menu").css('display','none');
			$(".sidebar-menu > li").css('display','block');
			$(".sidebar-menu > li.ul-empty").css('display','none');
			$(".sidebar-menu > li ").removeClass('menu-step-2');
			//$(".sidebar-menu > li").addClass('mClick');
			$('.sidebar-menu li:has(.treeview-menu)').addClass('mClick');
			$(".sidebar-menu > li").removeClass('nClick').removeClass('active');
			$('.siderbar-search form .form-control').val("");
			$('ul.sidebar-menu li a').css('display','block');

			$('.sub-child-active > .treeview-menu > .mClick').css('display','block');
			$(".mega-active > .treeview-menu > li.megayes ").removeClass("mega-li-active");

		});

		$('.sidebar-menu li:has(.treeview-menu)').click(function(){
			$(".sidebar-menu > li").css('display','none');
			$(".sidebar-menu > li").addClass('menu-step-2');
			$(".sidebar-menu > li").removeClass('mClick');
			$(".sidebar-menu > li > ul.treeview-menu").addClass('menu-open');
			$(".sidebar-menu > li > ul.treeview-menu").css('display','block');
			$('.siderbar-search form .form-control').val("");
			$('ul.sidebar-menu li a').css('display','block');


		});


		return "item-" + index;
	});



	// special common page compare
	if($(".sidebar-menu li.active").hasClass('mClick')){
		$(".sidebar-menu > li.active").addClass(function(i){
			if (i==0){
				return 'nClick sub-child-active';
			}	else {
				return 'nClick sub-child-unactive';
			}
		})
		$(".sidebar-menu li.active").removeClass('mClick');
		$(".sidebar-menu > li > ul.treeview-menu").addClass('menu-open');
		$(".sidebar-menu > li > ul.treeview-menu.menu-open > li").removeClass('active');
	}

	//start:treeview-menu onload active class search
	$('.sidebar-menu > li > ul.treeview-menu.menu-open > li a').each(function() {
	    var href = $(this).attr('href');
		if( href == pageURL){
			 $(this).parent().addClass("active");
		}
	});
	//end:treeview-menu onload active class search


	if ($('.nClick').hasClass('sub-child-unactive')){
		$('.sub-child-unactive .treeview-menu li').removeClass('active');
	}


	$(".filter-value li a").each(function(i,v){
		var fihref = $(this).attr('href');
		if( fihref == pageURL){
			$(this).parent().addClass("active");
		}

	 });


	//start:custom drop-down
	 if ($('.filter-value > li').hasClass('active')){
	 	var mn0 = $('.filter-value li.active a').text();
	 	$(".choose-filter-toggle").text(mn0);
	 }
	 //end:custom drop-down


	 //start:paginatuion
	 var ds = $(".mheight200 > .pull-right").html();
	 $(".mheight200").after(ds);
	 console.log(ds);
	 //start:paginatuion




//megamenu:condition


	$('.sidebar-menu > li > .treeview-menu').each(function() {

		if(!$(this).has('li').length) $(this).parent().addClass("ul-empty").css("display","none");

	});


	$(".sidebar-menu > .mega-menu .treeview-menu").each(function(){
		if ( $(this).children().length > 0 ) {
				//alert("value")
			$(this).parent().addClass('megayes');
		} else {
			$(this).parent().addClass('megano');
		}
	});

	$(".mega-menu > .treeview-menu > li").each(function(i){
		$(this).addClass('count'+i);
		if( $(this).hasClass("megayes") ){
			$(this).parent().parent().addClass('mega-active')
		}
	});

	$(".megayes > .treeview-menu").css('display','none');

	$(".mega-menu .megayes > a").click(function(){
		$('.mega-menu > .treeview-menu > .megayes').addClass('mega-li-deactive').css('display','none');
		$(this).parent().removeClass('mega-li-deactive').css('display','none');
		$(this).parent().addClass('mega-li-active').css('display','block');
		$(".mega-menu > a").css('display','none');
		$(".mega-menu > a").addClass('megamenu-step1');
	});

	$(".sidebar-menu .mega-menu > a").click(function(){
		$(".mega-menu > a").css('display','block');
		$(".mega-menu > a").removeClass('megamenu-step1');
		$('.mega-menu > .treeview-menu > li').removeClass('mega-li-deactive').css('display','block');
		$('.mega-menu > .treeview-menu > li').parent().removeClass('mega-li-active').css('display','block')
	});

	if ( $(".mega-menu").hasClass("sub-child-active")){
		$('.sub-child-active > a').css('display','none');
		$('.sub-child-active > .treeview-menu').css('display','block');
		$('.sub-child-active > .treeview-menu > .mClick').css('display','none');
	}

	$(".mega-active > .treeview-menu > li:not(.mClick)").addClass("mega-li-active");

	if ( $(".megayes").hasClass("mega-li-active")){
		$('.sub-child-active > .treeview-menu .treeview-menu').css('display','block');
	}



 },11);
//end:menu-left-side

	//url name
	if ( $("body").hasClass("adminController")) {
	     $( ".wrapper" ).addClass("active");
	};


	if($(window).width() >= 500) {

		 $(".box-tools").each(function(i,v){
		 	console.log(v,i);
			if( $(v).children().length > 3 ){
				$(v).wrapInner("<ul class='filter-value'></ul>");
				$(".filter-value").before("<div class='choose-filter-toggle'>Select menu</div>");
				$(v).children().children().wrap("<li></li>");
			}  else {
				console.log("No Need");
			}
		 });

		var hhj = $(".bgdiv_rep .has-feedback").after();
		console.log(hhj);

		$(".choose-filter-toggle").click(function(event){
			$(this).toggleClass("active");
			$(".filter-value").toggleClass("active");
			event.stopImmediatePropagation();
		});

		$(window).click(function() {
		   $(".filter-value").removeClass("active");
		   $("choose-filter-toggle").removeClass("active");
		});


		//start:student:student_full_details
		var e3= $(".nav-flex-right .nav-tabs li.active a").text();
		$(".nav-flex-right .nav.nav-tabs").before("<div class='choose-filter-toggle'>"+e3+"</div>");

		$(".nav-flex-right .choose-filter-toggle").click( function(event){
				$(".nav-flex-right .choose-filter-toggle").toggleClass("active");
				$(".nav-flex-right .nav-tabs").toggleClass("active");
				event.stopImmediatePropagation();
		})

		$(window).click(function() {
		   $(".nav-flex-right .choose-filter-toggle").removeClass("active");
		   $(".nav-flex-right .nav-tabs").removeClass("active");
		});


		$(".nav-flex-right .nav-tabs li a").each( function(){
			$(this).click( function(){
				var e4= $(this).text();
				$(".nav-flex-right .choose-filter-toggle").removeClass("active");
				$(".nav-flex-right .nav-tabs").removeClass("active");
				$(".choose-filter-toggle").text(e4);
			});
		})
		//end:student:student_full_details
	}


	$("table tr th").each( function(i){
		$(this).addClass("th-"+i);
	})



	//start:table content_readmore
	$('#myTable td > span:has(.text-success)').parent().parent().addClass("light-gry");

	 $(".table #myTable > tr > td").each(function(i, v){
	    if ( $(this).children().length > 0 ) {
				$(this).wrapInner();
		} else {
			$(this).wrapInner("<div class='td-text'></div>");
		}
	});


	//start:table content_readmore
	$(".td-text").each(function(i, v){
	   	let tml = $(this).text();
	    let tmlem = tml.replace(/ /g,"");
	    //console.log(i+":" +tml.length +":"+ tml );
		if (tmlem.length>75 ){
		    $(this).html('<span class="mx-height-20 index'+i+'">'+tml.substr(0,75)+'...'+'</span>').append("<span class='readmore-btn rd"+i+"'>More</span>");
		    $(".rd"+i).click(function(){
			 	$(this).toggleClass("active");
			 	$(this).parent().toggleClass("ht-auto");
				if ( $(".rd"+i).hasClass("active")) {
				 $(".index"+i).text(tml);
				  $(this).text(" Less");
				   //console.log(this);
				  } else {
				  	 $(".index"+i).text(tmlem.substr(0,75)+'...');
				  	 $(this).text("More");
				  	// console.log(this);
				  }
			});
		 }
	});
	//end:table content_readmore

	if ($("body").hasClass("manage_role_")) {
    	$("body").addClass("manage_role");
    }

	if ( $("body").hasClass("adminController package_transaction") || $("body").hasClass("adminController student") || $("body").hasClass("adminController user index") || $("body").hasClass("adminController user employee_list")) {
	     $( ".adminController" ).addClass("table-flate-ui");
	}
	//end:table-flate-ui

	if ( $("body").hasClass("adminController user employee_list") || $("body").hasClass("adminController user index") || $("body").hasClass("classroom_documents view_document_details_") || $("body").hasClass("announcements add") || $("body").hasClass("classroom_documents edit") || $("body").hasClass("announcements edit") || $("body").hasClass("Content_type_master edit") || $("body").hasClass("feedback_topic add") || $("body").hasClass("Content_type_master add") || $("body").hasClass("feedback_topic edit") || $("body").hasClass("Event_type edit") || $("body").hasClass("division_master edit") || $("body").hasClass("division_master add") || $("body").hasClass("department add") || $("body").hasClass("other_contents add") || $("body").hasClass("web_media edit") || $("body").hasClass("other_contents edit") || $("body").hasClass("adminController web_media add") || $("body").hasClass("adminController Counseling_session") || $("body").hasClass("adminController counseling_session") || $("body").hasClass("adminController Free_resources") || $("body").hasClass("adminController free_resources") || $("body").hasClass("adminController events") || $("body").hasClass("adminController Events") || $("body").hasClass("adminController Classroom_documents add") || $("body").hasClass("adminController classroom_documents add") || $("body").hasClass("adminController student_request add_request") || $("body").hasClass("adminController user change_password") || $("body").hasClass("adminController user profile_") || $("body").hasClass("adminController role edit") || $("body").hasClass("adminController category_master") || $("body").hasClass("adminController batch_master") || $("body").hasClass("adminController enquiry_purpose") ||  $("body").hasClass("adminController qualification_master") || $("body").hasClass("adminController designation_master") || $("body").hasClass("adminController source_master") || $("body").hasClass("adminController document_type") || $("body").hasClass("adminController time_slot_master") || $("body").hasClass("adminController language_master") || $("body").hasClass("adminController test_module") || $("body").hasClass("adminController programe_master") || $("body").hasClass("adminController request_subject") || $("body").hasClass("adminController complaint_subject") || $("body").hasClass("adminController exam_master") ||  $("body").hasClass("adminController faq_master") || $("body").hasClass("adminController our_products") || $("body").hasClass("adminController student_testimonials") || $("body").hasClass("adminController marketing_popups") || $("body").hasClass("adminController offers") || $("body").hasClass("adminController gallery") || $("body").hasClass("adminController city") || $("body").hasClass("adminController state") || $("body").hasClass("adminController country") || $("body").hasClass("adminController center_location") || $("body").hasClass("adminController recent_results") || $("body").hasClass("adminController practice_packages") || $("body").hasClass("adminController package_master") || $("body").hasClass("adminController mock_test") || $("body").hasClass("adminController workshop") || $("body").hasClass("adminController live_lecture") || $("body").hasClass("adminController shared_doc") || $("body").hasClass("adminController online_class_schedule") || $("body").hasClass("adminController classroom_post") || $("body").hasClass("adminController classroom_post") ||  $("body").hasClass("adminController classroom") || $("body").hasClass("adminController student") || $("body").hasClass("adminController student") || $("body").hasClass("adminController student_enquiry add_new_enquiry") || $("body").hasClass("adminController walkin add_walkin") || $("body").hasClass("adminController workshop search_workshop") || $("body").hasClass("adminController complaints_box add_complaint") || $("body").hasClass("adminController realty_test") || $("body").hasClass("adminController refund add") || $("body").hasClass("adminController waiver add") || $("body").hasClass("adminController dues recoverable_dues") || $("body").hasClass("adminController dues irrecoverable_dues") || $("body").hasClass("adminController student_attendance attendance_report") || $("body").hasClass("adminController student_attendance mark_attendance") || $("body").hasClass("adminController discount") || $("body").hasClass("adminController user add") || $("body").hasClass("adminController user edit")) {
	     $( ".content-wrapper" ).addClass("form-flate-ui");
	}
	//end:form-flate-ui

	if ( $("body").hasClass("counseling_session index") ||  $("body").hasClass("adminController discount special") || $("body").hasClass("student_testimonials textual_testimonials") || $("body").hasClass("adminController walkin") || $("body").hasClass("adminController Events") || $("body").hasClass("adminController events") || $("body").hasClass("adminController realty_test") || $("body").hasClass("adminController gallery") || $("body").hasClass("adminController center_location") || $("body").hasClass("adminController package_master") || $("body").hasClass("adminController shared_doc") || $("body").hasClass("adminController classroom") || $("body").hasClass("adminController package_transaction") ||  $("body").hasClass("adminController student") || $("body").hasClass("adminController complaints_box") || $("body").hasClass("adminController student_enquiry") || $("body").hasClass("adminController walkin index") || $("body").hasClass("adminController complaints_box index") || $("body").hasClass("adminController refund index") || $("body").hasClass("adminController waiver index") || $("body").hasClass("adminController user employee_list") || $("body").hasClass("adminController student_attendance mark_attendance") || $("body").hasClass("adminController user index") || $("body").hasClass("adminController discount index")) {
	     $( ".table-ui-scroller .box-body.table-responsive" ).addClass("table-hr-scroller");
	}
	//end:table hr scroller


	if ($("#modal-editDates").hasClass("modal")){
		$( "#modal-editDates" ).addClass("form-flate-ui");
     }


     if ( $("div").hasClass("customer_records") ) {
     	 $( ".content-wrapper" ).addClass("customer_records-step-3");
     	 $( ".customer_records" ).addClass("form-lc");
     	 $( ".customer_records_dynamic" ).addClass("form-lc");
     }


     if ( $("body").hasClass("adminController events edit") || $("body").hasClass("adminController events add") ||  $("body").hasClass("adminController Events add") ||  $("body").hasClass("adminController Events edit") ) {
     	 $( ".content-wrapper" ).addClass("events-flc");
     }


     if ( $("body").hasClass("adminController events") || $("body").hasClass("adminController Events")){
     	$( ".content-wrapper" ).addClass("events-tui");
     }


     // Events/add/3/1
     if ( $("body").hasClass("adminController Events add 3 1") || $("body").hasClass("adminController events add 3 1") ){
     	$( ".content-wrapper" ).addClass("events-step-3-1");
     }

     if ( $("body").hasClass("adminController Events add 3 2") || $("body").hasClass("adminController events add 3 2") ){
     	$( ".content-wrapper" ).addClass("events-step-3-2");
     }

	if ( $("body").hasClass("adminController Events add 3 3") || $("body").hasClass("adminController events add 3 3") ){
     	$( ".content-wrapper" ).addClass("events-step-3-3");
     }


	// Events/add/2/1
     if ( $("body").hasClass("adminController Events add 2 1") || $("body").hasClass("adminController events add 2 1") ){
     	$( ".content-wrapper" ).addClass("events-step-2-1");
     }


     if ( $("body").hasClass("adminController Events add 2 2") || $("body").hasClass("adminController events add 2 2") ){
     	$( ".content-wrapper" ).addClass("events-step-2-2");
     }


	if ( $("body").hasClass("adminController Events add 2 3") || $("body").hasClass("adminController events add 2 3") ){
     	$( ".content-wrapper" ).addClass("events-step-2-3");
     }


	// Events/add/1/1
     if ( $("body").hasClass("adminController Events add 1 1") || $("body").hasClass("adminController events add 1 1") ){
     	$( ".content-wrapper" ).addClass("events-step-1-1");
     }


     if ( $("body").hasClass("adminController Events add 1 2") || $("body").hasClass("adminController events add 1 2") ){
     	$( ".content-wrapper" ).addClass("events-step-1-2");
     }


	if ( $("body").hasClass("adminController Events add 1 3") || $("body").hasClass("adminController events add 1 3") ){
     	$( ".content-wrapper" ).addClass("events-step-1-3");
     }


	//end:table-flate-ui

	if ( $(".adminController.user.index").has("box-tools") || $(".adminController.role.add").has("box-tools")) {
	     $(".box-tools").addClass("box-rl-ui");
	}
	//end:headeer:role:click

	if ( $(".adminController.role.manage_controller_method").has("table-responsive")) {
	     $(".box-body").addClass("table-cb-none");
	}

	//end:box ui


    //for:checkbox-style
	$('.checkbox-btn-ui').each(function(i){
		$(this).wrapAll( "<span class='checkbox-ui-relative checkbox-count-"+i+"' />");
		$(this).after( "<span class='checkmark'></span>" );
	});


	// $(".checkbox input[type='checkbox']").after( "<span class='checkmark'></span>" );


	// $("input[type='checkbox'].checkbox_allmethod").after( "<span class='checkmark'></span>" );

	//$("input[type='radio']").after( "<span class='checkmark'></span>" );
	// $(".adminController.role.manage_role #select_all").after( "<span class='checkmark'></span>" );

	//$(".form-group input[type='file']").after( "<span class='checkfile form-control'>Choose a  file ...</span>" );

	//for:radio button
	$('.radio-btn-ui').each(function(i){
		$(this).wrapAll( "<span class='btn-ui-relative no-"+i+"' />");
		$(this).after( "<span class='radiobtn count"+i+"'></span>" );
	});


	$(".all-list").click(function(){
		$(".box-rl-ui").toggleClass("active");
	})

	//for:type:file-style
	$('.input-file-ui').each(function(i){

		$(this).wrapAll( "<span class='input-ui-relative' />");
		$(this).after( "<span class='checkfile form-control input-file-ui-100'>Choose a  file ...</span>" );

		$(this).parent().addClass("file"+i);
		$(this).change(function(e) {
			let fileName = e.target.files[0].name;
				//alert('The file name is : "' + fileName);
			$(".file"+i).children().eq(1).addClass("active");
			$(".file"+i).children().eq(1).text(fileName);
				//console.log(fileName);
		})
	});







    //for:table horizental scroller automatic

	 //for:table horizental scroller automatic

	 if($(window).width() >= 1340) {

		$(".table-ui-scroller .table-responsive .table").each(function(){

			var wd1100=$(this).width();

			var tablebody=$(this).parent().width();

		    console.log("table parent width :"+ tablebody +" table width: " + wd1100);

			if ( wd1100 == tablebody ){
				//alert("Equal");
				//console.log("table parent and table width is equal")
			} else {
		  		$(this).parent().before( "<div class='prevnext-cont'><button class='slidePrev' type='button'><i class='fa fa-angle-left' aria-hidden='true'></i></button><button class='slideNext' type='button'><i class='fa fa-angle-right' aria-hidden='true'></i></button></div>");
			}

		});

	} else if ($(window).width() > 1099){

		$(".table-ui-scroller .table-responsive .table").each(function(){
			var wd1200=$(this).width();
		    console.log("table width laptop: " + wd1200);
		   	if ( wd1200 > 1200 ){
		   		$(this).parent().before( "<div class='prevnext-cont'><button class='slidePrev' type='button'><i class='fa fa-angle-left' aria-hidden='true'></i></button><button class='slideNext' type='button'><i class='fa fa-angle-right' aria-hidden='true'></i></button></div>");
			}
		});

	} else if ($(window).width() > 768){
			console.log($(window).width());
			$(".table-ui-scroller .table-responsive .table").each(function(){
			var wd1200=$(this).width();
		    console.log("table width tab: " + wd1200);
		   	if ( wd1200 > 1000 ){
		   		$(this).parent().before( "<div class='prevnext-cont'><button class='slidePrev' type='button'><i class='fa fa-angle-left' aria-hidden='true'></i></button><button class='slideNext' type='button'><i class='fa fa-angle-right' aria-hidden='true'></i></button></div>");
			}
		});

	} else if ($(window).width() > 320){

		$(".table-ui-scroller .table-responsive .table").each(function(){
			// var wd1200=$(this).width();
		    // console.log("table width mobile: " + wd1200);

			var wd1200=$(this).width();
			var tablebody=$(this).parent().width();
		    console.log("table parent width:"+ tablebody +" table width: " + wd1200);

			if ( wd1200 == tablebody ){
				//alert("Equal");
			} else {
		   		$(this).parent().before( "<div class='prevnext-cont'><button class='slidePrev' type='button'><i class='fa fa-angle-left' aria-hidden='true'></i></button><button class='slideNext' type='button'><i class='fa fa-angle-right' aria-hidden='true'></i></button></div>");

			}
		});

	} else {

		console.log("table width waiting:");

	}

	//end:table horizental scroller automatic

	var wfl = $('.table-ui-scroller .table-responsive .table').width();

	$('.prevnext-cont .slideNext').each(function(){
		$(this).click(function(event) {
			event.preventDefault();
			$(this).parent().next().animate({scrollLeft: wfl}, 50);
		 });
	});

	$('.prevnext-cont .slidePrev').each(function(){
		$(this).click(function(event) {
			event.preventDefault();
			$(this).parent().next().animate({scrollLeft: 0}, 50);
			//$('.box-flex-widget  .filterBox + .prevnext-cont + .table-hr-scroller').animate({scrollLeft: 0}, 50);
		 });
	});

	//end:common table horizental scroller automatic










	$('.bg-info .prevnext-cont .slideNext').click(function() {
	   event.preventDefault();
	   $('.bg-info > .table-hr-scroller').animate({  scrollLeft: wfl }, 50);
	});


	$('.bg-info .prevnext-cont .slidePrev').click(function() {
	   event.preventDefault();
	   $('.bg-info >.table-hr-scroller').animate({  scrollLeft: 0}, 50);
	});


	$('.bg-success .prevnext-cont .slideNext').click(function() {
	   event.preventDefault();
	   $('.bg-success > .table-hr-scroller').animate({  scrollLeft: wfl }, 50);
	});


	$('.bg-success .prevnext-cont .slidePrev').click(function() {
	   event.preventDefault();
	   $('.bg-success > .table-hr-scroller').animate({  scrollLeft: 0}, 50);
	});


	$('.bg-warning .prevnext-cont .slideNext').click(function() {
	   event.preventDefault();
	   $('.bg-warning > .table-hr-scroller').animate({  scrollLeft: wfl }, 50);
	});


	$('.bg-warning .prevnext-cont .slidePrev').click(function() {
	   event.preventDefault();
	   $('.bg-warning > .table-hr-scroller').animate({  scrollLeft: 0}, 50);
	});


	$('.bg-danger .prevnext-cont .slideNext').click(function() {
	   event.preventDefault();
	   $('.bg-danger > .table-hr-scroller').animate({  scrollLeft: wfl }, 50);
	});


	$('.bg-danger .prevnext-cont .slidePrev').click(function() {
	   event.preventDefault();
	   $('.bg-danger > .table-hr-scroller').animate({  scrollLeft: 0}, 50);
	});



	//end:table horizental scroller automatic

   //for:table vertical scroller
	var ht200=$(".table-ui-scroller .table-responsive .table").height();
		if ( ht200 > 400 ){
		 $(".table-ui-scroller .table-responsive.box-body").addClass("mheight200");
		 // $(".table-responsive").before( "<div class='topbottom-cont'><button class='slidebottom' type='button' data-toggle='tooltip' data-placement='top' title='Scroll Top'><i class='fa fa-angle-up' aria-hidden='true'></i></button><button class='slidetop' type='button' data-toggle='tooltip' data-placement='left' title='Scroll Bottom'><i class='fa fa-angle-down' aria-hidden='true'></i></button></div>");
	}

    //  $('.slidetop').click(function() {
	//    event.preventDefault();
	//    $('.mheight200').animate({  scrollTop: "+=50px" }, "slow");
	// });
	//  $('.slidebottom').click(function() {
	//    event.preventDefault();
	//    $('.mheight200').animate({  scrollTop: "-=50px" }, "slow");
	// });


	//button hover class
	$(".topbottom-cont button, .prevnext-cont button").hover(function(){
	    $(this).addClass('active');
	    }, function(){
	    $(this).removeClass('active');
	});


	$(".box").has(".prevnext-cont").addClass("box-flex-widget");
	$("#phoneNumber").attr("placeholder", "Phone No");
	$("#bemail").attr("placeholder", "Email");


	//for mobile device
	if($(window).width() <= 500) {


		if ( $("body").hasClass("role manage_controller") || $("body").hasClass("internal_feedback_lead index")){

			$( ".table-ui-scroller .box-body.table-responsive" ).addClass("table-hr-scroller");
		}


		$(".box-tools").each(function(i,v){
		 	console.log(v,i);
			if( $(v).children().length > 1 ){
				$(v).wrapInner("<ul class='filter-value'></ul>");
				$(".filter-value").before("<div class='choose-filter-toggle'>Select menu</div>");
				$(v).children().children().wrap("<li></li>");
			}  else {
				console.log("No Need");
			}

		 });

		var hhj = $(".bgdiv_rep .has-feedback").after();
		console.log(hhj);


		$(".choose-filter-toggle").click(function(event){
			$(this).toggleClass("active");
			$(".filter-value").toggleClass("active");
			 event.stopImmediatePropagation();
		});


		$(window).click(function() {
		   $(".filter-value").removeClass("active");
		   $("choose-filter-toggle").removeClass("active");
		});
	}
   });

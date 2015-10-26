$(function() {
	initSearchLoadingBar();	
	initBigSearch();
});

function initHorizontalAccordion() {
    $jq('#accordion').liteAccordion({ 
      theme : 'dark', 
      containerWidth : 720, 
      containerHeight : 250, 
      slideSpeed : 600, 
      firstSlide : 1
    });
}

/**
 *
 */
function initBigSearch() {
    $('#big-search-text').val('Type here to search..').css('color','#e3e3e3').attr('autocomplete','off').focus(function() {
	    var str = $(this).val();
	    if(jQuery.trim(str) == 'Type here to search..') {
		$(this).val('').css('color','#333');
	    }
	}).blur(function() {
		var str = $(this).val();
		if(!jQuery.trim(str)) {
		    $(this).val('Type here to search..').css('color','#efefef');
		}
	    });

    $('#big-search-form').submit(function() {
	    var str = $('#big-search-text').val();
	    if(jQuery.trim(str) && jQuery.trim(str) != 'Type here to search..') {
		window.location = 'http://ethics.iit.edu/eelibrary/search/apachesolr_search/'+jQuery.trim(str);
	    } else {
		alert('Please enter a valid search string.');
	    }
	    return false;
	});
}

/**
 * Initializes tabs on the wwebsite whereever needed.
 */
function initTabs() {
    $('#eel-home-tabs').tabs();
    var activeSubtab1;
    $('#eel-home-tabs #tabs-1 .subtab-table .subtab-title a').click(function() {
	    //Disable the previously active tab.
	    if(activeSubtab1) {
		activeSubtab1.parent().removeClass('subtab-title-active');
		var contId = activeSubtab1.attr('href');
		$(contId).hide();
	    }

	    //Enable the clicked subtab.
	    $(this).parent().addClass('subtab-title-active');
	    var contId = $(this).attr('href');
	    $(contId).show();

	    activeSubtab1 = $(this);

	    return false;
	});
    $('#eel-home-tabs #tabs-1 .subtab-table .subtab-title:first a').click(); 

    var activeSubtab2;
    $('#eel-home-tabs #tabs-2 .subtab-table .subtab-title a').click(function() {
	    //Disable the previously active tab.
	    if(activeSubtab2) {
		activeSubtab2.parent().removeClass('subtab-title-active');
		var contId = activeSubtab2.attr('href');
		$(contId).hide();
	    }

	    //Enable the clicked subtab.
	    $(this).parent().addClass('subtab-title-active');
	    var contId = $(this).attr('href');
	    $(contId).show();

	    activeSubtab2 = $(this);

	    return false;
	});
    $('#eel-home-tabs #tabs-2 .subtab-table .subtab-title:first a').click(); 

    var activeSubtab3;
    $('#eel-home-tabs #tabs-3 .subtab-table .subtab-title a').click(function() {
	    //Disable the previously active tab.
	    if(activeSubtab3) {
		activeSubtab3.parent().removeClass('subtab-title-active');
		var contId = activeSubtab3.attr('href');
		$(contId).hide();
	    }

	    //Enable the clicked subtab.
	    $(this).parent().addClass('subtab-title-active');
	    var contId = $(this).attr('href');
	    $(contId).show();

	    activeSubtab3 = $(this);

	    return false;
	});
    $('#eel-home-tabs #tabs-3 .subtab-table .subtab-title:first a').click(); 
}

function initSubtabs() {
    var activeSubtab1;
    $('#htabs-1 .subtab-table .subtab-title a').click(function() {
	    //Disable the previously active tab.
	    if(activeSubtab1) {
		activeSubtab1.parent().removeClass('subtab-title-active');
		var contId = activeSubtab1.attr('href');
		$(contId).hide();
	    }

	    //Enable the clicked subtab.
	    $(this).parent().addClass('subtab-title-active');
	    var contId = $(this).attr('href');
	    $(contId).show();

	    activeSubtab1 = $(this);

	    return false;
	});
    $('#htabs-1 .subtab-table .subtab-title:first a').click(); 

    var activeSubtab2;
    $('#htabs-2 .subtab-table .subtab-title a').click(function() {
	    //Disable the previously active tab.
	    if(activeSubtab2) {
		activeSubtab2.parent().removeClass('subtab-title-active');
		var contId = activeSubtab2.attr('href');
		$(contId).hide();
	    }

	    //Enable the clicked subtab.
	    $(this).parent().addClass('subtab-title-active');
	    var contId = $(this).attr('href');
	    $(contId).show();

	    activeSubtab2 = $(this);

	    return false;
	});
    $('#htabs-2 .subtab-table .subtab-title:first a').click(); 

    var activeSubtab3;
    $('#htabs-3 .subtab-table .subtab-title a').click(function() {
	    //Disable the previously active tab.
	    if(activeSubtab3) {
		activeSubtab3.parent().removeClass('subtab-title-active');
		var contId = activeSubtab3.attr('href');
		$(contId).hide();
	    }

	    //Enable the clicked subtab.
	    $(this).parent().addClass('subtab-title-active');
	    var contId = $(this).attr('href');
	    $(contId).show();

	    activeSubtab3 = $(this);

	    return false;
	});
    $('#htabs-3 .subtab-table .subtab-title:first a').click(); 
}

/**
 * Displays the loading icon when user clicks on search.
 */
function initSearchLoadingBar() {
    //$('body').append("<div id='green-loading' style='width: 100px; height: 100px; display: none; position: absolute; z-index: 100; top: 200px; left: 250px; background: url(\"sites/all/modules/custom/youeye/media/green-loading.gif\");'></div>");
    $('#search-theme-form').submit(function() {
	    //$('#green-loading').show(); 
	    var search_val = $('#edit-search-theme-form-1').val();
	    if(!jQuery.trim(search_val)) {
		alert('Please enter a valid search string.');
		return false;
	    } 
	    return true;
	});

    $('#search-form').submit(function() {
	    var search_val = $('#edit-keys').val();
	    if(!jQuery.trim(search_val)) {
		alert('Please enter a valid search string.');
		return false;
	    } 
	    return true;	   
	});
}
$(document).ready(function()
{
	$("#clientsInactive").css("visibility","hidden");
	$("nav.nav a:first-child").click(function()
    {

        if($(this).hasClass("active")==false)
        { 
            $(this).addClass("active");
            $("nav.nav a:last-child").removeClass("active");
        }
        else
        { 
            $(this).removeClass("active");
            $(this).attr("active","off");
            $("nav.nav a:last-child").addClass("active");
        }
    
    });

    $("nav.nav a:last-child").click(function()
    {
    	$("#clientsInactive").css("visibility","visible");
        if($(this).hasClass("active")==false)
        { 
            $(this).addClass("active");
            $("nav.nav a:first-child").removeClass("active");
        }
        else
        { 
            $("nav.nav a:first-child").addClass("active");
        }
    });

});

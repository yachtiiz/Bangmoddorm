$(function() {

    var current_url = "";

    $("#select_dorm").live("change", function(event) {
        event.preventDefault();
        $("#sort_chosendate").removeAttr("value");
        url = "callback.php?showbook_dormID=" + $(this).val() + "&dormbook_order=" + $("#book_order").val() + "&dormbook_showpage=1";
        show_page = "callback.php?showpage_dormID=" + $(this).val() + "&dormbook_page=1";
        if ($(this).val() === "default") {
            $("#show_result").html("<tr><td colspan='8' style='text-align: center'> No Result </td></tr>");
            for (i = 1; i < 8; i++) {
                $("#show_result").append("<tr style='height: 51px'><td colspan='8'></td></tr>");
            }
            $("#show_book_page").html("");
        }
        else {
            document.getElementById("status_default").setAttribute("selected", " ");
            document.getElementById("sort_default").setAttribute("selected", " ");
            $("#show_status_page").html("");
            $("#show_sort_page").html("");
            $("#show_result").animate({
                opacity: 0
            }, 100, function() {
                current_url = url;
                $("#show_result").load(url, function() {
                    $("#show_result").animate({
                        opacity: 1
                    }, 200);
                });
            });
            $("#show_book_page").animate({
                opacity: 0
            }, 100, function() {
                $("#show_book_page").load(show_page, function() {
                    $("#show_book_page").animate({
                        opacity: 1
                    }, 200);
                });
            });
        }
        return false;
    });

    $(".page_book li a").live("click", function() {
        event.preventDefault();
        url = $(this).attr("href") + "&showbook_dormID=" + $("#select_dorm").val() + "&dormbook_order=" + $("#book_order").val();
        cur_page = "callback.php?dormbook_page=" + $(this).attr("value") + "&showpage_dormID=" + $("#select_dorm").val();
        $("#show_book_page").load(cur_page);
        $("#show_result").animate({
            opacity: 0
        }, 100, function() {
            current_url = url;
            $("#show_result").load(url, function() {
                $("#show_result").animate({
                    opacity: 1
                }, 200);
            });
        });
    });

    $("#book_order").live("change", function() {
        if ($("#select_dorm").val() !== "default") {
            url = "callback.php?showbook_dormID=" + $("#select_dorm").val() + "&dormbook_order=" + $(this).val() + "&dormbook_showpage=1";
            cur_page = "callback.php?showpage_dormID=" + $("#select_dorm").val() + "&dormbook_page=1";
            $("#show_status_page").html("");
            $("#show_sort_page").html("");
            $("#sort_chosendate").removeAttr("value");
            document.getElementById("status_default").setAttribute("selected", " ");
            $("#show_result").animate({
                opacity: 0
            }, 100, function() {
                $("#show_result").load(url, function() {
                    current_url = url;
                    $("#show_result").animate({
                        opacity: 1
                    }, 200);
                });
            });
            $("#show_book_page").animate({
                opacity: 0
            }, 100, function() {
                $("#show_book_page").load(cur_page, function() {
                    $("#show_book_page").animate({
                        opacity: 1
                    }, 200);
                });
            });
        }
    });


    $("#searching").live("keyup", function() {
        if ($("#select_dorm").val() !== "default") {
            event.preventDefault();
            $("#show_book_page").html("");
            $("#show_sort_page").html("");
            $("#show_status_page").html("");
            $("#sort_chosendate").removeAttr("value");
            document.getElementById("status_default").setAttribute("selected", " ");
            document.getElementById("sort_default").setAttribute("selected", " ");
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $(this).val().replace(/ /g, "+");
            if ($("#only_bookid").attr("checked")) {
                special_url = url + "&search_only=bookingID";
                $("#show_result").load(special_url);
                current_url = special_url;
            } else
            if ($("#only_date").attr("checked")) {
                special_url = url + "&search_only=expire_date";
                $("#show_result").load(special_url);
            } else
            if ($("#only_status").attr("checked")) {
                special_url = url + "&search_only=booking_status";
                $("#show_result").load(special_url);
            } else {
                $("#show_result").load(url);
                current_url = url;
            }
            if ($("#searching").val() === "") {
                $("#show_book_page").load("callback.php?dormbook_page=1&showpage_dormID=" + $("#select_dorm").val());
            }
        }
    });
    $("#only_bookid").click(function() {
        if ($("#select_dorm").val() !== "default") {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=bookingID";
            $("#show_result").load(url);
            current_url = url;
        }
    });
    $("#only_date").click(function() {
        if ($("#select_dorm").val() !== "default") {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=date";
            $("#show_result").load(url);
        }
    });
    $("#only_status").click(function() {
        if ($("#select_dorm").val() !== "default") {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+") + "&search_only=booking_status";
            $("#show_result").load(url);

        }
    });
    $("#all_type").click(function() {
        if ($("#select_dorm").val() !== "default") {
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#searching").val().replace(/ /g, "+");
            $("#show_result").load(url);
            current_url = url;
        }
    });

    $("#sort_chosendate").live("change", function() {
        if ($("#select_dorm").val() !== "default") {
            $("#show_book_page").html("");
            $("#show_status_page").html("");
            document.getElementById("sort_default").setAttribute("selected", " ");
            document.getElementById("status_default").setAttribute("selected", " ");
            url = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $(this).val() + "&search_only=date";
            cur_page = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&search_date=" + $(this).val() + "&search_date_page=1";
            $("#show_result").load(url);
            $("#show_sort_page").load(cur_page);
            current_url = url;
        }
    });

    $(".page_sort_date li a").live("click", function() {
        event.preventDefault();
        url = $(this).attr("href") + "&dormbook_id=" + $("#select_dorm").val() + "&booking_searching=" + $("#sort_chosendate").val() + "&search_only=date";
        cur_page = "callback.php?dormbook_id=" + $("#select_dorm").val() + "&search_date=" + $("#sort_chosendate").val() + "&search_date_page=" + $(this).attr("value");
        $("#show_sort_page").load(cur_page);
        $("#show_result").animate({
            opacity: 0
        }, 100, function() {
            current_url = url;
            $("#show_result").load(url, function() {
                $("#show_result").animate({
                    opacity: 1
                }, 200);
            });
        });
    });

    $("#search_status").on("change", function() {
        if ($('#select_dorm').val() !== "default") {
            if ($("#search_status").val() !== "default") {
                status = $("#search_status").val();
                url = "callback.php?dormbookID=" + $("#select_dorm").val() + "&search_by_status=" + $(this).val();
                searchpage = "callback.php?search_by_status=" + $(this).val() + "&search_status_page=1" + "&dormID=" + $("#select_dorm").val();
                $("#show_book_page").html("");
                $("#show_sort_page").html("");
                $("#sort_chosendate").removeAttr("value");
                document.getElementById("sort_default").setAttribute("selected", " ");
                $("#show_result").animate({
                    opacity: 0
                }, 100, function() {
                    current_url = url;
                    $("#show_result").load(url, function() {
                        $("#show_result").animate({
                            opacity: 1
                        }, 200);
                    });
                });
                $("#show_status_page").animate({
                    opacity: 0
                }, 100, function() {
                    $("#show_status_page").load(searchpage, function() {
                        $("#show_status_page").animate({
                            opacity: 1
                        }, 200);
                    });
                });
            }
        }
    });

    $(".page_status li a").live("click", function() {
        event.preventDefault();
        url = $(this).attr("href") + "&dormbookID=" + $("#select_dorm").val() + "&search_by_status=" + $("#search_status").val();
        cur_page = "callback.php?search_by_status=" + $("#search_status").val() + "&search_status_page=" + $(this).attr("value") + "&dormID=" + $("#select_dorm").val();
        current_url = url;
        $("#show_status_page").load(cur_page);
        $("#show_result").animate({
            opacity: 0
        }, 100, function() {
            $("#show_result").load(url, function() {
                $("#show_result").animate({
                    opacity: 1
                }, 200);
            });
        });
    });
    
    $("#approvebutton").on("click", function() {
        if (confirm("Confirm to Change Status ?")) {
            change_url = "callback.php?change_booking_status=Approve&change_booking_id=" + $(this).val();
            $("#ajaxscript").load(change_url);
            document.getElementById("status").setAttribute("style","color:#00cc33");
            $(".modal-body-booking #status").html("Approve");
            $("#show_result").load(current_url);
        }
        return false;
    });
    $("#rejectbutton").on("click", function() {
        if (confirm("Confirm to Change Status ?")) {
            change_url = "callback.php?change_booking_status=Reject&change_booking_id=" + $(this).val();
            $("#ajaxscript").load(change_url);
            document.getElementById("status").setAttribute("style","color:red");
            $(".modal-body-booking #status").html("Reject");
            $("#show_result").load(current_url);
        }
        return false;
    });
    $("#canceledbutton").on("click", function() {
        if (confirm("Confirm to Change Status ?")) {
            change_url = "callback.php?change_booking_status=Canceled&change_booking_id=" + $(this).val();
            $("#ajaxscript").load(change_url);
            document.getElementById("status").setAttribute("style","color:red");
            $(".modal-body-booking #status").html("Canceled");
            $("#show_result").load(current_url);
        }
        return false;
    });
    
    $("#close_modal").on("click",function(){
       $("#show_result").load(current_url);        
    });
    
    $("#refresh_result").on("click",function(){
        
       $("#show_result").animate({
            opacity: 0
        }, 100, function() {
            $("#show_result").load(current_url, function() {
                $("#show_result").animate({
                    opacity: 1
                }, 200);
            });
        });   
       return false;
    });
    


});
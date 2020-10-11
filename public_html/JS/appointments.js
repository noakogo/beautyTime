  // fill the month table with column headings
function day_title(day_name) {
    document.write("<div class='c-cal__col'>" + day_name + "</div>");
  }
  // fills the month table with numbers
function fill_table(month, month_length, indexMonth, intIndexMonth) {
    let todayDate = new Date();
    let todayDay = todayDate.getDate();
    let todayMonth = todayDate.getMonth() + 1;
    let date = new Date(2020, intIndexMonth - 1, 1);
    let start_day = date.getDay() + 1;
    day = 1;
    // begin the new month table
    document.write("<div class='c-main c-main-" + indexMonth + "'>");
    //document.write("<b>"+month+" "+year+"</b>")

    // column headings
    document.write("<div class='c-cal__row'>");
    day_title("Sun");
    day_title("Mon");
    day_title("Tue");
    day_title("Wed");
    day_title("Thu");
    day_title("Fri");
    day_title("Sat");
    document.write("</div>");

    // pad cells before first day of month
    document.write("<div class='c-cal__row'>");
    for (var i = 1; i < start_day; i++) {
      if (start_day > 7) {
      } else {
        document.write("<div class='c-cal__cel'></div>");
      }
    }

    // fill the first week of days
    for (var i = start_day; i < 8; i++) {
        if (intIndexMonth < todayMonth || (day < todayDay && intIndexMonth === todayMonth)) {
          document.write("<div data-day='2020-" + indexMonth + "-0" + day + "' id='" + indexMonth + "/" + day + "/2020' class='blocked-cal-cel'><p>" + day + "</p></div>");

        } else {
          document.write("<div data-day='2020-" + indexMonth + "-0" + day + "' id='" + indexMonth + "/" + day + "/2020' class='c-cal__cel'><p>" + day + "</p></div>");
        }
        
        day++;
    }
    document.write("</div>");

    // fill the remaining weeks
    while (day <= month_length) {
      document.write("<div class='c-cal__row'>");
      for (var i = 1; i <= 7 && day <= month_length; i++) {
          //intIndexMonth < todayMonth day
        if(intIndexMonth < todayMonth) {
          document.write("<div data-day='2020-" + indexMonth + "-0" + day + "' id='" + indexMonth + "/" + day + "/2020' class='blocked-cal-cel'><p>" + day + "</p></div>");
          day++;
        } else if ((day < todayDay && intIndexMonth <= todayMonth)) {
          document.write("<div data-day='2020-" + indexMonth + "-0" + day + "' id='" + indexMonth + "/" + day + "/2020' class='blocked-cal-cel'><p>" + day + "</p></div>");
          day++;
        } else {
            if (day >= 10) {
              document.write("<div data-day='2020-" + indexMonth + "-" + day + "' id='" + indexMonth + "/" + day + "/2020' class='c-cal__cel'><p>" + day + "</p></div>");
            } else {
              document.write("<div data-day='2020-" + indexMonth + "-0" + day + "' id='" + indexMonth + "/" + day + "/2020' class='c-cal__cel'><p>" + day + "</p></div>");
            }
          day++;
        }
      }
      document.write("</div>");
      // the first day of the next month
      start_day = i;
    }

    document.write("</div>");
  }


$(document).ready(function(){
    disableAppointmentTimes(new Date().toLocaleDateString());
    $("#down-page").load( "../index.html #down-page"); // initialize the footer of the page
    $("#top-page").load( "../index.html #top-page"); //initialize the top of the page

    $(".not-available").click(function(){
        alert("This page is un-available at the moment");
    });
    //global variables
    var monthEl = $(".c-main");
    var dataCel = $(".c-cal__cel");
    var dateObj = new Date();
    var month = dateObj.getUTCMonth() + 1;
    var day = dateObj.getUTCDate();
    var year = dateObj.getUTCFullYear();
    var monthText = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December"
    ];
    var indexMonth = month;
    var todayBtn = $(".c-today__btn");
    var addBtn = $(".js-event__add");
    var saveBtn = $(".js-event__save");
    var closeBtn = $(".js-event__close");
    var winCreator = $(".js-event__creator");
    var inputDate = $(this).data();
    today = year + "-" + month + "-" + day;
    
    
    //window event creator
    addBtn.on("click", function() {
      winCreator.addClass("isVisible");
      $("body").addClass("overlay");
      dataCel.each(function() {
        if ($(this).hasClass("isSelected")) {
          today = $(this).data("day");
          document.querySelector('input[type="date"]').value = today;
        } else {
          document.querySelector('input[type="date"]').value = today;
        }
      });
    });
    closeBtn.on("click", function() {
      winCreator.removeClass("isVisible");
      $("body").removeClass("overlay");
    });
    saveBtn.on("click", function() {
      var inputName = $("input[name=name]").val();
      var inputDate = $("input[name=date]").val();
      var inputNotes = $("textarea[name=notes]").val();
      var inputTag = $("select[name=tags]")
        .find(":selected")
        .text();
    
      dataCel.each(function() {
        if ($(this).data("day") === inputDate) {
          if (inputName != null) {
            $(this).attr("data-name", inputName);
          }
          if (inputNotes != null) {
            $(this).attr("data-notes", inputNotes);
          }
          $(this).addClass("event");
          if (inputTag != null) {
            $(this).addClass("event--" + inputTag);
          }
          fillEventSidebar($(this));
        }
      });
    
      winCreator.removeClass("isVisible");
      $("body").removeClass("overlay");
      $("#addEvent")[0].reset();
    });
    
    //fill sidebar event info
    function fillEventSidebar(self) {
      $(".c-aside__event").remove();
      var thisName = self.attr("data-name");
      var thisNotes = self.attr("data-notes");
      var thisImportant = self.hasClass("event--important");
      var thisBirthday = self.hasClass("event--birthday");
      var thisFestivity = self.hasClass("event--festivity");
      var thisEvent = self.hasClass("event");
      
      switch (true) {
        case thisImportant:
          $(".c-aside__eventList").append(
            "<p class='c-aside__event c-aside__event--important'>" +
            thisName +
            " <span> • " +
            thisNotes +
            "</span></p>"
          );
          break;
        case thisBirthday:
          $(".c-aside__eventList").append(
            "<p class='c-aside__event c-aside__event--birthday'>" +
            thisName +
            " <span> • " +
            thisNotes +
            "</span></p>"
          );
          break;
        case thisFestivity:
          $(".c-aside__eventList").append(
            "<p class='c-aside__event c-aside__event--festivity'>" +
            thisName +
            " <span> • " +
            thisNotes +
            "</span></p>"
          );
          break;
        case thisEvent:
          $(".c-aside__eventList").append(
            "<p class='c-aside__event'>" +
            thisName +
            " <span> • " +
            thisNotes +
            "</span></p>"
          );
          break;
       }
    };
    dataCel.on("click", function() {
        //console.log("hayushhhh");
        document.getElementById("schedule-btn").style.display = "block";
        var thisEl = $(this);
        var thisDay = $(this)
        .attr("data-day")
        .slice(8);
        var thisMonth = $(this)
        .attr("data-day")
        .slice(5, 7);
        
        var fullDate = thisEl[0].dataset.day;
        disableAppointmentTimes(fullDate);
        fillEventSidebar($(this));
        
        $(".c-aside__num").text(thisDay);
        $(".c-aside__month").text(monthText[thisMonth - 1]);
        // $('input.a_date').val(fullDate);
        
        dataCel.removeClass("isSelected");
        thisEl.addClass("isSelected");
    });
    
    //function for move the months
    function moveNext(fakeClick, indexNext) {
      for (var i = 0; i < fakeClick; i++) {
        $(".c-main").css({
          left: "-=100%"
        });
        $(".c-paginator__month").css({
          left: "-=100%"
        });
        switch (true) {
          case indexNext:
            indexMonth += 1;
            break;
        }
      }
    }
    function movePrev(fakeClick, indexPrev) {
      for (var i = 0; i < fakeClick; i++) {
        $(".c-main").css({
          left: "+=100%"
        });
        $(".c-paginator__month").css({
          left: "+=100%"
        });
        switch (true) {
          case indexPrev:
            indexMonth -= 1;
            break;
        }
      }
    }
    
    //months paginator
    function buttonsPaginator(buttonId, mainClass, monthClass, next, prev) {
      switch (true) {
        case next:
          $(buttonId).on("click", function() {
            if (indexMonth >= 2) {
              $(mainClass).css({
                left: "+=100%"
              });
              $(monthClass).css({
                left: "+=100%"
              });
              indexMonth -= 1;
            }
            return indexMonth;
          });
          break;
        case prev:
          $(buttonId).on("click", function() {
            if (indexMonth <= 11) {
              $(mainClass).css({
                left: "-=100%"
              });
              $(monthClass).css({
                left: "-=100%"
              });
              indexMonth += 1;
            }
            return indexMonth;
          });
          break;
      }
    }
    
    buttonsPaginator("#next", monthEl, ".c-paginator__month", false, true);
    buttonsPaginator("#prev", monthEl, ".c-paginator__month", true, false);
    
    //launch function to set the current month
    moveNext(indexMonth - 1, false);
    
    //fill the sidebar with current day
    $(".c-aside__num").text(day);
    $(".c-aside__month").text(monthText[month - 1]);
    
    function disableAppointmentTimes(selectedDate) {
        $('#a_hour').val("");

        let appointmentData = JSON.parse(sessionStorage.getItem("allAppointments"));
        if (appointmentData) {
            for (let i = 0; i < appointmentData.length; i++) {
                let optionElement = document.getElementById(appointmentData[i]["a_hour"]);
                if (optionElement) {
                    if (appointmentData[i]["a_date"] === selectedDate) {
                        optionElement.disabled = true;
                    } else {
                        optionElement.disabled = false;
                    }
                }
            }
        }
        
        let selectedDateObj = new Date(selectedDate);
        let currentTime = new Date();
        if (selectedDateObj.getDate() === currentTime.getDate() && selectedDateObj.getMonth() === currentTime.getMonth()) {
            //if today was choosed, disable unrelevant times:
            let timeElements = [
                { time: 9, element: document.getElementById('09:00:00') },
                { time: 10, element: document.getElementById('10:00:00') },
                { time: 11, element: document.getElementById('11:00:00') },
                { time: 12, element: document.getElementById('12:00:00') },
                { time: 13, element: document.getElementById('13:00:00') },
                { time: 14, element: document.getElementById('14:00:00') },
                { time: 15, element: document.getElementById('15:00:00') },
                { time: 16, element:  document.getElementById('16:00:00') },
                { time: 17, element: document.getElementById('17:00:00') },
                { time: 18, element: document.getElementById('18:00:00') }
            ];
            
            let disabledTimeCounter = 0;
            let curretHour = currentTime.getHours();
            for (let i = 0; i < timeElements.length; i++) {
                if (curretHour >= timeElements[i].time) {
                    timeElements[i].element.disabled = true;
                    disabledTimeCounter++;
                } else {
                    timeElements[i].element.disabled = false;
                }
            }
            
            if (disabledTimeCounter === 10) {
                document.getElementById(selectedDate).classList.add("blocked-cal-cel");
                document.getElementById(selectedDate).classList.remove("c-cal__cel");
                document.getElementById(selectedDate).classList.remove("isSelected");
            }
        }
    }
});

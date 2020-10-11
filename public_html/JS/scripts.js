    $(document).ready(function(){
        $(".not-available").click(function(){
            alert("This page is un-available at the moment");
        });
        
        $('#PayForm').on('submit', function(e){
            e.preventDefault();
            var validated = validateform();
            if(validated){
                $('#myModal').modal('show');
            }
            else{
                alert("Your coupon is not valid");
            }
        });
    });
    
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";  
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
    }
    
function validateform(){
    var cardRgx = new RegExp("^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$");
    var cvvRgx = new RegExp("^[0-9]{3}$");
    var cardVal= ($("#cardnum")).val();
    var cvvVal= ($("#cvv")).val();
    var exVal = ($("#ex")).val();
    var couponVal = ($("#coupon")).val();
    var isValid = true;

    if(!(cardRgx.test(cardVal))){
        isValid = false;
    }
    if(!(cvvRgx.test(cvvVal))){
        isValid = false;
    }
    if(exVal == null){
        isValid = false;
    }
    if(couponVal.length !== 0){
        console.log("im validating coupon");

        var validc = validatec(couponVal);
        console.log("validc is: "+validc);

        if (validc == false){
            isValid = false;
        }
    } 
    return isValid;
}

  function validatec(coupon){
    var couponArr=["couplestime","ilovefootmessage","nomorehair","ilovemanipedi","ilovetobetan","iambeautiful"];
     
    for(var i = 0; i < couponArr.length; i++){
        var res = coupon.localeCompare(couponArr[i]);
        console.log("the result of coupon is: " + res)
        if(res == 1){
            res = true;
            break;
        }
        res = false;
    }
     return res;
  }
    
    function callFunctions(){

        if(checkBirthDate()){
            saveData();
            return true;
        }
        event.preventDefault();
    }  
    
    function checkBirthDate(){
        var today = new Date();
        var birthDate=document.getElementById('BDate').value
        console.log("birthdate");
        if (today.getTime() < birthDate.getTime()){
            alert("please enter valid birth date");
            return false;
        }
        return true;
    }
   
    
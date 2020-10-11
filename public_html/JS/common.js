$(document).ready(function() {
    $("#common").load("/includes/common.html");
});

function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
      if (sessionStorage.getItem("isLoggedIn") !== 'true') {
        document.getElementById('profile-btn').style.display = 'none';
        document.getElementById('appointments-btn').style.display = 'none';
    }
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

 var vsid = "sa58193";
 (function() { 
 var vsjs = document.createElement('script'); vsjs.type = 'text/javascript'; vsjs.async = true; vsjs.setAttribute('defer', 'defer');
  vsjs.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'www.virtualspirits.com/vsa/chat-'+vsid+'.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(vsjs, s);
 })();

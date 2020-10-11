<?php
    session_start();
    setcookie("ID", "", time()-3600);
    session_destroy();
    echo '
        <script>sessionStorage.setItem("isLoggedIn", null);
            sessionStorage.setItem("first_name", null);
            window.location = "/";
        </script>';
?>
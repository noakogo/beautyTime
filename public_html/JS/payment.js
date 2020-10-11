$(function() {
    $('#payment-btn').on('click', function(event) {
        if (sessionStorage.getItem('isLoggedIn') === 'true') {
            let itmesInCart = { itmesInCart: JSON.parse(localStorage.getItem('cart'))} ;
            
            $.ajax({
                type: 'POST',
                url: '/includes/payment.php',
                data: itmesInCart,
                async:false,       
                success: function(data)          
                 {   
                     alert("succsess");
                     localStorage.setItem('cart', []);
                      window.location.href = '/includes/products.html';
                 },
    
                error: function (xhr, textStatus, errorThrown) {
                    alert(`Error: ${errorThrown}`);
                }
            });
        } else {
             alert("Please sign in before payment");
             window.location.href = '/includes/sign-in.php';
        }
    }); 
});

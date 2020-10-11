var selection = null;

$( document ).ready(function() {
        switchNavigation('my-profile');
});

function switchNavigation(newSelection) {
    if (newSelection !== selection) {
        selection = newSelection;
        let myProfile = document.getElementById("my-profile");
        let myAppointments = document.getElementById("my-appointments");
        let myPayments = document.getElementById("my-payments");
        let updateProfileContent = document.getElementById("update-profile-content");
        let appointmentsContent = document.getElementById("appointments-content");
        let paymentsContent = document.getElementById("payments-content");

        switch (selection) {
            case 'my-profile':
                myProfile.classList.add("navigation-selected-btn");
                myAppointments.classList.remove("navigation-selected-btn");
                myPayments.classList.remove("navigation-selected-btn");
                updateProfileContent.classList.add("show-div");
                updateProfileContent.classList.remove("hide-display");
                appointmentsContent.classList.remove("show-div");
                appointmentsContent.classList.add("hide-display");
                paymentsContent.classList.remove("show-div");
                paymentsContent.classList.add("hide-display");

                break;
            case 'my-appointments':
                myAppointments.classList.add("navigation-selected-btn");
                myProfile.classList.remove("navigation-selected-btn");
                myPayments.classList.remove("navigation-selected-btn");
                updateProfileContent.classList.remove("show-div");
                updateProfileContent.classList.add("hide-display");
                appointmentsContent.classList.add("show-div");
                appointmentsContent.classList.remove("hide-display");
                paymentsContent.classList.remove("show-div");
                paymentsContent.classList.add("hide-display");
                
                break;
            case 'my-payments':
                paymentsContent.classList.add("show-div");
                paymentsContent.classList.remove("hide-display");
                myProfile.classList.remove("navigation-selected-btn");
                myAppointments.classList.remove("navigation-selected-btn");
                myPayments.classList.add("navigation-selected-btn");
                updateProfileContent.classList.remove("show-div");
                updateProfileContent.classList.add("hide-display");
                appointmentsContent.classList.remove("show-div");
                appointmentsContent.classList.add("hide-display");
                
                break;
        }
    }
}
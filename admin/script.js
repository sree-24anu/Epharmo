document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.querySelectorAll(".sidebar-link");
    dropdown.forEach(dropdown => {

    dropdown.addEventListener('click', function () {        
        dropdown.classList.toggle('rotate');
    });
    });


    // strengthBar

        let passwordInput = document.getElementById("password");
        let strengthText = document.getElementById("password-strength");
        let strengthBar = document.getElementById("password-strength-bar");
        let button = document.getElementById("upd_btn");
        let alert_error = document.getElementById("not_strong");

        passwordInput.addEventListener("input", function () {
            let password = passwordInput.value;
            let strength = 0;

            // Check length
            if (password.length >= 6) {
                strength += 30;
            }

            // Check IF IT CONTAINS CAPITAL LETTER
            if (/[A-Z]/.test(password)) {
                strength += 30;
            }

            // Check if contains numbers
            if (/\d/.test(password)) {
                strength += 40;
            }

            
            if (strength <= 40) {
                strengthText.textContent = "Weak";
                strengthText.style.color = "#ff0000"; 
            } else if (strength <= 80) {
                strengthText.textContent = "Medium";
                strengthText.style.color = "#ffa500";
            } else {
                strengthText.textContent = "Strong";
                strengthText.style.color = "#008000"; 
            }

            // strength does not exceed maximum value
            strength = Math.min(strength, 100);

            strengthBar.value = strength;

            strengthBar.style.display = "block";

           if(strengthText.textContent == "Weak")
           {
            button.disabled = true;
            button.style.backgroundColor = "grey";
            alert_error.textContent="Enter stronger password!!";
           }
           else
           {
            button.disabled = false;
            button.style.backgroundColor = "";
            alert_error.textContent="";
           }
    
        });
});




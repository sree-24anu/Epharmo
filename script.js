document.addEventListener('DOMContentLoaded', function () {

document.getElementById("add_address_form").addEventListener("submit", function(event) 
{

let name = document.getElementById("address_name").value;
let phoneno = document.getElementById("address_phoneno").value;
let content = document.getElementById("address").value;
let view_alert = document.getElementById("address_empty");

    if(name.trim()=='' || phoneno.trim()=='' || content.trim()=='')
    {
        event.preventDefault();
        view_alert.innerText = "Please fill all the fields!!";
    }
    else
    {
        let phonePattern = /^[6-9][0-9]{9}$/;

        if(phonePattern.test(phoneno))
        {
            document.getElementById("add_address_form").submit();
            view_alert.innerText = "";
        }
        else
        {
            event.preventDefault();
            view_alert.innerText = "Invalid phone number";
        }
        
    }
});

document.getElementById("edit_address_form").addEventListener("submit", function(event) 
{

let name = document.getElementById("edit_name").value;
let phoneno = document.getElementById("edit_phoneno").value;
let content = document.getElementById("edit_address").value;
let view_alert = document.getElementById("edit_address_empty");

    if(name.trim()=='' || phoneno.trim()=='' || content.trim()=='')
    {
        event.preventDefault();
        edit_address_empty.innerText = "Please fill all the fields!!";
    }
    else
    {
        let phonePattern = /^[6-9][0-9]{9}$/;

        if(phonePattern.test(phoneno))
        {
            document.getElementById("edit_address_form").submit();
            edit_address_empty.innerText = "";
        }
        else
        {
            event.preventDefault();
            edit_address_empty.innerText = "Invalid phone number";
        }
        
    }
});



});
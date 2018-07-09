//index page specific javascript
function index(){

    //client side form validation for email subscription
    const form = document.forms[0]; //get subscription form

    //checks user inputted information in subscription form
    function checkData(e){
        const email_input = document.querySelector('#email'); //get email input box
        const htmlContainer = document.querySelector('.validation-wrapper'); //DOM location for error message
        const regexp = new RegExp(/^[\S]+@[\S]+\.[\S]{2,6}$/i); //email reg exp
        let html; //html to display to user if failed client-side validation

        if(!email_input.value.match(regexp)){ //prevent form firing if email does not match the regular expression
            e.preventDefault();
            html = "Please enter a valid email address";
        }
        htmlContainer.textContent = html;
    }
    

    form.addEventListener('submit', checkData); //run checkData function when form submitted
    
} //end of index page
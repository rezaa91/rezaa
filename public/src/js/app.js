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




//post specific pages specific javascript
function posts(){

    //Search bar ////////////////////////////////////////
    if(document.querySelector('#search')){

        const form = document.forms[0]; //get search bar form

        //prevent form firing if no data inserted into search box
        function checkData(e){
            const input = document.querySelector('#search');
            if(!input.value){
                e.preventDefault();
            }
        }

        form.addEventListener('submit', checkData);

    }
    
    //////////////////////////////////////////////////////



    //Select all/checkboxes //////////////////////////////////////////
    if(document.querySelector('input[name="selectall"]')){

        const select_all = document.querySelector('input[name="selectall"]'); //select all box
        const checkboxes = document.querySelectorAll('input[name="check[]"]'); //checkboxes for individual blogs - node list


        //if select all box ticked, check all other checkboxes and vice versa
        function selectAll(){
            checkboxes.forEach(checkbox => {
                this.checked ? checkbox.checked = true : checkbox.checked = false;
            })
        }

        //remove select all tick if another check box has been unchecked
        function deselectAll(){
            if(!this.checked) select_all.checked = false;
        }


        select_all.addEventListener('click', selectAll);
        checkboxes.forEach(checkbox => checkbox.addEventListener('click', deselectAll));

    }
    ///////////////////////////////////////////////////////


    //confirm delete blogs ////////////////////////////////
    if(document.querySelector('input[name="delete"]')){
        const delete_form = document.querySelector('form[name="delete_form"]');
        
        function confirm_deletion(e){
            const checkboxes = document.querySelectorAll('input[name="check[]"]'); //checkboxes for individual blogs - node list
            let n = 0; //numbers of selected checkboxes
            checkboxes.forEach(checkbox => {
                if(checkbox.checked) n++;
            })

            if(n === 0){
                e.preventDefault();
                return;
            }

            let confirm_delete = confirm(`You are about to delete ${n} posts. Are you sure you want to proceed?`);
            if(!confirm_delete){
                e.preventDefault();
                return;
            }
        }

        delete_form.addEventListener('submit', confirm_deletion);

    }
    ///////////////////////////////////////////////////////


}//end of post pages




//individual post pages
function individual_post(){

    const delete_form = document.querySelector('form');

    //get user to confirm before deleting post
    function confirm_deletion(e){
        let confirm_delete = confirm('Are you sure you wish to delete this post?');
        if(!confirm_delete){
            e.preventDefault();
            return;
        }
    }

    delete_form.addEventListener('submit', confirm_deletion);

}//end of individual post pages




//navigation page
function navigation(){

    if(document.querySelector('.logout')){
        const logout_btn = document.querySelector('.logout');

        //get user to confirm they wish to logout before doing so
        function confirm_logout(e){
            let confirm_btn = confirm('Are you sure you want to logout?');
            if(!confirm_btn){
                e.preventDefault();
                return;
            }
        }

        logout_btn.addEventListener('click', confirm_logout);
    }

}//end of navigation page


    // Здесь не важно, как мы скрываем текст.
    // Также можно использовать style.display:
     //window.onload = function () {
     function showBasic() {
       let basic =document.getElementsByClassName('basic');
       let required =document.getElementsByClassName('required');
       let optionally =document.getElementsByClassName('optionally');
       let electives =document.getElementsByClassName('electives');
       for (var i = 0; i < basic.length; i++)
          basic[i].style.display = "block";

       for (var i = 0; i < required.length; i++)
             required[i].style.display = "none";

       for (var i = 0; i < optionally.length; i++)
                optionally[i].style.display = "none";

       for (var i = 0; i < electives.length; i++)
                   electives[i].style.display = "none";
                 }

      function showReq() {
                 console.log("CLICK");
                let basic =document.getElementsByClassName('basic');
                  let required =document.getElementsByClassName('required');
                  let optionally =document.getElementsByClassName('optionally');
                  let electives =document.getElementsByClassName('electives');

                  for (var i = 0; i < basic.length; i++)
                     basic[i].style.display = "none";

                  for (var i = 0; i < required.length; i++)
                        required[i].style.display = "block";

                  for (var i = 0; i < optionally.length; i++)
                           optionally[i].style.display = "none";

                  for (var i = 0; i < electives.length; i++)
                              electives[i].style.display = "none";
                        }
        function showOpt() {
            console.log("CLICK");
            let basic =document.getElementsByClassName('basic');
            let required =document.getElementsByClassName('required');
            let optionally =document.getElementsByClassName('optionally');
            let electives =document.getElementsByClassName('electives');

            for (var i = 0; i < basic.length; i++)
             basic[i].style.display = "none";

            for (var i = 0; i < required.length; i++)
              required[i].style.display = "none";

            for (var i = 0; i < optionally.length; i++)
              optionally[i].style.display = "block";

            for (var i = 0; i < electives.length; i++)
                electives[i].style.display = "none";
                    };


        function showEl() {
          console.log("CLICK");
            let basic =document.getElementsByClassName('basic');
          let required =document.getElementsByClassName('required');
              let optionally =document.getElementsByClassName('optionally');
            let electives =document.getElementsByClassName('electives');

          for (var i = 0; i < basic.length; i++)
               basic[i].style.display = 'none';

              for (var i = 0; i < required.length; i++)
                required[i].style.display = 'none';

            for (var i = 0; i < optionally.length; i++)
                     optionally[i].style.display = 'none';

          for (var i = 0; i < electives.length; i++)
                      electives[i].style.display = 'block';
                    };

     function ready() {
       let base_js = document.getElementsByClassName('base_js');
       let required_js = document.getElementsByClassName('required_js');
       let optionally_js = document.getElementsByClassName('optionally_js');
       let electives_js = document.getElementsByClassName('electives_js');
       if (base_js != null)
       {
         base_js[0].addEventListener('click',showBasic);
       };
       if (required_js != null)
       {
          required_js[0].addEventListener('click',showReq);
       }

       if (optionally_js != null)
       {
         optionally_js[0].addEventListener('click',showOpt);
       }

       if (electives_js != null)
       {
         electives_js[0].addEventListener('click',showEl);
       }
     }
document.addEventListener("DOMContentLoaded", ready);

//}

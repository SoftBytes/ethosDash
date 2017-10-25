<script type="text/javascript">

  const spinner = document.querySelector("#spinner");
  const submit = document.querySelector("#submit");
  const formGroup = document.querySelector("#formGroup");
  const idInput = document.querySelector("#id");


  $("#id").on("paste keyup", function() {

    // spinner.style.display = "block";

    let idValue = idInput.value;
    let idLength = idValue.length;


    if (idLength === 6) {

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState != 4) {
                spinner.style.visibility = "visible";
              if (formGroup.classList.contains("has-danger")){
                 formGroup.classList.remove("has-danger");
              }
              if (formGroup.classList.contains("has-success")){
                 formGroup.classList.remove("has-success");
              }
              if (idInput.classList.contains("form-control-success")) {
                idInput.classList.remove("form-control-success");
              }
              if (idInput.classList.contains("form-control-danger")) {
                idInput.classList.remove("form-control-danger");
              }

          }
          if (this.readyState == 4 && this.status == 200) {

            spinner.style.visibility = "hidden";

           // document.querySelector("#div1").innerHTML = this.response;

            if (this.response !== "Error") {

                if (formGroup.classList.contains("has-danger")){
                   formGroup.classList.remove("has-danger");
                }
                formGroup.classList.add("has-success");
                idInput.classList.add("form-control-success");
                submit.disabled = false;
              } else if (formGroup.classList.contains("has-success")){
                submit.disabled = true;
                formGroup.classList.remove("has-success");
                formGroup.classList.add("has-danger");
              } else if (idInput.classList.contains("form-control-success")){
                submit.disabled = true;
                idInput.classList.remove("form-control-success");
                idInput.classList.add("form-control-danger");
              } else {
                submit.disabled = true;
                formGroup.classList.add("has-danger");
                idInput.classList.add("form-control-danger");
              }
          }
      };
      xhttp.open("GET", "./inc/curl.php?id="+ idValue, true);
      xhttp.send();

  } else {
      if (formGroup.classList.contains("has-success")){
          submit.disabled = true;
          formGroup.classList.remove("has-success");
      } if (formGroup.classList.contains("has-danger")){
          submit.disabled = true;
          formGroup.classList.remove("has-danger");
      }   if (idInput.classList.contains("form-control-success")){
          submit.disabled = true;
          idInput.classList.remove("form-control-success");
      }  if (idInput.classList.contains("form-control-danger")){
          submit.disabled = true;
          idInput.classList.remove("form-control-danger");
      }
  }

  });

  $(function(){
    $('a, button').click(function() {
        $(this).toggleClass('active');
    });
  });
</script>
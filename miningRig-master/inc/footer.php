
    <!-- end bootstrap container -->
    <!-- bootstrap js files start -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <!-- bootstrap js files end -->

    <script type="text/javascript">

      $("#id").on("change paste keyup blur", function() {

      		var spinner = document.querySelector("#spinner");
          var submit = document.querySelector("#submit");
          var formGroup = document.querySelector("#formGroup");
          var idInput = document.querySelector("#id");
          var idValue = idInput.value;
          var idLength = idValue.length;
          if (idLength === 6) {

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
	            	if (this.readyState != 4) {
	            				spinner.style.display = "block";
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

                	spinner.style.display = "none";

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
            xhttp.open("GET", "./curl.php?id="+ idValue, true);
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


</body>
</html>
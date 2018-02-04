<?php


?>
   <div class="navbar bg-inverse navbar-inverse">
       <div class="container">

       <a href="welcome.php?lang=<?php echo $lang ?>" ><?php echo $topnavcontent["menu1"] ?></a>
        <a href="#rigslist"><?php echo $topnavcontent["menu2"] ?></a>
        <a href="aboutus.php?lang=<?php echo $lang ?>"><?php echo $topnavcontent["menu3"] ?></a>

        <?php
		/*

        if ($_SERVER['REQUEST_URI'] != "/rigSettings/login.php") {
            echo "<a href='logout.php' class='nav-item nav-link'>Logout</a>";
          }
		 */
        ?>
	   </div>
    </div>

 <script type="text/javascript">
  $("#id").on("paste keyup", function() {
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



  setInterval(function(){
     console.log("ajax started");
     $("#coinRates").load("model/coinRates.php");
     // $("#rigsStatusContainer").load("classes/rigsStatusLoad.php");
     console.log("ajax ended");
   }, 6000);

</script>



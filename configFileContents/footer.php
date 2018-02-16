    <!-- end bootstrap container -->
    <!-- bootstrap js files start -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <!-- bootstrap js files end -->

    <script type="text/javascript">

    // $(".activeCheckbox").click(function(){
    //   alert(this.id)
    // });

    // $('.activeCheckbox:checkbox').change(function() {
    //     if (this.checked) {

    //     }
    // });


    // tooltip descriptions for config maker
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // auto refresh ajax for dynamic json elements
    setInterval(function(){
        $("#rigsTableContainer").load("classes/rigsTableLoad.php");
        $("#rigsStatusContainer").load("classes/rigsStatusLoad.php");
    }, 600000);


    // config settings range slider text update
    $(document).on('change', 'input[type=range]', function() {
        $("p#" + this.name).html(this.value);
    });

    // log in load json and validate user id
    $("#id").on("paste keyup", function() {

    		var spinner     = document.querySelector("#spinner");
        var submit      = document.querySelector("#submit");
        var formGroup   = document.querySelector("#formGroup");
        var idInput     = document.querySelector("#id");
        var idValue     = idInput.value;
        var idLength    = idValue.length;
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

    // on click globals button activate global modal and run globals class
    function globals(){
        $( "#modal" ).load( "globals.php", function() {
        });
    }

    // on click miners settings button activate miner modal and run miner class for miner id of button
    function miners(minerID){
        $( "#result-modal-miner" ).load( "miners.php?minerID=" + minerID, function() {
        });
    }

    // onclick save miners save global settings input values to config.txt file and download
    $("#saveGlobals").click(function(){

        var configObj = {};

        $('#result-modal > table > tbody > tr > td').children().each(function() {

           $(this).children().each(function() {

             if (($(this).is("input")) || ($(this).is("select"))) {

              // if ($(this).hasClass(".activeCheckbox")) {
              //   if ($(this).is(":checked")) {
              //     configObj[this.id]['visible'] = true;
              //   } else {
              //     configObj[this.id]['visible'] = false;
              //   }
              // }

              if ($(this).is(":checkbox")) {
                if ($(this).is(":checked")) {
                  configObj[this.id] = true;
                } else {
                  configObj[this.id] = false;
                }
              } else {
                configObj[this.id] = this.value;
              }

             }

           });

        });

        // console.log(configObj);

        var string = JSON.stringify(configObj);

        $.ajax({url: "./classes/saveGlobals.class.php?string=" + string, success: function(result){
          var userID = result;
          downloadConfigFile("./configFiles/" + userID + "/config.txt", "config.txt");
        }});
    });

    // onclick save miners save miners settings input values to config.txt and download file
    $("#saveMiners").click(function(){

        var configObj = {};
        var cor = [];
        var mem = [];
        var fan = [];
        var pwr = [];
        var vlt = [];
        var sel = [];


        $('#miner-modal-body > table > tbody > tr > td').children().each(function() {

           $(this).children().each(function() {

            if ((this.id == "cor")    ||
                (this.id == "mem")    ||
                (this.id == "fan")    ||
                (this.id == "pwr")    ||
                (this.id == "vlt")    ||
                (this.id == "sel"))     {
              if (this.id ==  "cor") {
                cor.push(this.value)
              } else if (this.id ==  "mem"){
                mem.push(this.value)
              } else if (this.id ==  "fan"){
                fan.push(this.value)
              } else if (this.id ==  "pwr"){
                pwr.push(this.value)
              } else if (this.id ==  "vlt"){
                vlt.push(this.value)
              } else if (this.id ==  "sel"){
                sel.push(this.value)
              }
            }

            else if ($(this).is(":checkbox")) {
               if ($(this).is(":checked")) {
                 configObj[this.id] = true;
               } else {
                 configObj[this.id] = false;
               }
             } else {
               configObj[this.id] = this.value;
             }

           });

           configObj['cor'] = cor;
           configObj['mem'] = mem;
           configObj['fan'] = fan;
           configObj['pwr'] = pwr;
           configObj['vlt'] = vlt;
           configObj['sel'] = sel;

        });
        var json =  JSON.stringify(configObj);

        $.ajax({url: "./classes/saveMiners.class.php?minerID=" + this.name + "&json=" + json, success: function(result){
          var userID = result;
          downloadConfigFile("./configFiles/" + userID + "/config.txt", "config.txt");
        }});

    });

    // downloads the file after the ajax call is completed in save globals
    function downloadConfigFile(uri, name) {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        link.click();
     }
    </script>

</body>
</html>
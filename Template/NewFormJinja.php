<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$msg = '';
//Don't run this unless we're handling a form submission
if (isset($_POST['Submit'])) {
    date_default_timezone_set('Etc/UTC');

    require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer();
    //Send using SMTP to localhost (faster and safer than using mail()) – requires a local mail server
    //See other examples for how to use a remote server such as gmail
    $mail->isSMTP();
    $mail->Host = '{{ MailHost }}';
    $mail->Port = {{ MailPort }};
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	$mail->SMTPAuth = true;
	$mail->Username = '{{ MailUsername }}';
	$mail->Password = '{{ MailPassword }}';
	$mail->addReplyTo('{{ MailReplytoEmail }}', '{{ MailReplytoName }}');
	$mail->CharSet  = 'UTF-8';
	//Confirm message to submitter
	$mail->Subject = '{{ EventName }}';
    //Keep it simple - don't use HTML
    $mail->isHTML(false);
	$mail->Body = <<<EOT
Mange tak for din tilmelding til "{{ EventName }}", vi har modtaget til tilmelding og du hører fra os. Du har indtastet følgende informationer:
BilletType: {$_POST["BilletRadio"]}
{% for Field,req,stripped in FeltList %}
{{ Field }}: {$_POST['{{ stripped }}']}
{% endfor %}

Er der fejl eller spørgsmål til ovenstående så kontakt os venligst:
{{ ContactPerson }}
Telefon: {{ ContactPhone }}
Email: {{ ContactEmail }}
EOT;
	//$mail->addAddress('madsemil.mj@gmail.com');
    
	//Use a fixed address in your own domain as the from address
    //**DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks
    $mail->setFrom('{{ MailReplytoEmail }}', '{{ MailReplytoName }}');
    //Choose who the message should be sent to
    //You don't have to use a <select> like in this example, you can simply use a fixed address
    //the important thing is *not* to trust an email address submitted from the form directly,
    //as an attacker can substitute their own and try to use your form to send spam
	
	
	// MAIL INSTANCE FOR INTERN MAILING
	$mailintern = new PHPMailer();
	$mailintern->isSMTP();
    $mailintern->Host = '{{ MailHost }}';
    $mailintern->Port = {{ MailPort }};
	$mailintern->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	$mailintern->SMTPAuth = true;
	$mailintern->Username = '{{ MailUsername }}';
	$mailintern->Password = '{{ MailPassword }}';
	$mailintern->addReplyTo('{{ MailReplytoEmail }}', '{{ MailReplytoName }}');
	$mailintern->CharSet  = 'UTF-8';
	//To EMAIL
	$mailintern->addAddress('{{ InternMailTo }}');
    $mailintern->setFrom('{{ MailReplytoEmail }}', '{{ MailReplytoName }}');
	$mailintern->Subject = 'Tilmelding til: {{ EventName }}';
    $mailintern->isHTML(false);
	$mailintern->Body = <<<EOT
Ny Tilmelding til {{ EventName }} med følgende informationer:
BilletType: {$_POST["BilletRadio"]}
{% for Field,req,stripped in FeltList %}
{{ Field }}: {$_POST['{{ stripped }}']}
{% endfor %}
EOT;
	
	//Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
	// First Check
    if (isset($_POST['E-mail']) && $mail->addReplyTo($_POST['E-mail'])) {
        $mail->addAddress($_POST['E-mail']);
        
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }
    } 
	// Second check
	elseif (isset($_POST['E-Mail']) && $mail->addReplyTo($_POST['E-Mail'])) {
        $mail->addAddress($_POST['E-Mail']);
        
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// Third check
	elseif (isset($_POST['e-Mail']) && $mail->addReplyTo($_POST['e-Mail'])) {
		$mail->addAddress($_POST['e-Mail']);
        
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// Fourth check
	elseif (isset($_POST['e-mail']) && $mail->addReplyTo($_POST['e-mail'])) {
		$mail->addAddress($_POST['e-mail']);
        
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// Fifth check
	elseif (isset($_POST['Email']) && $mail->addReplyTo($_POST['Email'])) {
		$mail->addAddress($_POST['Email']);
        
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// sixth check
	elseif (isset($_POST['EMail']) && $mail->addReplyTo($_POST['EMail'])) {
		$mail->addAddress($_POST['EMail']);
    
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// seventh check
	elseif (isset($_POST['email']) && $mail->addReplyTo($_POST['email'])) {
		$mail->addAddress($_POST['email']);
    
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// eighth check
	elseif (isset($_POST['eMail']) && $mail->addReplyTo($_POST['eMail'])) {
		$mail->addAddress($_POST['eMail']);
    
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// Nineth check
	elseif (isset($_POST['E mail']) && $mail->addReplyTo($_POST['E mail'])) {
		$mail->addAddress($_POST['E mail']);
    
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// Tenth check
	elseif (isset($_POST['E Mail']) && $mail->addReplyTo($_POST['E Mail'])) {
		$mail->addAddress($_POST['E Mail']);
    
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// Elleventh check
	elseif (isset($_POST['e Mail']) && $mail->addReplyTo($_POST['e Mail'])) {
		$mail->addAddress($_POST['e Mail']);
    
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	}
	// Twelveth check
	elseif (isset($_POST['e mail']) && $mail->addReplyTo($_POST['e mail'])) {
		$mail->addAddress($_POST['e mail']);
    
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but it's unsafe to display errors directly to users - process the error, log it on your server.
            $msg = 'Beklager, noget gik galt, prøv igen senere.';
        } else {
            $msg = 'Beskeden blev sendt! En bekræftelsesmail er sendt afsted til din e-mail';
			// Send besked til DANSK HR HER
			$mailintern ->send();
        }	
	} else {
        $msg = 'Ikke gyldig e-mail adresse. Prøv igen.';
    }
}
?>

<!DOCTYPE html>
<html lang="da">
<head>
<!-- GoogleFont Icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

    <meta charset="UTF-8">
    <title>{{ EventName }}</title>	
<style type="text/css">
html{
    background-color: #f3f3f3;
	font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif !important;
}

.beskrivelse p {
	text-align: left;
	font-weight: normal;
	/* color: red; */
}

.beskrivelse ul {
	text-align: left;
	/* color: red; */
}

* {
  box-sizing: border-box;
}

.Praktiskcolumn {
  float: left;
  width: 33.33%;
  padding: 10px;
  height: 310px; /* Should be removed. Only for demonstration */
}

.Praktiskcolumn p {
  font-weight: normal;
}


/* Clear floats after the columns */
.PraktiskRow:after {
  content: "";
  display: table;
  clear: both;
}



/* Popup container */
.popup {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

/* The actual popup (appears on top) */
.popup .popuptext {
  visibility: hidden;
  width: 600px;
  background-color: #555;
  color: #fff;
  text-align: left;
  border-radius: 6px;
  padding: 8px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -80px;
  font-weight:normal;
  font-size: 16px;
}

/* Popup arrow */
.popup .popuptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

/* Toggle this class when clicking on the popup container (hide and show the popup) */
.popup .show {
  visibility: visible;
  -webkit-animation: fadeIn 1s;
  animation: fadeIn 1s
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity:1 ;}
}
.close{
   cursor:pointer;
text-align:right;
display:block;
padding:10px;
}

.SeBetingelser {
	color:#2484c6;
}
.SeBetingelser:hover {
	cursor:pointer;
	text-decoration:underline;
}



.form-basic{
    max-width: 640px;
    margin: 0 auto;
    padding: 55px;
    box-sizing: border-box;

    background-color:  #ffffff;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);

    font: bold 14px sans-serif;
    text-align: center;
}

.form-basic .form-row{
    text-align: left;
    margin-bottom: 22px;
}

.form-basic .form-title-row{
    text-align: center;
    margin-bottom: 55px;
}

/* The form title */

.form-basic h1{
    display: inline-block;
    box-sizing: border-box;
    color:  #2484c6;
    font-size: 24px;
    padding: 70px 10px 15px; /* top right/left bottom */
    border-bottom: 2px solid #6caee0;
    margin: 0;
}

.form-basic .form-row > label span{
    display: inline-block;
    box-sizing: border-box;
    color: #5F5F5F;
    width: 180px;
    text-align: left;
    vertical-align: top;
    padding: 12px 1px;
}

.form-basic input{
    color:  #5f5f5f;
    box-sizing: border-box;
    width: 335px;
    box-shadow: 1px 2px 4px 0 rgba(0, 0, 0, 0.08);
    padding: 12px;
    border: 1px solid #dbdbdb;
}

.form-basic input[type=radio],
.form-basic input[type=checkbox]{
    box-shadow: none;
    width: auto;
}

.form-basic input[type=checkbox]{
    margin-top: 13px;
}

.form-basic select{
    background-color: #ffffff;
    color:  #5f5f5f;
    box-sizing: border-box;
    max-width: 240px;
    box-shadow: 1px 2px 4px 0 rgba(0, 0, 0, 0.08);
    padding: 12px 8px;
    border: 1px solid #dbdbdb;
}

.form-basic textarea{
    color:  #5f5f5f;
    box-sizing: border-box;
    width: 335px;
    height: 80px;
    box-shadow: 1px 2px 4px 0 rgba(0, 0, 0, 0.08);
    font: normal 13px sans-serif;
    padding: 12px;
    border: 1px solid #dbdbdb;
    resize: vertical;
}

.form-basic .form-radio-buttons{
    display: inline-block;
    vertical-align: top;
}

.form-basic .form-radio-buttons > div{
    margin-top: 10px;
}

.form-basic .form-radio-buttons label span{
    margin-left: 8px;
    color: #5f5f5f;
    font-weight: normal;
}

.form-basic .form-radio-buttons input{
    width: auto;
}

.form-basic button{
    display: block;
    border-radius: 2px;
    background-color:  #2484c6;
    color: #ffffff;
    font-weight: bold;
    box-shadow: 1px 2px 4px 0 rgba(0, 0, 0, 0.08);
    padding: 14px 22px;
    border: 0;
    margin: 40px 183px 0;
}

/*	Making the form responsive. Remove this media query
    if you don't need the form to work on mobile devices. */

@media (max-width: 600px) {

    .form-basic{
        padding: 30px;
        max-width: 480px;
    }

    .form-basic .form-row{
        max-width: 300px;
        margin: 25px auto;
        text-align: left;
    }

    .form-basic .form-title-row{
        margin-bottom: 50px;
    }

    .form-basic .form-row > label span{
        display: block;
        text-align: left;
        padding: 0 0 15px;
    }

    .form-basic select{
        width: 240px;
    }

    .form-basic input[type=checkbox]{
        margin-top:0;
    }

    .form-basic .form-radio-buttons > div{
        margin: 0 0 10px;
    }

    .form-basic button{
        margin: 0;
    }

}


</style>

</head>
<body>
<?php if (!empty($msg)) {
    echo "<h2>$msg</h2>";
} ?>
<div class="main-content">

        <!-- You only need this form and the form-basic.css -->

        <form class="form-basic" name="myForm" onsubmit = "return validateForm()" method="post">
			<img src="logo_hr.png" alt="DanskHR">
            <div class="form-title-row">
                <h1>{{ EventName }}</h1>
            </div>
			
			<div class="beskrivelse">
			<h2>Beskrivelse</h2>
				<p> {{ EventDescription }} </p>
				</div>
				<br>
			<div class="PraktiskRow">
			<h2>Praktiske Oplysninger</h2><br>
			  <div class="Praktiskcolumn" style="border-right: 1px solid black;">
				<span class="material-symbols-outlined" style="font-size:50px;">calendar_month</span>
				<h3> Hvornår?</h3>
				<p> <strong>Fra:</strong> {{ FromDate }} Kl. {{ FromTime }}</p> 
				<p> <strong>Til:</strong> {{ ToDate }} Kl. {{ ToTime }}</p> 
				<p> <strong>Tilmedlingsfrist:</strong> {{ DueDate }}</p>
			  </div>
			  <div class="Praktiskcolumn" style="border-right: 1px solid black;">
				<span class="material-symbols-outlined" style="font-size:50px;">map</span>
				<h3> Hvor?</h3>
				<p> {{ Address }}</p>
			  </div>
			  <div class="Praktiskcolumn" style="border: 1px solid white;">
				<span class="material-symbols-outlined" style="font-size:50px;">contact_support</span>
				<h3> Kontakt</h3>
				<p> {{ Firm }}</p>
				<p> {{ FirmAddress }}</p>
				<p> {{ FirmZip }} </p>
				<p> {{ FirmCountry }}</p>
				<p> {{ ContactPerson }}</p>
				<p> {{ ContactEmail }}</p>
				<p> {{ ContactPhone }}</p>
			  </div>
			</div>
			<br><br><br>
			<h2 style="text-align:left;">Vælg billettype</h2>
			<p style="text-align:left;font-size:12px;">(Alle priser er eksl. moms)</p>
			<div class="form-row">
                <label><span>Billettype</span></label>
                <div class="form-radio-buttons">
					{% for Navn,Pris in BilletList %}
                    <div>
                        <label>
                            <input type="radio" id="{{ Navn }}_{{ Pris }}_DKK" name="BilletRadio" value="{{ Navn }}_{{ Pris }}_DKK">
                            <span>{{ Navn }} ({{ Pris }} DKK)</span>
                        </label>
                    </div>
					{% endfor %}
                </div>
            </div>
			
			<h2 style="text-align:left;">Udfyld venligst dine oplysninger</h2>
            {% for Field,req,stripped in FeltList %}
			<div class="form-row">
                <label>
                    <span>{{ Field }}{{ '*' if req == "Ja" else '' }}</span>
                    <input type="text" name="{{ stripped }}">
                </label>
            </div>
			{% endfor %}
			
			<!--
            <div class="form-row">
                <label>
                    <span>Dropdown</span>
                    <select name="dropdown">
                        <option>Option One</option>
                        <option>Option Two</option>
                        <option>Option Three</option>
                        <option>Option Four</option>
                    </select>
                </label>
            </div>
			
            <div class="form-row">
                <label>
                    <span>Textarea</span>
                    <textarea name="textarea"></textarea>
                </label>
            </div>
			-->
            <div class="form-row">
                <label>
                    <span>Accepter betingelser*</span>
                    <input type="checkbox" name="betingelser" value="check">
                </label>
				<div class="SeBetingelser" onclick="myFunction()">Se betingelser</div>
				<div class="popup" >
					<span class="popuptext" id="myPopup">
					<span class="close" onclick="myFunction()"><span class="material-symbols-outlined">close</span></span>
					<strong>Betingelser:</strong>
					
					<br><br>

BRUGERVILKÅR for tilmelding til "D&I - har I styr på hvad medarbejdersammensætningen kan gøre for jeres innovation? " af DANSK HR ( Brunbjergvej 10A, 8240 Risskov). <br><br>


1.0. Generelt<br><br>

1.1. Arrangøren af dette arrangement er DANSK HR, Brunbjergvej 10A, 8240 Risskov, (herefter kaldet ”Arrangøren”).<br><br>

1.2. Aftale om tilmelding indgås mellem Dem og Arrangøren, DANSK HR.<br><br>

1.3. Attendwise Aps tilbyder udelukkende tilmeldingsløsningen til brug for dette arrangement. Attendwise Aps påtager sig følgelig intet ansvar for det omhandlende arrangements indhold eller afholdelse i det der henvises til Arrangøren.<br>

1.4. Betingelserne skal ved Deres tilmelding være læst, og accepteret ved særskilt afkrydsning.<br><br>


2.0. Persondatapolitik <br><br>

2.1. Ved tilmelding bliver de af Dem indtastede oplysninger overført og gemt i Attendwise ApS. interne edb-system samt videresendt til Arrangøren for videre ekspedition. <br><br>

2.2. Oplysningerne anvendes udelukkende til ekspedition af tilmeldingen samt kommunikation vedrørende det tilmeldte arrangement og gemmes efterfølgende for at kunne finde tilbage til tilmeldinger, såfremt der sker afbestilling/ændring/aflysning. <br><br>

2.3. Arrangøren og Attendwise Aps videregiver ikke de registrerede personoplysninger til tredjemand, dog sættes navn, titel og firmanavn på deltagerliste og navneskilte, der udleveres til såvel underviser som øvrige deltagere. Derudover kan data videregives til tredjemand, der benytter data på Arrangørens ordre, som fx en konference app-leverandør. Eller såfremt De specifikt ved særskilt afkrydsning har accepteret at oplysninger bruges til fx udsendelse af et nyhedsbrev fx via Mail Chimp, køb af materiale eller andet. <br><br>

2.4. Oplysningerne opbevares i op til 5 år efter arrangementet har været afholdt, jfr. gældende lovgivning. <br><br>

2.5. Oplysningerne opbevares delvist krypteret, men overføres krypteret. <br><br>

2.6. Som registreret har De altid mulighed for indsigt og for at kan gøre indsigelse mod en registrering i henhold til reglerne i Persondataloven.<br><br>

2.7. Der anvendes cookies på hjemmesiden ConferenceCommunicator.com med det formål at kunne "genfinde" oplysninger om tilmeldinger.<br><br></span>
				</div>
            </div>


            <div class="form-row">
                <button type="submit" name="Submit">Tilmeld</button>
            </div>

        </form>

    </div>
<script>
// When the user clicks on <div>, open the popup
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}


//Remove any special characters and spaces when defining variables in JavaScript
function validateForm() {
	{% for Navn,Pris in BilletList[:1] %}
	if(document.getElementById("{{ Navn }}_{{ Pris }}_DKK").checked){
	  //pass
	}
	{% endfor %}
	{% for Navn,Pris in BilletList[1:] %}
	else if (document.getElementById("{{ Navn }}_{{ Pris }}_DKK").checked){
	  //pass
	} 
	{% endfor %}
	else {
	  alert("Vælg venligst en billet");
	  return false;
	}	


	
  {% for Field,req,stripped in FeltList %}
	  {% if req == "Ja" %}
  let {{ stripped }} = document.forms["myForm"]["{{ stripped }}"].value;
  if ({{ stripped }} == "") {
    alert("{{ Field }} er påkrævet");
    return false;
  }
	{% endif %}
  {% endfor %}
  
  if (!document.forms["myForm"]["betingelser"].checked){
	alert("Acceptér venligst betingelserne");
	return false;
  }
  
}


</script>
</body>
</html>
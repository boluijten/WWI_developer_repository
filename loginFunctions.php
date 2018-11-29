<?php
session_start();
// Register system
	if(isset($_POST['submitRegisterBTN'])){
		$voornaam = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'voornaamRegisterTXT'));
		$achternaam = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'achternaamRegisterTXT'));
		$email = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'emailRegisterTXT'));
		$telnummer = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'telnrRegisterTXT'));
		$woonplaats = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'woonplaatsRegisterTXT'));
		$straat = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'straatRegisterTXT'));
		$huisnummer = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'huisnummerRegisterTXT'));
		$postcode = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'postcodeRegisterTXT'));
		$password = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'passwordRegisterTXT'));
		$passwordCheck = mysqli_real_escape_string($connect, filter_input(INPUT_POST,'passwordRetypeRegisterTXT'));
		if($password == $passwordCheck){


			$result = mysqli_query($connect,"SELECT * FROM user WHERE email = '$email'");
			if (!mysqli_num_rows($result)==0){
				echo "  <!-- The Modal -->
				  <div id='myModal' class='modal'>

				    <!-- Modal content -->
				    <div class='modal-content'>
				      <span class='close'>&times;</span>
				      <p>E-mail al in gebruik!</p>
				    </div>

				  </div>";
			}else{
				$hash = password_hash($password, PASSWORD_DEFAULT);
				$sql = "INSERT INTO user (voornaam, achternaam, email, telnr, woonplaats, straat, huisnummer, postcode, password) VALUES ('$voornaam', '$achternaam', '$email', '$telnummer', '$woonplaats', '$straat', '$huisnummer', '$postcode', '$hash')";
				if ($connect->query($sql) === TRUE) {
				    echo "<script>alert('New user created successfully');</script>";
						include("email.php");
						registerEmail($email);
				} else {
				    echo "Error: " . $sql . "<br>" . $connect->error;
				}
			}



		}else{
			echo "<!-- The Modal -->
							  <div id='myModal' class='modal'>

							    <!-- Modal content -->
							    <div class='modal-content'>
							      <span class='close'>&times;</span>
							      <p>Wachtwoorden kloppen niet!</p>
							    </div>

							  </div>";
		}
	}

// Login system
	if(isset($_POST['submitLoginBTN'])){
		$usernameLogin = mysqli_real_escape_string($connect, filter_input(INPUT_POST, 'emailLoginTXT'));
		$passwordLogin = mysqli_real_escape_string($connect, filter_input(INPUT_POST, 'passwordLoginTXT'));
		$result = mysqli_query($connect,"SELECT * FROM user WHERE email = '$usernameLogin'");

		if (mysqli_num_rows($result)==1){
			$row=mysqli_fetch_row($result);
			if(password_verify($passwordLogin, $row[9])){
				foreach ($row as $key => $value) {
					$_SESSION['userInfo'][$key] = $value;
				}
				echo "<script>alert('Logged in! Welcome ".$_SESSION['username']."');</script>";
				header("location: index.php");

			}else{
				echo "<!-- The Modal -->
									<div id='myModal' class='modal'>

										<!-- Modal content -->
										<div class='modal-content'>
											<span class='close'>&times;</span>
											<p>Wachtwoord niet juist!</p>
										</div>

									</div>";
			}
		}else{
			echo "<!-- The Modal -->
								<div id='myModal' class='modal'>

									<!-- Modal content -->
									<div class='modal-content'>
										<span class='close'>&times;</span>
										<p>Gebruikersnaam klopt niet!</p>
									</div>

								</div>";
		}

	}

// Logout system
	if(isset($_POST['logout'])){
		session_destroy();
		header("location: login.php");
	}

?>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
    modal.style.display = "block";

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

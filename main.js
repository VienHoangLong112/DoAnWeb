function enterPass() {
	var email = document.getElementById("fname");
	var pass = document.getElementById("fpass");
	var fmail = document.getElementById("box1");
	var fpass = document.getElementById("box2");
	email.style.display = "none";
	fmail.style.display = "none";
	pass.style.display = "inline-block";
	fpass.style.display = "block";
}
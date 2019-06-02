var baseURL = "https://cop4331.a2hosted.com/";
var url = "https://cop4331.a2hosted.com/api/Register.php";

var firstName = "";
var lastName = "";
var accountName = "";
var password = "";

function register()
{
	firstName = document.getElementById("firstName").value;
	lastName = document.getElementById("lastName").value;
	accountName = document.getElementById("accountName").value;
	password = document.getElementById("password").value;
	var rpassword = document.getElementById("repeatPassword").value;

	if(password.length < 4)
	{
		alert("Password has to be more than 4 characters!!");
		document.getElementById("password").value = "";
		document.getElementById("repeatPassword").value = "";
		return;
	}

	if(password != rpassword)
	{
		alert("Password and Repeat Password are not the same!!");
		document.getElementById("password").value = "";
		document.getElementById("repeatPassword").value = "";
		return;
	}

	var newPassword = accountName + password;

	var SHA512 = new Hashes.SHA512;

	newPassword = SHA512.hex(newPassword);

	var jsonPayload = '{"FirstName" : ' + firstName + ', "LastName" : ' + lastName + ', "AccountName" : ' + accountName + ', "Password" : ' + newPassword + '}';

	var xhr = XMLHttpRequest();
	xhr.open("POST", url, true,);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{

		xhr.onreadystatechange = function()
		{
			if(this.readyState == 4 && this.status == 200)
			{
				if(jsonResponse.error.length == 0)
					window.location = baseURL + "contact_page.html";
				else
					alert(jsonResponse.error);
			}
		}
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		alert("Invalid Connection!!");
	}
}

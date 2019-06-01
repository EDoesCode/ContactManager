var baseURL = "https://cop4331.a2hosted.com/";
var url = "https://cop4331.a2hosted.com/api/Login.php";

var accountName = "";
var password = "";

function register()
{
	window.location = baseURL + "register.html";
}

function login()
{
	accountName = document.getElementById("accountName").value;
	password = document.getElementById("password").value;

	var newPassword = accountName + password;

	var SHA512 = new Hashes.SHA512;

	newPassword = SHA512.hex(newPassword);

	var jsonPayload = '{"AccountName" : ' + accountName + ', "Password" : ' + newPassword + '}';

	var xhr = XMLHttpRequest();
	xhr.open("POST", url, true,);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try
	{
		var jsonResponse = JSON.parse(xhr.responseText);

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

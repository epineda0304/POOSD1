var urlBase = 'http://small-hermes.xyz/LAMPAPI';
var extension = 'php';

var userId = 0;
var id = 0;
var firstName = "";
var lastName = "";

function doLogin()
{
	userId = 0;
	firstName = "";
	lastName = "";
	
	var login = document.getElementById("userName").value;
	var password = document.getElementById("userPwd").value;
//	var hash = md5( password );
	
	document.getElementById("loginResult").innerHTML = "";

	var tmp = {Username:login,Pwd:password};
//	var tmp = {login:login,password:hash};
	var jsonPayload = JSON.stringify( tmp );
	
	var url = urlBase + '/Login.' + extension;

	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				var jsonObject = JSON.parse( xhr.responseText );
				userId = jsonObject.id;
		
				if( userId < 1 )
				{		
					document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}
		
				firstName = jsonObject.firstName;
				lastName = jsonObject.lastName;

				saveCookie();
	
				window.location.href = "contacts.html";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
	}

}

function saveCookie()
{
	var minutes = 20;
	var date = new Date();
	date.setTime(date.getTime()+(minutes*60*1000));	
	// Putting here
	document.cookie = "firstName=" + firstName + ",lastName=" + lastName + ",userId=" + userId + ",id=" + id + ";expires=" + date.toGMTString();
}

function readCookie()
{
	userId = -1;
	var data = document.cookie;
	var splits = data.split(",");
	for(var i = 0; i < splits.length; i++) 
	{
		var thisOne = splits[i].trim();
		var tokens = thisOne.split("=");
		if( tokens[0] == "firstName" )
		{
			firstName = tokens[1];
		}
		else if( tokens[0] == "lastName" )
		{
			lastName = tokens[1];
		}
		else if( tokens[0] == "userId" )
		{
			userId = parseInt( tokens[1].trim() );
		}
		// Putting here
		else if( tokens[0] == "id" )
		{
			id = parseInt( tokens[1].trim() );
		}
	}
	
	if( userId < 0 )
	{
		window.location.href = "index.html";
	}
	//else
	//{
	//	document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
	//}
}

function doLogout()
{
	userId = 0;
	firstName = "";
	lastName = "";
	document.cookie = "firstName= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
	window.location.href = "index.html";
}

function registerUser()
{
	var firstName = document.getElementById("First_name").value;
	var lastName = document.getElementById("Last_name").value;
	var newUser = document.getElementById("userName").value;
	var password = document.getElementById("userPwd").value;

	document.getElementById("registerAddUser").innerHTML = "";

	var tmp = {FirstName:firstName, LastName:lastName, Username:newUser, Pwd:password};
	var jsonPayload = JSON.stringify( tmp );

	var url = urlBase + '/registerUser.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("registerAddUser").innerHTML = "User has been added";
				window.location.href = "index.html";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("registerAddUser").innerHTML = err.message;
	}
}

function addContact()
{
	readCookie();
	var first = document.getElementById("firstName").value;
	var last = document.getElementById("lastName").value;
	var em = document.getElementById("contactEmail").value;
	var ph = document.getElementById("contactPhone").value;

	document.getElementById("contactAddResult").innerHTML = "";

	var tmp = {First_name:first, User_ID:userId, Last_name:last, email :em, Phone_num: ph};
	var jsonPayload = JSON.stringify( tmp );

	var url = urlBase + '/AddContact.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("contactAddResult").innerHTML = "Contact has been added";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactAddResult").innerHTML = err.message;
	}
}

function searchContact()
{
	readCookie();
	var srch = document.getElementById("searchContacts").value;
	document.getElementById("contactSearchResult").innerHTML = "";
	
	var contactList = "";

	var tmp = {search:srch, User_ID: userId};
	var jsonPayload = JSON.stringify( tmp );

	var url = urlBase + '/searchContacts.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				document.getElementById("contactSearchResult").innerHTML = "Contact(s) has been retrieved";
				var jsonObject = JSON.parse( xhr.responseText );
				
				if(jsonObject.id == 0)
				{
					contactList += '<p class="text-center"> No Records Found </p>';
				}	
				else if(jsonObject.results.length > 0)
				{
					for( var i=0; i<jsonObject.results.length; i++ )
					{
						id = jsonObject.results[i].ID;
						// Putting here
						saveCookie();
						
						contactList += '<tr>';
						contactList += '<td>' + '<div contenteditable="true" id="editFirst'+i+'">' + jsonObject.results[i].First_name + '</div>' + '</td>';
						contactList += '<td>' + '<div contenteditable="true" id="editLast'+i+'">' + jsonObject.results[i].Last_name  + '</div>'+ '</td>';
						contactList += '<td>' + '<div contenteditable="true" id="editEmail'+i+'">'+ jsonObject.results[i].Email + '</div>' + '</td>';
						contactList += '<td>' + '<div contenteditable="true" id="editPhoneNumber'+i+'">'+ jsonObject.results[i].Phone_num + '</div>'+ '</td>';
						
						contactList += '<td>';
						contactList += '<div class="contactOptions">';
						contactList +='<button type="button" class="btn btn-success" onclick="editContact('+id+','+i+');"><i class="fas fa-edit"></i> </button>';
						contactList +='<button type="button" class="btn btn-danger" onclick="deleteContact('+id+');"><i class="fas fa-trash"></i></button>';
						contactList += '</div>';
						contactList += '</td>';
						contactList += '</tr>';
					}
				}
				else
				{
					contactList += '<p class="text-center"> No Data Found </p>';
				}
				
				document.getElementsByTagName("tbody")[0].innerHTML = contactList;
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactSearchResult").innerHTML = err.message;
	}
	
}


function editContact(contactId, row)
{	
	readCookie();
	
	var contactRow = row;
	var id = contactId;
	var fName = document.getElementById("editFirst"+contactRow).innerText;
	var lName = document.getElementById("editLast"+contactRow).innerText;
	var uEmail = document.getElementById("editEmail"+contactRow).innerText;
	var uPhone = document.getElementById("editPhoneNumber"+contactRow).innerText;

	//document.getElementById("contactEditResult").innerHTML = "";

	var tmp = {First_name:fName, Last_name:lName , email:uEmail, Phone_num:uPhone, ID:id, User_ID:userId};
	var jsonPayload = JSON.stringify( tmp );

	var url = urlBase + '/EditContact.' + extension;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				//document.getElementById("contactEditResult").innerHTML = "Contact has been edited.";
			}
		};
		xhr.send(jsonPayload);
	}
	catch(err)
	{
		document.getElementById("contactEditResult").innerHTML = "Could not edit contact.";
	}
	
}


function deleteContact(contactId)
{
  readCookie();

	if (confirm("Are you sure you want to delete this contact?"))
	{
		var tmp = {ID:contactId};
		var jsonPayload = JSON.stringify( tmp );

		var url = urlBase + '/DeleteContact.' + extension;

		var xhr = new XMLHttpRequest();
		xhr.open("POST", url, true);
		xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
		try
		{
			xhr.onreadystatechange = function()
			{
				if (this.readyState == 4 && this.status == 200)
				{
					searchContact();
				}
			};
			xhr.send(jsonPayload);
		}
		catch(err)
		{
			document.getElementById("contactEditResult").innerHTML = "Could not delete";
		}
	}
	else
	{
  	window.location.href = "contacts.html";
	}

	
}


function mySearchFunction() 
{
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchContacts");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

// Transition
window.onload = () => {
		const transition_el = document.querySelector('.transition');
		const anchors = document.querySelectorAll('a');
		
	setTimeout(() => {
			transition_el.classList.remove('is-active');
	}, 150);

	for(let i = 0; i < anchors.length; i++){
		const anchor = anchors[i];

		anchor.addEventListener('click', e => {
			e.preventDefault();
			let target = e.target.href;

			transition_el.classList.add('is-active');

			setTimeout(() => {
					window.location.href = target;
			}, 150);
		});
	}
}

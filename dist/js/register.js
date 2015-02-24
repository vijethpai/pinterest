function validateform()
{
	if( document.register.userid.value == "" )
   	{
     		alert( "Please provide your userid!" );
     		document.register.userid.focus() ;
     		return false;
   	}
	if( document.register.userid.value.length<3 || document.register.userid.value.length>20 )
        {
                alert("User ID length has to between 3-20");
                document.register.userid.focus() ;
                return false;
        }

	if( document.register.email.value == "" )
        {
                alert( "Please provide your EmailAddress!" );
                document.register.email.focus() ;
                return false;
        }
	if( document.register.fname.value == "" )
        {
                alert( "Please provide your first name!" );
                document.register.fname.focus() ;
                return false;
        }
	if( document.register.fname.value.length>20 )
        {
                alert("first name cannot be more than 20 characters");
                document.register.fname.focus() ;
                return false;
        }

	if( document.register.lname.value == "" )
        {
                alert( "Please provide your last name!" );
                document.register.lname.focus() ;
                return false;
        }
	if( document.register.lname.value.length>20 )
        {
                alert("last name cannot be more than 20 characters");
                document.register.lname.focus() ;
                return false;
        }
	if( document.register.password1.value == "" )
        {
                alert( "Please provide enter a password" );
                document.register.password1.focus() ;
                return false;
        }
	if( document.register.password1.value.length<3 || document.register.userid.value.length>20 )
        {
                alert("User ID length has to between 3-20");
                document.register.userid.focus() ;
                return false;
        }


	if( document.register.password1.value != document.register.password2.value)
        {
                alert( "two passwords do not match" );
                document.register.password2.focus() ;
                return false;
        }
	return true;

}

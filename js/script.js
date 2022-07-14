function uploadFile() {
	//Server requests should be sent asynchronously.
    var form = new FormData();
	//console.log(1);
	// document.querySelector('#imageFile').files[0] returns images, in this case 1st image
	//append to fields with two names: file and upload.file will have immages as a vlaue and upload field will have true value
	
    form.append('file', document.querySelector('#imageFile').files[0]);
    form.append('upload', true);
   // we want upload.php to do something before sending response back to the page
    var upload = new XMLHttpRequest();
    upload.open('POST', 'upload.php');
    upload.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
			
			//alert(this.responseText );
            if(this.responseText == 1) {
                document.querySelector('#uploadError').innerText = "Image uploaded successfully.";
                //the index.php is refreshed to load the images from img folder
				setTimeout(window.location.reload(), 1500);
            } else {
                document.querySelector('#uploadError').innerText = "An error occoured when uploading the image";
            }
        }
    };
    upload.send(form);
}


/*
Property	Description
onreadystatechange:	Defines a function to be called when the readyState property changes
readyState:	Holds the status of the XMLHttpRequest.
	0: request not initialized
	1: server connection established
	2: request received
	3: processing request
	4: request finished and response is ready
responseText:	Returns the response data as a string
responseXML	Returns: the response data as XML data
status:	Returns the status-number of a request
	200: "OK"
	403: "Forbidden"
	404: "Not Found"
For a complete list go to the Http Messages Reference
statusText	Returns the status-text (e.g. "OK" or "Not Found"):
for php echo "1" or echo "Sorry, your file was not uploaded.";
In js we get it via this.responseText


*/
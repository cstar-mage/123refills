function popquetion()
	{
		
		//document.getElementById("popupoverlay").style.z-index = '99999';
		document.getElementById("popupoverlay").style.display = 'block';		
		//document.getElementById("popupquestion").style.z-index = '999999';
		document.getElementById("popupquestion").style.display = 'block';
		document.getElementById("popupquestion").style.left = '37%';
		document.getElementById("popupquestion").style.top = '25%';
		
	}
	function popquetionclose()
	{		
		document.getElementById("popupoverlay").style.height = '0';
		document.getElementById("popupoverlay").style.width = '0';
		//document.getElementById("popupoverlay").style.z-index = '0';
		document.getElementById("popupoverlay").style.display = 'none';		
		document.getElementById("popupquestion").style.display = 'none';
	}

	

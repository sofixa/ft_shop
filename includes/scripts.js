function showProducts(cid)
{
	if (cid=="")
	{
		document.getElementById("result").innerHTML="";
		return;
	} 
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("result").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","includes/ops.php?action=showproducts&cid="+cid,true);
	xmlhttp.send();
}

function addToCart(pid)
{
	if (pid=="")
	{
		return;
	} 
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			alert(xmlhttp.responseText);
			countCart();
		}
	}
	xmlhttp.open("GET","includes/ops.php?action=addtocart&pid="+pid,true);
	xmlhttp.send();
}

function countCart()
{
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("carta").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","includes/ops.php?action=countcart",true);
	xmlhttp.send();
}

function removeFromCart(pid)
{
	if (pid=="")
	{
		return;
	} 
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			alert(xmlhttp.responseText);
			location.reload();
		}
	}
	xmlhttp.open("GET","includes/ops.php?action=removefromcart&pid="+pid,true);
	xmlhttp.send();
}




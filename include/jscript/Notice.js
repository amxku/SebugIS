	var intervalId = null; 
	function slideAd(id,nStayTime,sState,nMaxHth,nMinHth){ 
	  this.stayTime=nStayTime*1000 || 5000; 
	  this.maxHeigth=nMaxHth || 40;
	  this.minHeigth=nMinHth || 1;
	  this.state=sState || "down" ; 
	  var obj = document.getElementById(id); 
	  if(intervalId != null)window.clearInterval(intervalId); 
	  function openBox(){ 
	   var h = obj.offsetHeight; 
	   obj.style.height = ((this.state == "down") ? (h + 2) : (h - 2))+"px"; 
	    if(obj.offsetHeight>this.maxHeigth){ 
	    window.clearInterval(intervalId); 
	    intervalId=window.setInterval(closeBox,this.stayTime); 
	    } 
	    if (obj.offsetHeight<this.minHeigth){ 
	    window.clearInterval(intervalId); 
	    obj.style.display="none"; 
	    } 
	  } 
	  function closeBox(){ 
	   slideAd(id,this.stayTime,"up",nMaxHth,nMinHth); 
	  } 
	  intervalId = window.setInterval(openBox,10); 
	}
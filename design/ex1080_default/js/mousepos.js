function getMouseXY(e) 
{ 
  if (!e) e = window.event; 

  if (e)
  { 
    if (e.pageX || e.pageY)
    { 
      mousex = e.pageX;
      mousey = e.pageY;
      algor = '[e.pageX]';
      if (e.clientX || e.clientY) algor += ' [e.clientX] '
    }
    else if (e.clientX || e.clientY)
    { 
      mousex = e.clientX + document.body.scrollLeft;
      mousey = e.clientY + document.body.scrollTop;
      algor = '[e.clientX]';
      if (e.pageX || e.pageY) algor += ' [e.pageX] '
    }  
  }
}

document.onmousemove = getMouseXY;
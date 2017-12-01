var showBtn = document.querySelector("#test button:nth-of-type(1)"),
    hideBtn = document.querySelector("#test button:nth-of-type(2)"),
    content = document.querySelector("#test > div");

// Toggle show/hide classes on test content
showBtn.addEventListener("click", function(){
  content.className = "visible";
}, false);
hideBtn.addEventListener("click", function(){
  content.className = "hidden";
}, false);
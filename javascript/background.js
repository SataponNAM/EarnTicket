// Get the body element
var body = document.getElementsByTagName("body")[0];


// Wait for the CSS file to finish loading
window.onload = function() {
  // Detect if the page has overflowed
  if (document.body.scrollHeight > window.innerHeight) {
    body.style.height = "100%";
  } else {
    body.style.height = "calc(100vh - 150px)";
    
  }
};

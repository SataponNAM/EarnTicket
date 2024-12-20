var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.querySelector("header").classList.remove("hide");
  } else {
    document.querySelector("header").classList.add("hide");
  }
  prevScrollpos = currentScrollPos;
}

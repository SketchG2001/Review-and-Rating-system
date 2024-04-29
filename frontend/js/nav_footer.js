
// to load the navbar csection
function loadNavContent() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "navbar.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("nav-content").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
//  to load the footer content
function loadFooterContent(){
    var foot = new XMLHttpRequest();
    foot.open("GET", "footer.php", true);
    foot.onreadystatechange = function(){
        if (foot.readyState === 4 && foot.status === 200){
            document.getElementById("foot-content").innerHTML = foot.responseText
        }
    };
    foot.send();
}
// Call the function when the page loads
window.onload = function(){
    loadNavContent();
    loadFooterContent();
}







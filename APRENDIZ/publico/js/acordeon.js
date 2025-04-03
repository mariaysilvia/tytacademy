// acordeon
var acc = document.getElementsByClassName("accordion-title");
for (var i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var arrow = this.querySelector(".arrow");
        if (this.classList.contains("active")) {
            arrow.style.transform = 'rotate(180deg)';  
        } else {
            arrow.style.transform = 'rotate(0deg)';  
        }
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
}
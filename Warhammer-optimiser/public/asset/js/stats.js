const Projects = {

    /* talisman part */
    Input: document.querySelectorAll(".qtityInput"),
    Total: document.querySelector(".total"),
    Max: document.querySelector(".max"),

    init: function () {
        Projects.SelectEvent();  
    },

    SelectEvent: function () {
        Projects.Input.forEach((element) => addEventListener('input', Projects.input));
    },

    input: function (evt) {  
        Projects.default = (parseInt(evt.target.value))
        Projects.Total.textContent = Projects.default;
        if (Projects.Total.textContent >= Projects.Max.textContent){
            Projects.Total.style.color = 'black';
            Projects.Total.style.backgroundColor = 'red';
        } else {
            Projects.Total.style.color = 'green';
            Projects.Total.style.backgroundColor = 'transparent';
        }
    },
}

document.addEventListener('DOMContentLoaded', Projects.init);

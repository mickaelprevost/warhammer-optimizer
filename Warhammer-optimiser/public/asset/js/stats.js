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
        Projects.Total.textContent = (parseInt(Projects.default))
        if (Projects.total.textContent >= Projects.Max.textContent){
            Projects.total.style.color = 'black';
            Projects.total.style.backgroundColor = 'red';
        } else {
            Projects.total.style.color = 'green';
            Projects.total.style.backgroundColor = 'transparent';
        }
    },
}

document.addEventListener('DOMContentLoaded', Projects.init);

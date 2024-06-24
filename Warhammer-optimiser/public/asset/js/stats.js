const Projects = {
    /* renown part */
    cost: document.querySelectorAll(".cost"),
    total: document.querySelector(".total"),
    test: 0,
    inputvalue: 0,
    default: 0,
    
    /* talisman part */
    Input: document.querySelectorAll(".qtityInput"),
    Total: document.querySelector(".total"),
    Max: document.querySelector(".max"),

    init: function () {
        Projects.SelectEvent();  
    },

    SelectEvent: function () {
        Projects.cost.forEach((element) => addEventListener('click', Projects.handle));
        Projects.Input.forEach((element) => addEventListener('input', Projects.input));
    },

    handle: function (evt) {
        let text = (evt.target.label)
        let result = text.substr(-2);
        Projects.test += (parseInt(result));
        Projects.total.textContent = Projects.test
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

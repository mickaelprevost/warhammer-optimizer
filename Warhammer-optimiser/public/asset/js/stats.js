const Projects = {
    cost: document.querySelectorAll(".cost"),
    total: document.querySelector(".total"),
    test: 0,
    
    init: function () {
        Projects.SelectEvent();  
    },

    SelectEvent: function () {
        Projects.cost.forEach((element) => addEventListener('click', Projects.handle));
    },

    handle: function (evt) {
        let text = (evt.target.label)
        let result = text.substr(-2);
        Projects.test += (parseInt(result));
        Projects.total.textContent = Projects.test
    },
}
document.addEventListener('DOMContentLoaded', Projects.init);

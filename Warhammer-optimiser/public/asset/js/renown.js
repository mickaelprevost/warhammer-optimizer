$('.form').on('change', '#renown', function (e) {
    let total = $('.total').text();
    let totalInt = (parseInt(total));
    let optiontext = $(e.target).find("option:selected").text();
    let textresult = optiontext.substr(-14);
    let result = (parseInt(textresult));
    let final = result + totalInt;
    $('.total').text(final);
});






        
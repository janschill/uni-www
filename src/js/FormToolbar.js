// var text;

$(document).ready(function() {
    console.log('ready');
    $('.formtoolbar__modifier').click(function() {

        console.log(getTag($(this).text()));
        $('#form_text').val($('#form_text').val() + getTag($(this).text()));

        // e.preventDefault();
    });
});

function getTag(text) {
    var tagClass = "";
    switch (text) {
        case "B":
            tagClass = "'formtoolbar__modifier--bold'"
            break;
        case "I":
            tagClass = "'formtoolbar__modifier--italic'"
            break;
        case "AL":
            tagClass = "'formtoolbar__modifier--al'"
            break;
        case "AC":
            tagClass = "'formtoolbar__modifier--ac'"
            break;
        case "AR":
            tagClass = "'formtoolbar__modifier--ar'"
            break;
        case "JU":
            tagClass = "'formtoolbar__modifier--ju'"
            break;
        case "UL":
            tagClass = "'formtoolbar__modifier--ul'"
            break;
        case "OL":
            tagClass = "'formtoolbar__modifier--ol'"
            break;
        case "<>":
            tagClass = "'formtoolbar__modifier--code'"
            break;
        case "Image":
            tagClass = "'formtoolbar__modifier--image'"
            break;
    }
    console.log("<span class=" + tagClass + "></span>")

    return "<span class=" + tagClass + "></span>";
}


// function addText(event) {
//     var target = event.target || event.srcElement;
//     document.getElementById("form_text").value += target.textContent || target.innerText;
// }
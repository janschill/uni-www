$(document).ready(function() {
    console.log('ready');
    $('.formtoolbar__modifier').click(function(e) {
        console.log('clickmodifier');
        var text = getTag($(this).text());
        $('#form_text').append(text);

        e.preventDefault();
    });
});

function getTag(text) {
    var tagClass = "";
    switch (text) {
        case "B":
            tagClass = "'formtoolbar__modifier--bold'"
    }
    console.log("<span class=" + tagClass + "></span>")
    return "<span class=" + tagClass + "></span>";
}


// function addText(event) {
//     var target = event.target || event.srcElement;
//     document.getElementById("form_text").value += target.textContent || target.innerText;
// }
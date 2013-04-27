// texts.js declares texts, buttonTexts

function shuffle(myArray) {
    // From http://stackoverflow.com/questions/2450954/how-to-randomize-a-javascript-array
    var i = myArray.length, j, tempi, tempj;
    if ( i == 0 ) return false;
    while ( --i ) {
         j = Math.floor( Math.random() * ( i + 1 ) );
         tempi = myArray[i];
         tempj = myArray[j];
         myArray[i] = tempj;
         myArray[j] = tempi;
     }
}

var curMessage = 0;
function nextMessage() {
    $('#body').fadeOut(200, function() {
        if (curMessage == 0) {
            shuffle(texts);
        }
        
        var curButtonTextIndex = Math.floor(Math.random() * buttonTexts.length);
        var curButtonText = buttonTexts[curButtonTextIndex];
        
        var curText = texts[curMessage];
        $('#text').text(curText.text);
        $('#button').text(curButtonText);
        
        if (curText.link) {
            $('#link').empty().
                append($('<a>').attr('href', curText.link).text(curText.link)).
                show();
        } else {
            $('#link').hide();
        }
        
        $('#body').fadeIn(200);
        
        curMessage++;
        
        if (curMessage >= texts.length) curMessage = 0;
    });
}

$(document).ready(function() {
    nextMessage();
    $('#button').click(function() {
        nextMessage();
    });
});

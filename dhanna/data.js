// SCRIPT FOR POST FORM SEARCH DATA FROM DATABASE BY FORM ID #searchData;
var msg_before_searching = '<div style="margin-top:40px" class="alert alert-secondary" role="alert"><h5 class="alert-heading">Start Searching</h5><p>You Should need at least one character to activate the search engine, more characters can filter the fewer and clean results.</p><hr><p class="mb-0">Enter a search term to start filtering.</p></div>';

var waitplease = "<br><div align=\"center\" class=\"alert alert-light\" role=\"alert\"><b>Please Wait... </b> (Request in progress, Be patient!)</div><br>";


$(function(){
    $('#results').html(msg_before_searching);
    $('#searchData').submit(function(){
            $('#results').html(waitplease);
            $.post('assets/search-result-data.php', $(this).serialize(), function(data){
            $('#results').html(data);

            // AUTO REMOVE SECURITY KEY FROM THE INPUT FIELD AFTER SEACH FORM SUBMIT;
            $('#SecurityKey').val('');

            // HIDE SEARCH MODAL AFTER SUBMIT;
            $('.search-form').modal('hide');
             
        }).fail(function() {
             $('#results').html("<b>Error</b>");
        });
        return false;
    });
});



// BELOW FUNCTION WILL RUN AFTER UPDATE AND DELETE ACTION FOR REFRESHING THE SEARCH DATA;
function RefreshSearchDATA() {
    $.post('assets/search-result-data.php', $('#searchData').serialize(), function(data){
        $('#results').html(data);
    }).fail(function() {
         $('#results').html("<b>Error</b>");
    });
    return false;
}


//AUTO LOGOUT SCRIPT;
var reset = 120000;
var timer = reset;
$('body').on('click mousemove keyup', function(){
    timer=reset;
});

function ct(){
    $('#timer').text(timer/1000+' Sec.');
    timer=timer-1000;
    if(timer==0){
        window.location = 'assets/logout.php';
    }
}
setInterval('ct()', 1000);
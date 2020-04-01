jQuery(document).ready(function($) {

    var fly_type = 2;

    $(".results").hide();

    $(".fly-type-single").on("click", function(){
        $("#back-ctrl").prop('disabled', true);

        $(this).css("background-color", "white");
        $("#fly-single").css("color", "#0c2461");

        $(".fly-type-back").css("background-color", "#0c2461");
        $("#fly-back").css("color", "white");

        fly_type = 1;
    })

    $(".fly-type-back").on("click", function(){
        $("#back-ctrl").prop('disabled', false);

        $(this).css("background-color", "white");
        $("#fly-back").css("color", "#0c2461");

        $(".fly-type-single").css("background-color", "#0c2461");
        $("#fly-single").css("color", "white");

        fly_type = 2;
    })

    
    $(".search-button").on("click", function(){

        var input_from = $("#city-from").val();
        var input_to = $("#city-to").val();
        var input_date_start = $("#start-date").val();
        var input_date_back = $("#back-ctrl").val();
        var input_pers = $("#pers-num").val();

        $.ajax({
            url : 'flights.php',
            type : 'GET',
            data : 'type=' + fly_type + '&from=' + input_from + '&to=' + input_to + '&start_date=' + input_date_start + '&back_date=' + input_date_back + '&pers=' + input_pers,
            dataType : 'html',
            success : function(code_html, statut){
                $('.footer-div').css('margin-top', '1100px');

                $("html, body").animate({ scrollTop: $(document).height()-$(window).height() }, 1000);

                $(".results").show();
                $(".results").animate({width: '80%'}, 900);
                $(".results").animate({height: '400px'}, 900);
                $(".results").empty().prepend(code_html);
            },
    
            error : function(resultat, statut, erreur){
                alert("Error !");
            },
    
            complete : function(resultat, statut){
            }
    
        });

    })
    
});
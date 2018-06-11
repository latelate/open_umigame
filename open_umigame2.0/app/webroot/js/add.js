$(document).ready(function(){

    function displayVals() {
        var singleValues = $("input[class=continent]:checked").val()
        var defined = 0;
        if(singleValues == 2){
            $(".zikan").css("display","");
            $(".situ").css("display","");
            $(".kaigyo").css("display","none");
        }else if(singleValues == 3){
            $(".zikan").css("display","");
            $(".situ").css("display","none");
            $(".kaigyo").css("display","none");
        }else if(singleValues == 4){
            $(".zikan").css("display","");
            $(".situ").css("display","");
            $(".kaigyo").css("display","");
        }else if(singleValues == 5){
            $(".zikan").css("display","");
            $(".situ").css("display","");
            $(".kaigyo").css("display","");
        }else{
            $(".zikan").css("display","");
            $(".situ").css("display","none");
            $(".kaigyo").css("display","none");
        }
    }

    $('input[class="continent"]:radio').change(displayVals);
    displayVals();

});

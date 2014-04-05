      var currentImage = 0;

    $(document).ready(function(){
           $("#carousel img").attr("src", jsonimage[0].image); 
           $("#img-Caption").html(jsonimage[0].title);
    });
    
    var timer;
    
    $("#prev_img").on("click", function(){
                clearInterval(timer);

        moveCarousel("negative");
    });
    
    $("#next_img").on("click", function(){
        clearInterval(timer);
        moveCarousel("positive");
    });
    
    $("#stop_img").on("click", function(){
        window.clearTimeout(timer);
    });
    
    $("#play_img").on("click", function(){
        timer = setInterval(function(){  moveCarousel("positive") }, 6000);
        moveCarousel("positive");
    });

        function moveCarousel(direction)
        {
                $("#carousel img").effect('blind', {}, 500,function(){

                    if(direction === "positive" && currentImage + 1 === jsonimage.length)
                     {
                         currentImage = 0;
                     }
                     else if(direction === "negative" && currentImage === 0)
                     {
                         currentImage = jsonimage.length -1;
                        
                     }
                     else if(direction === "positive")
                     {
                         currentImage += 1;
                     }
                     else if(direction === "negative")
                     {
                         currentImage -= 1;
                     }

                       $(this).attr("src", jsonimage[currentImage].image); 
                       $(this).load(function() { $(this).fadeIn(); }); 
                       $("#img-Caption").html(jsonimage[currentImage].title);
                });


        
        }


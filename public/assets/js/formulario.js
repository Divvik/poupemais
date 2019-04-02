// jQuery Time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity,scale; // propriedades de fieldset que iremos animar 

$('.next').click(function(){
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //ativar o próximo passo na barra de progresso usando o índice de next_fs
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //mostre o próximo fieldset
    next_fs.show();
    //esconder o fieldset atual com estilo
    current_fs.animate({opacity:0}, {
    step:function(now,mx){
    //como a opacidade de current_fs reduz para 0
    //1. escala current_fs até 80%
        scale = 1 - (1 - now) * 0.2;
    //2. traga next_fs da direita (50%)
        left = (now * 50)+"%";
    //3. aumentar a opacidade de next_fs para 1 à medida que se move
        opacity = 1 - now;
        current_fs.css({'transform': 'scale('+scale+')'});
        next_fs.css({"left": left, "opacity": opacity});
    },
    duration: 1000,
    complete: function(){
        current_fs.hide();
    },
    //isso vem do plugin de ajuste personalizado
        easing:'easeInOutBack'
    });
});

$('.previous').click(function(){
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //ativar o próximo passo na barra de progresso
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //mostre o fieldset anterior
    previous_fs.show();
    //esconder o fieldset atual com style
    current_fs.animate({opacity:0}, {
    step:function(now,mx){
        //como a opacidade de current_fs reduz para 0
        //1. escala previous_fs de 80% a 100%
        scale = 0.8 + (1 - now) * 0.2;
        //2. pegue current_fs para a direita (50%) - de 0%
        left = ((1-now) * 50)+"%";
        //3. aumentar a opacidade de _fs anterior para 1 à medida que se move
        opacity = 1 - now;
        current_fs.css({'left': left});
        previous_fs.css({'transform': 'scale('+scale+')', "opacity": opacity});
    },
        duration: 1000,
        complete: function(){
        current_fs.hide();
        },
        //sso vem do plugin de ajuste personalizado
        easing:'easeInOutBack'
    });
});
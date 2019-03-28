// var formLogin = document.querySelector("#form-login");

// $("#form-login").on("submit", function(envent){
//     event.preventDefault();
//     var dados = $(this).serialize();

//     $.ajax({
//         url: formLogin.action,
//         type: 'POST',
//         dataType: 'text',
//         data: dados,
//         beforeSend : function(){
//             $(".erro").html("<i class='fas fa-spinner fa-spin'></i>");
//         },success: function(msg){
//             console.log(msg)
//             if(msg != ''){
//                 $(".erro").append(msg).addClass("warning");
//             } else {
                
//                 window.location = 'http://localhost/poupemais/dashboard';
//             }
//         }
//     });

// });
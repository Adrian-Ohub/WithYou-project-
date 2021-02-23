$(document).ready(function(){

    //scroll top para visualizar ultimo mensaje al cargar pagina
    $('#mensajes').stop().animate({
        scrollTop: $('#mensajes')[0].scrollHeight
    });

    $('#mensaje').on('keydown', function(){
        let channel = Echo.private('LiveChat.'+$('#canal').val())
      
        setTimeout( () => {
          channel.whisper('typing', {
            typing: true
            //user: 'user'
          }, 0)
        })
      })

    Echo.private('LiveChat.'+$('#canal').val())

        .listenForWhisper('typing', (e) => {
            console.log(e);
            clearTimeout(timer);
            e.typing ? $('.typing').show() : $('.typing').hide()
            
            var timer = setTimeout( () => {
                $('.typing').hide()
            }, 2000)
            
        })
        
        .listen('LivechatEvent', (e) => {
            console.log(e);
        
            var usuariolog = $('#user_id').val();
            var usuario = e.user.id;

            console.log("Usuario logeado-> " + usuariolog + " Usuario mensaje-> " + usuario);

            
            if(usuario == usuariolog){
                var node = document.createElement("div");  
                node.className = "emisor";
                var paragraph = document.createElement("p");               
                var textnode = document.createTextNode("Digo: "+e.mensaje.mensaje);         
                paragraph.appendChild(textnode); 
                node.appendChild(paragraph);
                document.getElementById("mensaje_enviado").appendChild(node);
                $('#mensajes').stop().animate({
                    scrollTop: $('#mensajes')[0].scrollHeight
                });
            }else{
                var node = document.createElement("div");  
                node.className = "receptor";       
                var paragraph = document.createElement("p");  
                // hay que pasar el user para poder capturar el nombre             
                var textnode = document.createTextNode(e.user.nombre +" dice: "+ e.mensaje.mensaje);         
                paragraph.appendChild(textnode); 
                node.appendChild(paragraph);
                document.getElementById("mensaje_enviado").appendChild(node);
                $('#mensajes').stop().animate({
                    scrollTop: $('#mensajes')[0].scrollHeight
                });
            }  
    });

    $(document).on('submit','#mensaje_form', function(event){
        event.preventDefault()
        //alert($('#mensaje').val());
        $.post("https://dawjavi.insjoaquimmir.cat/ortegaa/Staging---proyecto/public/livechat",{ 
            _token: $('#token').attr('content'),
            user_id: $('#user_id').val(),
            user_id2: $('#user_id2').val(),
            canal: $('#canal').val(),       
            mensaje: $('#mensaje').val()
            
        })

        .done(function (data) {
            //limpia el input de texto
            $('#mensaje').val('');
            //scroll top para visualizar el ultimo mensaje
            $('#mensajes').stop().animate({
                scrollTop: $('#mensajes')[0].scrollHeight
            })
        })
            
    });
});
/**
 * Script responsável pelas funções básicas do sistema (cliente), como o envio e recebimento de mensagens
 * 
 * @author  Hédi Carlos Minin - hedicarlos@gmail.com
 */

var _typing = 0;
var _buffer = new Array();
var _readTime = 3000;
var _timeOutStatus = null;
var _messageFrom = 2;

$(document).ready(function(){
	
	verifyStatus();	
	
});

function verifyStatus(){
	
	$.ajax({
		url: 'verify_status.php',
		type: 'POST',
		data: ({id_client : _client.id}),
		timeout : 15000,
		success: function(data){
							
			switch(parseInt(data.status)){
				case 2:
				
					_user.id = data.user.user_id;
					_user.name = data.user.name;
				
					$('#wait').hide();
					$('#user_name').text(_user.name);
					$('#input').attr('disabled', false);
					$('#input').focus();

					clearTimeout(_timeOutStatus);
					readMessage();
					
				break;
				case 3:
				
					endCall();

				break;
				default:
					$('#wait_info').text('Você é o ' +(parseInt(data.total) + 1) +'º da fila de espera');
					_timeOutStatus = setTimeout('verifyStatus()', _readTime);
			}
			
		},
		error: function(httpRequest){
			/*
			switch(httpRequest.status){
				case 401: $('#wait_info').text('Sessão perdida, reinicie o atendimento.'); break;
				case 500: $('#wait_info').text('Erro interno do servidor, tente novamente mais tarde.'); break;
			}
			*/
			_timeOutStatus = setTimeout('verifyStatus()', _readTime);  
		}
	});	
	
}

function readMessage(){
	
	$.ajax({
		url: 'read_message.php',
		type: 'POST',
		data: 'typing=' + _typing + '&user_id=' + _user.id + _buffer.join(''),
		timeout : 15000,
		success: function(data){
		
			if(data.client.status == 3){
				
				endCall();
				
			}else{
				
				$('#typing').text(parseInt(data.user.typing) == 1 ? 'Digitando' : '');
				processMessages(data.messages);
				setTimeout('readMessage()', _readTime);
				
			}
			_typing = 0;
			
		},
		error: function(httpRequest){
			setTimeout('readMessage()', _readTime);  
			_typing = 0;
		}
	});
	
	_buffer = new Array();
	
}

function processMessages(messages){
	
	for(var i in messages){
		addMessage(messages[i].message);
	}
	
}

function endCall(){
	$('#input').attr('disabled', true);
	window.top.location.href = 'end_call.php';	
}

$(document).ready(function(){

	$('#input').keydown(function(e){
		
		_typing = 1;
		
		if($(this).val().length > 300){
			$(this).val($(this).val().substr(0,300));
		}

		if(e.keyCode == 13){

			if(e.ctrlKey == false){
				
				var message = $(this).val();
				
				if(message.replace(/\n/g,'') == ''){
					setTimeout(function(){ inputClear(); }, 10);
					return false;
				}
			
				send(message);
				
				addMessageToBuffer(message);
				
				setTimeout(function(){ inputClear(); }, 10);
				
			}else{
				$(this).val($(this).val() + '\n')	
			}
		}

	});

});

function addMessageToBuffer(message){
	_buffer.push('&message[]=' + encodeURIComponent(message));	
}

function inputClear(){
	$('#input').val('');
}

function send(message){
	if(_messageFrom != 1){
		$('#talk').append($('<p></p>').addClass('talk_client').text(_client.name +':'));	
		_messageFrom = 1;	
	}
	$('#talk').append($('<p></p>').html(message.replace(/\n/g,'<br />')));
	$('#talk').scrollTop($('#talk').attr('scrollHeight'));
}

function addMessage(message){
	if(_messageFrom != 0){
		$('#talk').append($('<p></p>').addClass('talk_user').text(_user.name +':'));	
		_messageFrom = 0;	
	}
	$('#talk').append($('<p></p>').html(message.replace(/\n/g,'<br />')));
	$('#talk').scrollTop($('#talk').attr('scrollHeight'));
}

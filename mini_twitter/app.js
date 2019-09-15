//var BaseApiUrl = "http://localhost:8080/lab1/index.php/api/news/";
//var BaseApiUrl = "https://gynaecocratic-absen.000webhostapp.com/lab3crud/index.php/api/news/";
var BaseApiUrl = "http://localhost:8080/asignacion_practica_I/index.php/api/users/";
var BaseApiUrlPost = "http://localhost:8080/asignacion_practica_I/index.php/api/Publicacion/";

var ws;
function buildUrl(service){
	return BaseApiUrl + service;
}

function buildUrlPost(service){
	return BaseApiUrlPost + service;
}


window.onload = function(){


	//document.addEventListener("deviceready",onDeviceReady,false);

	var vm = new Vue({
	el : '#app',
	data: {
		userName: '',
		userPass: '',
		varButt:'Guardar',
		users:[],
		showC: true,
		Auth: false,
		UserLogin : '',
		exito : false,
		publicaciones : [],
		publicacion:'',
		falloText:'',
		fallo : false,
		idUser : 0,
		Comentario : '',
		idPublicacion : 0,
		criterio : '',
		ComentarioState : '',
		eliminado : false,
		updatePostState : '',
		updatePostModel : '',
 
	},
	mounted(){
		this.MyWebSocketCall();
		this.getData();
	},
	methods:{
		
		getData(){
			var url = buildUrlPost('getPublicaciones');
			axios.get(url).then((response) => {
				this.publicaciones = response.data;	
				console.log(this.publicaciones);
			}).catch(error => {console.log(error)});
		},
		
		loginSeguro(){
	   	     var data = new FormData();
 			data.append('user',this.userName);
 			data.append('pass',this.userPass);		
			console.log(data);
	   	     var url = buildUrl('postLoginSeguro');
	   	     axios.post(url,data).then((response) => {
	   	     	if(response.data){
	   	     		console.log(response);
	   	     		this.Auth = true;
	   	     		this.UserLogin = response.data["usuario"];
	   	     		console.log(this.UserLogin);
	   	     		this.showC = false;
	   	     		this.exito = true;
	   	     		this.idUser = response.data["id"];
	   	     	}else{
	   	     		this.falloText = "No existen coincidencias";
	   	     		this.fallo = true; 
	   	     		console.log("No existen coincidencias");
	   	     	}
	   	     }).catch(error => {
	   	     	console.log(error)}); 
	     },

	     publicar(){
            console.log(this.idUser);
            var data = new FormData();
 			data.append('idUsuario',this.idUser);
 			data.append('textoPost',this.publicacion);
 			data.append('estado',1);
 			data.append('fecha',new Date().toISOString().slice(0, 19).replace('T', ' '));
 			console.log(data);
 			var url = buildUrlPost('insertPublicacion');
 			axios.post(url,data).then((response) => {
 				console.log(response);
 				this.publicacion = '';
 				this.exito = true;
 				this.getData();
 			}).catch(error => {console.log(error)});
	     },
	     updatePost(){

	     	console.log('ttttt');


	     },
	     deletePost(id){
	     	console.log(id);
	     	var url = buildUrlPost('deletePublicacion/' + id);
	     	axios.get(url).then((response) => {
	     		console.log(response);
	     		this.eliminado = true;
	     		this.getData();
	     	}).catch(error => {console.log(error)});

	     },

	      deleteComment(id){
	     	console.log(id);
	     	var url = buildUrlPost('deleteComentario/' + id);
	     	axios.get(url).then((response) => {
	     		console.log(response);
	     		this.eliminado = true;
	     		this.getData();
	     	}).catch(error => {console.log(error)});

	     },

	     buscarPost(){
	     	var url = buildUrlPost('getPublicaciones/' + this.criterio);
			axios.get(url).then((response) => {
				this.publicaciones = response.data;
				console.log(this.publicaciones.data);
			}).catch(error => {console.log(error)});

	     },

	     responder(){
            console.log(this.idUser);
            var data = new FormData();
 			data.append('idUsuario',parseInt(this.idUser));
 			data.append('textoComentario',this.Comentario);
 			data.append('estado',1);
 			data.append('idPost', parseInt(this.idPublicacion));
 			data.append('fecha',new Date().toISOString().slice(0, 19).replace('T', ' '));
 			console.log(data);
 			var url = buildUrlPost('insertComentario');
 			axios.post(url,data).then((response) => {
 				console.log(response);
 				this.Comentario = '';
 				this.exito = true;
 				this.getData();
 			}).catch(error => {console.log(error)});
	     },


	     resetModal() {
        this.Comentario = '';
        this.ComentarioState = '';
      },

      resetModalPost(){
            this.updatePostModel = '';
            this.updatePostState = '';
      },



		MyWebSocketCall() {
				if ("WebSocket" in window) {
						 console.log("WebSocket is supported by your Browser!");
						 // Let us open a web socket
						 //personalizamos la url con nuestro propio room_id
						 //wss://connect.websocket.in/chopo?room_id=23
						 ws = new WebSocket("wss://connect.websocket.in/francisco123456789?room_id=23");
						 ws.onopen = function() {
						 // Web Socket is connected, send data using send()
						 ws.send("open");
						 console.log("WebSocket is open...");
				 };
					 

					 ws.onmessage = function (evt) {
					 //cada vez que se invoca el ws.send() se recibe una respuesta de forma asincrónica
					 vm.getData();
					 console.log("Message is received: " + evt.data); //evt.data contiene el msj recibido
				 		};
				 ws.onclose = function() {
				 // websocket is closed.
				 console.log("Connection is closed...");
				 };
				} else {
				 // The browser doesn't support WebSocket
				 alert("WebSocket NOT supported by your Browser!");
				}
				}
	}

	   
});

}



function onDeviceReady() {
        // Register the event listener
        document.addEventListener("backbutton", onBackKeyDown, false);
}

function onConfirm(buttonIndex) {
    if (buttonIndex==2){
        navigator.app.exitApp();
    }
}

// Handle the back button
//
function onBackKeyDown() {
        navigator.notification.confirm(
            '¿Está seguro que desea salir?',  // message
            onConfirm,              // callback to invoke with index of button pressed
            'Salir de myApp',            // title
            'No,Sí'         // buttonLabels
        );
}
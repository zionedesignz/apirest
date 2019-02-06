export default class Apiquery {
   
  constructor(url, token, method, sec, data) {
    this.url = url || ''; //url de la API
    this.token = token || ''; //token de acceso
    this.method = method || '';//metodo petición
    this.sec = sec || ''; //id formulario HTML (se usa para resetear formulario)
    this.data = data || ''; //datos
    this.asignarURL = e => {
      if( e.target.id != ''){ 
        this.url = e.target.id;
        this.fetchCall();
      }
    }; //funcion asignar url a this.url a partir del event.target.id
       //parametro de la clase ya que sino el this pasa a ser el elemento 
       //al que se le añade el evento y no podemos modificar el parametro url.
  }

  //consulta
  async fetchCall(){

    let cont = `m${this.sec}`;

    if(this.method == 'POST' || this.method == 'PUT'){

      //realizamos la consulta
      await fetch(this.url, {
        method: this.method,
        body: JSON.stringify(this.data),
        headers: new Headers({
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': this.token
        }),
      })
      .then(res =>{
        //comprobar http status y asignar estilo al contenedor
        if(res.status == 200 || res.status == 201){
          window[cont].setAttribute('class','alert alert-success text-center mt-3');
            // si la sección no es de busqueda
            if(!this.sec.includes('buscar')){
              //si tiene formulario, resetearlo
              if(document.querySelector(`#${this.sec}`)){
                document.querySelector(`#${this.sec}`).reset();
              }
            }
        }else{
          window[cont].setAttribute('class','alert alert-danger text-center mt-3');
        }
        //transformar a json
        return res.json();
      })
      //enviar datos a la funcion showContent
      .then(rData => this.showContent(rData))
      .catch(error => console.error(error));

    }else{

      //realizamos la consulta
      await fetch(this.url, {
        method: this.method,
        headers: new Headers({
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': this.token
        }),
      })
      .then(res =>{
        //comprobar http status y asignar estilo al contenedor
        if(res.status == 200 || res.status == 201){
          window[cont].setAttribute('class','alert alert-success text-center mt-3');
            // si la sección no es de busqueda
            if(!this.sec.includes('buscar')){
              //si tiene formulario, resetearlo
              if(document.querySelector(`#${this.sec}`)){
                document.querySelector(`#${this.sec}`).reset();
              }
            }
        }else{
          window[cont].setAttribute('class','alert alert-danger text-center mt-3');
        }
        //transformar a json
        return res.json();
      })
      //enviar datos a la funcion showContent
      .then(rData => this.showContent(rData))
      .catch(error => console.error(error));
      
    }

  }

  //mostrar contenido
  showContent(rData){

    let datos = '';
    let datosPag= '';
    let cont = `m${this.sec}`; 
    let contPag = `p${this.sec}`;
        
    //si existe mensaje
    if (rData.mensaje){

      datos = rData.mensaje;
      window[cont].innerHTML = JSON.stringify(datos);

      //si la seccion tiene paginación, eliminar
     if(document.body.contains( window[contPag] )){
        window[contPag].innerHTML = '';
      }

    }
    //si existen datos 
    if (rData.data){

      //montar contenido
      for(let i of rData.data){
        datos += `<div class='bg-light rounded m-1 p-1'>
                    <p>ID: ${i.idusuario}</p>
                    <p>FECHA: ${i.fecha}</p>
                    <p>HORA: ${i.hora}</p>
                    <p>SERVICIO: ${i.servicio}</p>
                    <p>DURACIÓN: ${i.tiemposervicio}min</p>
                    <p>ESTADO: ${i.estado}</p>
                    <p>CLIENTE: ${i.nombreusuario}</p>
                    <p>TELEFONO: ${i.telefonousuario}</p>
                  </div>`;         
      }
      //si cambia el contenido actualizar
      datos != window[cont].innerHTML ? window[cont].innerHTML = datos : window[cont].innerHTML;

    }
    //si existe paginación 
    if (rData.pages){

      //montar contenido
      datosPag += `<nav>
                  <ul class="pagination pagination-sm justify-content-center">
                    <li class="page-item ${rData.pages.first == '' ? 'disabled' : ''}">
                      <p class="page-link" id="${rData.pages.first == '' ? '#' : rData.pages.first}">Primera</p>
                    </li>`;
      for(let i of rData.pages.pages){
        datosPag += `<li class="page-item ${i.current_page == 'yes' ? 'active' : ''}">
                    <p class="page-link" id="${i.url}">${i.page}</p>
                  </li>`;
      }
      datosPag += `<li class="page-item ${rData.pages.last == '' ? 'disabled' : ''}">
                  <p class="page-link" id="${rData.pages.last == '' ? '#' : rData.pages.last}">Última</p>
                </li>
              </ul>
            </nav>`;
      //si cambia la paginación actualizar 
      datosPag != window[contPag].innerHTML ? window[contPag].innerHTML = datosPag : window[contPag].innerHTML;

      //añadir listener a la paginación
      window[contPag].addEventListener('click', this.asignarURL);

    }
  }
}


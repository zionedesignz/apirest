export default class Reserva {

  constructor(...params) {
    this.idusuario = params[0][0], 
    this.fecha = params[0][1], 
    this.hora = params[0][2], 
    this.servicio = params[0][3], 
    this.tiemposervicio = params[0][4], 
    this.nombreusuario = params[0][5] || 'NULL', 
    this.telefonousuario = params[0][6] || 'NULL',
    this.id = params[0][7] || 'NULL',
    this.estado = params[0][8] || 'PENDIENTE'
  }

}

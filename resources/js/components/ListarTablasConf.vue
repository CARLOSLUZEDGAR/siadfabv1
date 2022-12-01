<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
             BOTONES DE CONFIGURACIÓN
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Reportes Varios</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="card collapsed-card">
                  <div class="card-header">
                    <h3 class="card-title">MIGRAR TABLAS</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    Tablas para migrar 
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="row p-2 bd-highlight justify-content-center">
                      <div class="col-md-2">
                        <button type="button" class="btn btn-secondary btn-sm btn-block" @click="personalDestinosTable()">
                          <i class="far fa-file-alt" aria-hidden="true">  Personal Destinos</i>
                        </button> &nbsp;
                      </div>
                    </div>
                  </div>
                  <!-- /.card-footer-->
                </div> 

                <div class="card collapsed-card">
                  <div class="card-header">
                    <h3 class="card-title">AUMENTAR</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    Aumenta los destinos del personal nuevo
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="row p-2 bd-highlight justify-content-center">
                      <div class="col-md-2">
                        <button type="button" class="btn btn-secondary btn-sm btn-block" @click="aumentarDestinosTable()">
                          <i class="far fa-file-alt" aria-hidden="true">  Aumentar Destinos</i>
                        </button> &nbsp;
                      </div>
                    </div>
                  </div>
                  <!-- /.card-footer-->
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      efectivo : ''
    }
  },
  mounted() {
    
  },
  computed:{
            
        },
  methods: {
        personalDestinosTable(){
          swal.fire({
              title: 'Esta seguro de MIGRAR los Datos a la Tabla personal_destinos', // TITULO 
              icon: 'question', //ICONO (success, warnning, error, info, question)
              showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
              confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
              cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
              confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
              cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
              buttonsStyling: true,
              reverseButtons: true
              }).then((result) => {
              if (result.value) {
                  //CODIGO HA SER VALIDADO
                  let me =this;
                  // this.idPersonalDestino = personalDestinos.idpersonal_destinos,
                  axios
                  .put('/migrar/personal_destinos', {
              //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                  // idPersonalDestino : me.idPersonalDestino,
                  // per_codigo : me.per_codigo,
              })
              .then(function (response) {
                  //Respuesta de la peticion
                  // console.log(response);
                  // me.listarPersonalDestinos(me.per_codigo);
                  if (response.data.code == 200) {
                      swal.fire(
                          "Completa", //TITULO
                          "Se migro correctamente las tablas personal_destinos", //TEXTO DE MENSAJE
                          "success" // TIPO DE MODAL (success, warnning, error, info)
                      );
                      // me.atras();
                  } else {
                      swal.fire(
                          "Error", //TITULO
                          "Ocurrio un error en la migración.", //TEXTO DE MENSAJE
                          "error" // TIPO DE MODAL (success, warnning, error, info)
                      );
                  }
              })
              .catch(function (error) {
                  // handle error
                  console.log(error);
                  });
              }else{
                  console.log('no empezamos');
              }
          })  
        },

        aumentarDestinosTable(){
          swal.fire({
              title: 'Esta seguro de AUMENTAR los Datos a la Tabla personal_destinos', // TITULO 
              icon: 'question', //ICONO (success, warnning, error, info, question)
              showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
              confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
              cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
              confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
              cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
              buttonsStyling: true,
              reverseButtons: true
              }).then((result) => {
              if (result.value) {
                  //CODIGO HA SER VALIDADO
                  let me =this;
                  // this.idPersonalDestino = personalDestinos.idpersonal_destinos,
                  axios
                  .put('/aumentar/personal_destinos', {
              //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                  // idPersonalDestino : me.idPersonalDestino,
                  // per_codigo : me.per_codigo,
                  })
                  .then(function (response) {
                      //Respuesta de la peticion
                      console.log(response);
                      // me.listarPersonalDestinos(me.per_codigo);
                      switch (response.data.code) {
                        case 100:
                          swal.fire(
                              "Completa", //TITULO
                              "Se AUMENTO correctamente los datos y se elimino datos dobles", //TEXTO DE MENSAJE
                              "success" // TIPO DE MODAL (success, warnning, error, info)
                          );
                          break;
                        case 200:
                          swal.fire(
                              "Completa", //TITULO
                              "Se AUMENTO correctamente los datos y no se encontro datos dobles", //TEXTO DE MENSAJE
                              "success" // TIPO DE MODAL (success, warnning, error, info)
                          );
                        break;
                        case 300:
                          swal.fire(
                              "Completa", //TITULO
                              "No se encontro datos para aumentar, pero se elimino datos dobles", //TEXTO DE MENSAJE
                              "success" // TIPO DE MODAL (success, warnning, error, info)
                          );
                        break;
                        case 400:
                          swal.fire(
                              "Completa", //TITULO
                              "No se encontro datos para aumentar, tampoco se encontro datos dobles", //TEXTO DE MENSAJE
                              "success" // TIPO DE MODAL (success, warnning, error, info)
                          );
                        break;
                      
                        default:
                          swal.fire(
                              "Error", //TITULO
                              "Ocurrio un error al Aumentar datos.", //TEXTO DE MENSAJE
                              "error" // TIPO DE MODAL (success, warnning, error, info)
                          );
                        break;
                      }
                  })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                    });
              }else{
                  console.log('no empezamos');
              }
          })  
        },









        personalEscalafonesTable(){
          swal.fire({
              title: 'Esta seguro de migrar los Datos a la Tabla personal_escalafones', // TITULO 
              icon: 'question', //ICONO (success, warnning, error, info, question)
              showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
              confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
              cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
              confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
              cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
              buttonsStyling: true,
              reverseButtons: true
              }).then((result) => {
              if (result.value) {
                  //CODIGO HA SER VALIDADO
                  let me =this;
                  // this.idPersonalDestino = personalDestinos.idpersonal_destinos,
                  axios
                  .put('/migrar/personal_escalafones', {
              //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                  // idPersonalDestino : me.idPersonalDestino,
                  // per_codigo : me.per_codigo,
              })
              .then(function (response) {
                  //Respuesta de la peticion
                  console.log(response);
                  // me.listarPersonalDestinos(me.per_codigo);
                  if (response.data.code == 200) {
                      swal.fire(
                          "Completa", //TITULO
                          "Se migro correctamente las tablas personal_escalafones", //TEXTO DE MENSAJE
                          "success" // TIPO DE MODAL (success, warnning, error, info)
                      );
                      // me.atras();
                  } else {
                      swal.fire(
                          "Error", //TITULO
                          "Ocurrio un error en la migración.", //TEXTO DE MENSAJE
                          "error" // TIPO DE MODAL (success, warnning, error, info)
                      );
                  }
              })
              .catch(function (error) {
                  // handle error
                  console.log(error);
                  });
              }else{
                  console.log('no empezamos');
              }
          })  
        },

        personalEstudiosTable(){
          swal.fire({
              title: 'Esta seguro de migrar los Datos a la Tabla personal_destinos', // TITULO 
              icon: 'question', //ICONO (success, warnning, error, info, question)
              showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
              confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
              cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
              confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
              cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
              buttonsStyling: true,
              reverseButtons: true
              }).then((result) => {
              if (result.value) {
                  //CODIGO HA SER VALIDADO
                  let me =this;
                  // this.idPersonalDestino = personalDestinos.idpersonal_destinos,
                  axios
                  .put('/migrar/personal_destinos', {
              //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                  // idPersonalDestino : me.idPersonalDestino,
                  // per_codigo : me.per_codigo,
              })
              .then(function (response) {
                  //Respuesta de la peticion
                  console.log(response);
                  // me.listarPersonalDestinos(me.per_codigo);
                  if (response.data.code == 200) {
                      swal.fire(
                          "Completa", //TITULO
                          "Se migro correctamente las tablas personal_destinos y personal_cargos", //TEXTO DE MENSAJE
                          "success" // TIPO DE MODAL (success, warnning, error, info)
                      );
                      // me.atras();
                  } else {
                      swal.fire(
                          "Error", //TITULO
                          "Ocurrio un error en la migración.", //TEXTO DE MENSAJE
                          "error" // TIPO DE MODAL (success, warnning, error, info)
                      );
                  }
              })
              .catch(function (error) {
                  // handle error
                  console.log(error);
                  });
              }else{
                  console.log('no empezamos');
              }
          })  
        },

        personalEspecialidadesTable(){
          swal.fire({
              title: 'Esta seguro de migrar los Datos a la Tabla personal_destinos', // TITULO 
              icon: 'question', //ICONO (success, warnning, error, info, question)
              showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
              confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
              cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
              confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
              cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
              buttonsStyling: true,
              reverseButtons: true
              }).then((result) => {
              if (result.value) {
                  //CODIGO HA SER VALIDADO
                  let me =this;
                  // this.idPersonalDestino = personalDestinos.idpersonal_destinos,
                  axios
                  .put('/migrar/personal_destinos', {
              //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                  // idPersonalDestino : me.idPersonalDestino,
                  // per_codigo : me.per_codigo,
              })
              .then(function (response) {
                  //Respuesta de la peticion
                  console.log(response);
                  // me.listarPersonalDestinos(me.per_codigo);
                  if (response.data.code == 200) {
                      swal.fire(
                          "Completa", //TITULO
                          "Se migro correctamente las tablas personal_destinos y personal_cargos", //TEXTO DE MENSAJE
                          "success" // TIPO DE MODAL (success, warnning, error, info)
                      );
                      // me.atras();
                  } else {
                      swal.fire(
                          "Error", //TITULO
                          "Ocurrio un error en la migración.", //TEXTO DE MENSAJE
                          "error" // TIPO DE MODAL (success, warnning, error, info)
                      );
                  }
              })
              .catch(function (error) {
                  // handle error
                  console.log(error);
                  });
              }else{
                  console.log('no empezamos');
              }
          })  
        },

        personalSituacionesTable(){
          swal.fire({
              title: 'Esta seguro de migrar los Datos a la Tabla personal_destinos', // TITULO 
              icon: 'question', //ICONO (success, warnning, error, info, question)
              showCancelButton: true, //HABILITACION DEL BOTON CANCELAR
              confirmButtonColor: 'info', // COLOR DEL BOTON PARA CONFIRMAR
              cancelButtonColor: '#868077', // CLOR DEL BOTON CANCELAR
              confirmButtonText: 'Confirmar', //TITULO DEL BOTON CONFIRMAR
              cancelButtonText: 'Cancelar', //TIUTLO DEL BOTON CANCELAR
              buttonsStyling: true,
              reverseButtons: true
              }).then((result) => {
              if (result.value) {
                  //CODIGO HA SER VALIDADO
                  let me =this;
                  // this.idPersonalDestino = personalDestinos.idpersonal_destinos,
                  axios
                  .put('/migrar/personal_destinos', {
              //NOMBRE ENVIA AL CONTROLADOR : me.NOMBRE V-MODEL O VARIBLE DECLARADA
                  // idPersonalDestino : me.idPersonalDestino,
                  // per_codigo : me.per_codigo,
              })
              .then(function (response) {
                  //Respuesta de la peticion
                  console.log(response);
                  // me.listarPersonalDestinos(me.per_codigo);
                  if (response.data.code == 200) {
                      swal.fire(
                          "Completa", //TITULO
                          "Se migro correctamente las tablas personal_destinos y personal_cargos", //TEXTO DE MENSAJE
                          "success" // TIPO DE MODAL (success, warnning, error, info)
                      );
                      // me.atras();
                  } else {
                      swal.fire(
                          "Error", //TITULO
                          "Ocurrio un error en la migración.", //TEXTO DE MENSAJE
                          "error" // TIPO DE MODAL (success, warnning, error, info)
                      );
                  }
              })
              .catch(function (error) {
                  // handle error
                  console.log(error);
                  });
              }else{
                  console.log('no empezamos');
              }
          })  
        },

        // cuadroEfectivoDetallado(){
        //   window.open('http://127.0.0.1:8000/cuadroEfectivoTotal');
        //   // window.open('https://sipefab.fab.bo/cuadroEfectivoTotal');

        // },

        // cuadroEgresadoNoEgresado(escalafon){
        //   window.open('http://127.0.0.1:8000/cuadroEgresadoNoEgresado?esc='+escalafon);
        //   // window.open('https://sipefab.fab.bo/cuadroEgresadoNoEgresado?esc='+escalafon);

        // },

        // cuadroFamiliaresPersonal(escalafon){
        //   window.open('http://127.0.0.1:8000/cuadroFamiliaresPersonal?esc='+escalafon);
        //   // window.open('https://sipefab.fab.bo/cuadroFamiliaresPersonal?esc='+escalafon);

        // },

        // cuadroPromocionCant(escalafon){
        //   window.open('http://127.0.0.1:8000/cuadroPromocionCant?esc='+escalafon);
        //   // window.open('https://sipefab.fab.bo/cuadroPromocionCant?esc='+escalafon);

        // },

        // cuadroSituacionPersonal(escalafon){
        //   window.open('http://127.0.0.1:8000/cuadroSituacionPersonal?esc='+escalafon);
        //   // window.open('https://sipefab.fab.bo/cuadroSituacionPersonal?esc='+escalafon);

        // },

        // cuadroFechaIncorporacion(escalafon){
        //   window.open('http://127.0.0.1:8000/cuadroFechaIncorporacion?esc='+escalafon);
        //   // window.open('https://sipefab.fab.bo/cuadroFechaIncorporacion?esc='+escalafon);

        // },        
  },
};

</script>

<style>
</style>
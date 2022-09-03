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
                      <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                      </button> -->
                    </div>
                  </div>
                  <div class="card-body">
                    Tablas para migrar 
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-secondary btn-sm" @click="personalDestinosTable()">
                        <i class="far fa-file-alt" aria-hidden="true">  Personal Destinos</i>
                      </button> &nbsp;
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

        cuadroEfectivoDetallado(){
          window.open('http://127.0.0.1:8000/cuadroEfectivoTotal');
          // window.open('https://sipefab.fab.bo/cuadroEfectivoTotal');

        },

        cuadroEgresadoNoEgresado(escalafon){
          window.open('http://127.0.0.1:8000/cuadroEgresadoNoEgresado?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroEgresadoNoEgresado?esc='+escalafon);

        },

        cuadroFamiliaresPersonal(escalafon){
          window.open('http://127.0.0.1:8000/cuadroFamiliaresPersonal?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroFamiliaresPersonal?esc='+escalafon);

        },

        cuadroPromocionCant(escalafon){
          window.open('http://127.0.0.1:8000/cuadroPromocionCant?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroPromocionCant?esc='+escalafon);

        },

        cuadroSituacionPersonal(escalafon){
          window.open('http://127.0.0.1:8000/cuadroSituacionPersonal?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroSituacionPersonal?esc='+escalafon);

        },

        cuadroFechaIncorporacion(escalafon){
          window.open('http://127.0.0.1:8000/cuadroFechaIncorporacion?esc='+escalafon);
          // window.open('https://sipefab.fab.bo/cuadroFechaIncorporacion?esc='+escalafon);

        },        
  },
};

</script>

<style>
</style>
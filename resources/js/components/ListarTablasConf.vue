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
                      <h3 class="card-title">CUADRO PERICIAS</h3>
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
                      Reporte donde muestra la cantidad del personal de Sofs. y Sgtos por grado de pericia y por unidad.
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
                  
                  <div class="card collapsed-card">
                    <div class="card-header">
                      <h3 class="card-title">CUADRO DE EFECTIVOS DEL PERSONAL</h3>
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
                      Reporte donde muestra el efectivo total del personal en Servicio Activo segun su genero.
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="col-md-12">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cuadroEfectivoDetallado()">
                          <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                        </button> &nbsp;
                      </div>
                    </div>
                    <!-- /.card-footer-->
                  </div>
  
                  <div class="card collapsed-card">
                    <div class="card-header">
                      <h3 class="card-title">CUADRO DEL PERSONAL SEGUN EGRESADO/NO EGRESADO</h3>
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
                      Reporte donde muestra por escalafon al personal egresado de un instituto de formación o el personal que fue asimilado.
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="col-md-6">
                          <div class="input-group">
                          <!-- select combo patr abuscar-->
                          <label class="form-control-label col-md-4" for="text-input">EFECTIVO:</label>
                              <select class="form-control col-md-6" v-model="efectivo">
                                  <!-- values como la base de datos -->
                                  <option value="" disabled>SELECCIONE</option>
                                  <option value="O">OFICIALES</option>
                                  <option value="ST" >SOFS/SGTOS TECNICOS</option>
                                  <option value="SM">SOFS/SGTOS DE MUSICA</option>
                                  <option value="C">PERSONAL CIVIL</option>
                                  <!-- <option value="T">GENERAL</option> -->
                                  <!-- <option value="per_paterno">APELLIDO PATERNO</option> -->
                              </select>
                          </div>
                          <div class="row p-2 bd-highlight justify-content-center">
                              <template v-if="efectivo == 'O' || efectivo == 'ST' || efectivo == 'SM' || efectivo == 'C' || efectivo == 'T'">
                                  <div class="col-md-4">
                                      <button type="button" class="btn btn-secondary btn-sm btn-block" @click="cuadroEgresadoNoEgresado(efectivo)">
                                          <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                                      </button>
                                  </div>
                              </template>
                          </div>
                      </div>
                    </div>
                    <!-- /.card-footer-->
                  </div> 
  
                  <div class="card collapsed-card">
                    <div class="card-header">
                      <h3 class="card-title">CUADRO DE FAMILIARES DEL PERSONAL ESPOSA(O)/HIJOS</h3>
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
                      Reporte donde muestra a los familiares del personal como ser Esposa(o) e hijos.
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="col-md-6">
                          <div class="input-group">
                          <!-- select combo patr abuscar-->
                          <label class="form-control-label col-md-4" for="text-input">EFECTIVO:</label>
                              <select class="form-control col-md-6" v-model="efectivo">
                                  <!-- values como la base de datos -->
                                  <option value="" disabled>SELECCIONE</option>
                                  <option value="O">OFICIALES</option>
                                  <option value="ST" >SOFS/SGTOS TECNICOS</option>
                                  <option value="SM">SOFS/SGTOS DE MUSICA</option>
                                  <option value="C">PERSONAL CIVIL</option>
                                  <!-- <option value="T">GENERAL</option> -->
                                  <!-- <option value="per_paterno">APELLIDO PATERNO</option> -->
                              </select>
                          </div>
                          <div class="row p-2 bd-highlight justify-content-center">
                              <template v-if="efectivo == 'O' || efectivo == 'ST' || efectivo == 'SM' || efectivo == 'C' || efectivo == 'T'">
                                  <div class="col-md-4">
                                      <button type="button" class="btn btn-secondary btn-sm btn-block" @click="cuadroFamiliaresPersonal(efectivo)">
                                          <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                                      </button>
                                  </div>
                              </template>
                          </div>
                      </div>
                    </div>
                    <!-- /.card-footer-->
                  </div>
  
                  <div class="card collapsed-card">
                    <div class="card-header">
                      <h3 class="card-title">CUADRO DE EFECTIVO POR PROMOCIÓN DE EGRESO</h3>
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
                      Reporte donde muestra el efectivo por promociones del personal.
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="col-md-6">
                          <div class="input-group">
                          <!-- select combo patr abuscar-->
                          <label class="form-control-label col-md-4" for="text-input">EFECTIVO:</label>
                              <select class="form-control col-md-6" v-model="efectivo">
                                  <!-- values como la base de datos -->
                                  <option value="" disabled>SELECCIONE</option>
                                  <option value="O">OFICIALES</option>
                                  <option value="ST" >SOFS/SGTOS TECNICOS</option>
                                  <option value="SM">SOFS/SGTOS DE MUSICA</option>
                                  <option value="C">PERSONAL CIVIL</option>
                                  <!-- <option value="T">GENERAL</option> -->
                                  <!-- <option value="per_paterno">APELLIDO PATERNO</option> -->
                              </select>
                          </div>
                          <div class="row p-2 bd-highlight justify-content-center">
                              <template v-if="efectivo == 'O' || efectivo == 'ST' || efectivo == 'SM' || efectivo == 'C' || efectivo == 'T'">
                                  <div class="col-md-4">
                                      <button type="button" class="btn btn-secondary btn-sm btn-block" @click="cuadroPromocionCant(efectivo)">
                                          <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                                      </button>
                                  </div>
                              </template>
                          </div>
                      </div>
                    </div>
                    <!-- /.card-footer-->
                  </div> 
  
                  <div class="card collapsed-card">
                    <div class="card-header">
                      <h3 class="card-title">CUADRO DEL PERSONAL CON SITUACIÓN MILITAR</h3>
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
                      Reporte donde muestra al personal con la situación actual que se encuentra.
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="col-md-6">
                          <div class="input-group">
                          <!-- select combo patr abuscar-->
                          <label class="form-control-label col-md-4" for="text-input">EFECTIVO:</label>
                              <select class="form-control col-md-6" v-model="efectivo">
                                  <!-- values como la base de datos -->
                                  <option value="" disabled>SELECCIONE</option>
                                  <option value="O">OFICIALES</option>
                                  <option value="ST" >SOFS/SGTOS TECNICOS</option>
                                  <option value="SM">SOFS/SGTOS DE MUSICA</option>
                                  <option value="C">PERSONAL CIVIL</option>
                                  <!-- <option value="T">GENERAL</option> -->
                                  <!-- <option value="per_paterno">APELLIDO PATERNO</option> -->
                              </select>
                          </div>
                          <div class="row p-2 bd-highlight justify-content-center">
                              <template v-if="efectivo == 'O' || efectivo == 'ST' || efectivo == 'SM' || efectivo == 'C' || efectivo == 'T'">
                                  <div class="col-md-4">
                                      <button type="button" class="btn btn-secondary btn-sm btn-block" @click="cuadroSituacionPersonal(efectivo)">
                                          <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                                      </button>
                                  </div>
                              </template>
                          </div>
                      </div>
                    </div>
                    <!-- /.card-footer-->
                  </div> 
  
                  <div class="card collapsed-card">
                    <div class="card-header">
                      <h3 class="card-title">CUADRO DEL PERSONAL CON FECHA DE INCORPORACIÓN</h3>
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
                      Reporte donde muestra al personal con su respectiva fecha de incorporación.
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="col-md-6">
                          <div class="input-group">
                          <!-- select combo patr abuscar-->
                          <label class="form-control-label col-md-4" for="text-input">EFECTIVO:</label>
                              <select class="form-control col-md-6" v-model="efectivo">
                                  <!-- values como la base de datos -->
                                  <option value="" disabled>SELECCIONE</option>
                                  <option value="O">OFICIALES</option>
                                  <option value="ST" >SOFS/SGTOS TECNICOS</option>
                                  <option value="SM">SOFS/SGTOS DE MUSICA</option>
                                  <option value="C">PERSONAL CIVIL</option>
                                  <!-- <option value="T">GENERAL</option> -->
                                  <!-- <option value="per_paterno">APELLIDO PATERNO</option> -->
                              </select>
                          </div>
                          <div class="row p-2 bd-highlight justify-content-center">
                              <template v-if="efectivo == 'O' || efectivo == 'ST' || efectivo == 'SM' || efectivo == 'C' || efectivo == 'T'">
                                  <div class="col-md-4">
                                      <button type="button" class="btn btn-secondary btn-sm btn-block" @click="cuadroFechaIncorporacion(efectivo)">
                                          <i class="far fa-file-alt" aria-hidden="true">  Generar Reporte</i>
                                      </button>
                                  </div>
                              </template>
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
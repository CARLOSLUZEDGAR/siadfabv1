<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
              Organismo
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Destinos</li>
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
            <!-- card 1 Busqueda Personal -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-search"></i>
                    Buscar Organismo
                  </h3>
              </div>
              <div class="card-body">
                <div class="row form-group"> <!-- Para centrear se pone estos codigos -->
                  <div class="col-md-8 ">
                    <div class="input-group">
                      <select class="form-control col-md-3" v-model="criterio">
                          <option value="descripcion">Descripcion</option>
                          <!-- <option value="observacion">Observaciones</option> -->
                      </select>
                      <input type="text" class="form-control col-md-4" placeholder="Ingrese dato..." style="text-transform:uppercase;" v-model="buscar" @keyup.enter="listarDestinos1(1,buscar,criterio)">
                      <button class="btn btn-primary btn-flat " type="subnmit" @click="listarDestinos1(1,buscar,criterio)">
                          <i class="fas fa-search"></i>&nbsp; Buscar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- fin card 1 Busqueda Personal -->

            <!-- card 2 Muestra listado Destinos 1 -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"> 
                  <i class="fas fa-list"></i>
                  Listado&nbsp;
                </h3>
                <button v-if="$auth.can('insert-destniv1')" type="button" @click="NuevoDestinos1()" class="btn btn-secondary btn-sm" style="vertical-align: top; padding: 5px 50px;">
                    <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
                </button>
                <!-- <button v-if="$auth.can('report-destniv1')" type="button"  @click.prevent="GenerarPdfDestinos1()" class="btn btn-info btn-flat btn-sm" style="vertical-align: top">
                    <i class="fas fa-file-pdf"></i>&nbsp;&nbsp;Ver PDF
                </button> -->
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                      <tr style="width:100px; text-align:center">
                        <th>Opciones</th>
                        <th>Descripción</th>
                        <th>Observaciones</th>
                        <th>Estado</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr v-for="destinos1 in arrayDestinos1" :key="destinos1.id">
                      <td style="width:100px; text-align:center">
                        <template v-if="destinos1.estado == 1">
                          <button v-if="$auth.can('edit-destniv1')" type="button" @click="abrirEditar(destinos1)" class="btn btn-warning btn-sm" >
                            <i class="fas fa-edit"></i>
                          </button> &nbsp;
                          <button v-if="$auth.can('delete-destniv1')" type="button" class="btn btn-danger btn-sm" @click="DesactivarDestinos1(destinos1.id)">
                            <i class="fas fa-trash"></i>
                          </button>
                        </template>
                        <template v-else>
                            <button v-if="$auth.can('delete-destniv1')" type="button" class="btn btn-secondary btn-sm" @click="ActivarDestinos1(destinos1.id)">
                                <i class="far fa-times-circle"></i>
                            </button>
                        </template>
                      </td>
                      <td v-text="destinos1.descripcion"></td>
                      <td v-text="destinos1.observacion"></td>
                      <td style="width:100px; text-align:center">
                        <div v-if="destinos1.estado">
                            <span class="badge badge-success">Activo</span>
                        </div>
                        <div v-else>
                            <span class="badge badge-danger">Desactivo</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!-- /.card -->
              
              <div class="card-footer clearfix">
                <ul class="pagination  m-0">
                  <li class="page-item" v-if="pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                  </li>
                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                  </li>
                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                  </li>
                </ul>
              </div>

            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
      </div>
      <!-- /.container-fluid -->

      <div class="modal fade" id="NuevoDestinos1"> <!-- Modal para registro nuevo CERO -->
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">REGISTRAR NUEVO ORGANISMO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
              <div class="col-md-12"><!-- descripcion -->
                <div class="form-group">
                  <label>Descripción</label>
                  <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcion.$error, 'is-valid':!$v.descripcion.$invalid }" style="text-transform:uppercase">
                  <div class="invalid-feedback">
                    <span v-if="!$v.descripcion.required">Este campo es Requerido</span>
                  </div>
                </div>
              </div>

              <div class="col-md-12"><!-- observaciones -->
                <div class="form-group">
                  <label>Observaciones</label>
                  <input  class="form-control" v-model="observaciones" placeholder="Ingrese observaciones" style="text-transform:uppercase;" maxlength="300" @keypress="alphanumeric">
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="RegistrarDestino()">Registrar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
            </div>
          </div>
            <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>
        <!-- /.modal -->

      <div class="modal fade" id="EditarDestinos1"> <!-- Modal para actualizar CERO-->
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">EDITAR ORGANISMO</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="col-md-12"><!-- descripcion -->
                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" v-model="descripcionA" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcionA.$error, 'is-valid':!$v.descripcionA.$invalid }" style="text-transform:uppercase">
                    <div class="invalid-feedback">
                      <span v-if="!$v.descripcionA.required">Este campo es Requerido</span>
                    </div>
                </div>
              </div>

              <div class="col-md-12"><!-- observaciones -->
                <div class="form-group">
                    <label>Observaciones</label>
                    <input  class="form-control" v-model="observacionesA" placeholder="Ingrese observaciones" style="text-transform:uppercase;" maxlength="300" @keypress="alphanumeric">
                </div>
              </div>

              <input type="text" hidden v-model="id" name="" id=""> <!-- con esto recuperamos el percodigo para poder actualizar los datos -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="EditarDestino()">Actualizar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
        <!-- /.modal -->

        


    </section>
    <!-- /.content -->
  </div>

</template>

<script>
  import { required, between, minLength, maxLength, alpha, numeric, email} from "vuelidate/lib/validators";
  

    export default {
        data() {
          return {
            submitStatus: null,
            arrayDestinos1 : [],
            
            // Valores para guardar
            descripcion : "",
            observaciones : "",

            // valores para ACTUALZIZAR
            descripcionA : 0,
            observacionesA : 0,
            id : "",

            pagination : {
                'total' : 0,         
                'current_page' : 0, 
                'per_page' : 0, 
                'last_page' : 0, 
                'from' : 0, 
                'to' : 0, 
            },
            offset : 3, 
            buscar: "",
            criterio: 'descripcion',

          }
        },

        validations: {
          descripcion: { required },
          descripcionA: { required },
          validationGroupReg: ['descripcion'],
          validationGroupEdit: ['descripcionA']
        },

        computed:{
          isActived: function(){
              return this.pagination.current_page;
          },
          pagesNumber: function() {
          if(!this.pagination.to){
              return [];
          }
          var from = this.pagination.current_page - this.offset;
          if(from < 1){
              from = 1;
          }
          var to = from + (this.offset *2);
          if( to >= this.pagination.last_page){
              to = this.pagination.last_page;
          }
          var pagesArray = [];
          while( from <= to){
              pagesArray.push(from);
              from ++;
          }
          return pagesArray;
          },
        },   

        methods: {

          listarDestinos1(page,buscar, criterio){
              let me = this;
              var url = '/listarDestino1?page=' + page + '&buscar=' + buscar.toUpperCase() + '&criterio=' + criterio;
              axios
              .get(url)
              .then(function (response) {
                  var respuesta= response.data;
                  me.arrayDestinos1 = respuesta.destino1.data;
                  me.pagination = respuesta.pagination;
              })
              .catch(function (error) {
              console.log(error);
              });
          },

          cambiarPagina(page,buscar,criterio){
            let me = this;
            me.pagination.current_page = page;
            me.listarDestinos1(page,buscar,criterio);
          },

          Cerrar(){
            this.$v.$reset()
          },

          NuevoDestinos1(){
            this.$v.$reset()
            this.descripcion = "";
            this.observaciones = "";
            $('#NuevoDestinos1').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
          },

          alphanumeric ($event) { //SOLO NUMEROS
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122) && (keyCode < 48 || keyCode > 57) && keyCode !== 45 && keyCode !== 32) { // 46 is dot
              $event.preventDefault();
            }
          },

          RegistrarDestino(){ 
            this.$v.$reset();
            if(!this.$v.validationGroupReg.$invalid){
              swal.fire({
                    title: 'Se registrarán los siguientes datos', 
                    icon: 'question', 
                    showCancelButton: true, 
                    confirmButtonColor: 'info', 
                    cancelButtonColor: '#868077', 
                    confirmButtonText: 'Confirmar', 
                    cancelButtonText: 'Cancelar', 
                    buttonsStyling: true,
                    reverseButtons: true
                    }).then((result) => {
                      if (result.value) { 

                        let me = this;
                        axios
                        .post("/registrarDestino1", {
                            des: me.descripcion.toUpperCase(),
                            obs: me.observaciones.toUpperCase()
                        })
                        .then(function (response) {
                            //console.log(response);
                            me.datos = response.data;
                            $('#NuevoDestinos1').modal('hide');
                            swal.fire(
                              "Aceptado", //TITULO
                              "Se añadio correctamente el Destino", //TEXTO DE MENSAJE
                              "success" // TIPO DE MODAL (success, warnning, error, info)
                            );
                            me.listarDestinos1(1, '', 'descripcion'); 
                        })
                        .catch(function (error) {
                            
                            console.log(error);
                        });

                      }
                    })
            }else{
              this.$v.$touch();
              Swal.fire({
                icon: 'warning',
                title: 'Ingrese todos los datos requeridos',
                showConfirmButton: false,
                timer: 2000
              })
            }
          },

          abrirEditar(destinos1){ 
            this.descripcionA = destinos1.descripcion,
            this.observacionesA = destinos1.observacion,
            this.id = destinos1.id,
            $('#EditarDestinos1').modal('show');
            $(".modal-header").css("background-color", "#007bff"); 
            $(".modal-header").css("color", "white" );
          },
          EditarDestino(){ //DOS_2
            this.$v.$reset();
            if(!this.$v.validationGroupEdit.$invalid){

                swal.fire({
                  title: 'Se actualizarán los siguientes campos', // TITULO 
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
                    let me = this;
                    axios
                    .put("/editarDestino1", { 
                        id: me.id,
                        des: me.descripcionA.toUpperCase(),
                        obs: me.observacionesA.toUpperCase(),
                    })
                    .then(function (response) {
                      me.datos = response.data;
                      $('#EditarDestinos1').modal('hide');
                      swal.fire(
                        "Aceptado", //TITULO
                        "Se modificó correctamente el Destino", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                      )
                      me.listarDestinos1(1, '', 'descripcion'); 
                    })
                    .catch(function (error) {
                      // handle error
                      console.log(error);
                    });
                  }
                })
            }else{
            this.$v.$touch();
              Swal.fire({
                icon: 'warning',
                title: 'Ingrese todos los datos requeridos',
                showConfirmButton: false,
                timer: 2000
              })
            }
          },

          DesactivarDestinos1(id){ //DOS_2
            swal.fire({
              title: '¿Está seguro de Desactivar este Destino ?', // TITULO 
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
                //SI SE DA CLIC A ACEPTAR
                let me = this;
                axios
                .put("/desactivarDestino1", { //Se pone put para el envio de datos
                    'id':id
                })
                .then(function (response) {
                    
                  me.datos = response.data;
                  me.listarDestinos1(1, '', 'descripcion'); //Al momento de cerrar esto actualiza la lista
                  swal.fire(
                    "Aceptado", //TITULO
                    "Se ha desactivado el Destino.", //TEXTO DE MENSAJE
                    "success" // TIPO DE MODAL (success, warnning, error, info)
                  );
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                })
              }else{
                console.log('no empezamos');
              }
            })
          },

          ActivarDestinos1(id){ //DOS_2
            swal.fire({
              title: '¿Está seguro de Activar este Destino ?', // TITULO 
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
                //SI SE DA CLIC A ACEPTAR
                let me = this;
                axios
                .put("/activarDestino1", { //Se pone put para el envio de datos
                    'id':id
                })
                .then(function (response) {
                  me.datos = response.data;
                  me.listarDestinos1(1, '', 'descripcion'); 
                  swal.fire(
                    "Aceptado", //TITULO
                    "Se ha Activado el destino.", //TEXTO DE MENSAJE
                    "success" // TIPO DE MODAL (success, warnning, error, info)
                  );
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })

              }else{
              console.log('no empezamos');
              }
            })






            
          },

          GenerarPdfDestinos1(){
            window.open('http://sipefab.fab.bo/generarPdfDestinos1');
          },

          


        },

        mounted() {
            this.listarDestinos1(1, this.buscar, this.criterio); //Esto nos sirve para listar al principio la lista destinos
        },
    }
</script>

<style lang="scss" scoped>

</style>
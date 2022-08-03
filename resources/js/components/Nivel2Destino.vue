<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="far fa-bookmark"></i>
              Gran Unidad
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
                    Buscar Gran Unidad
                  </h3>
              </div>
              <div class="card-body">
                <div class="row form-group"> <!-- Para centrear se pone estos codigos -->
                  <div class="col-md-8 ">
                    <div class="input-group">
                      <select class="form-control col-md-3" v-model="criterio">
                          <option value="nivel1_destinos.descripcion">Organismo</option>
                          <option value="nivel2_destinos.descripcion">Descripción</option>
                      </select>
                      <input type="text" class="form-control col-md-4" placeholder="Ingrese dato..." style="text-transform:uppercase;" v-model="buscar" @keyup.enter="listarDestinos2(1,buscar,criterio)">
                      <button class="btn btn-primary btn-flat" type="subnmit" @click="listarDestinos2(1,buscar,criterio)">
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
                <button v-if="$auth.can('insert-destniv2')" type="button" @click="NuevoDestinos2()" class="btn btn-secondary btn-sm" style="vertical-align: top; padding: 5px 50px;">
                    <i class="fas fa-plus-circle"></i>&nbsp;Nuevo
                </button>
                <!-- <button v-if="$auth.can('report-destniv2')" type="button"  @click.prevent="GenerarPdfDestinos1()" class="btn btn-info btn-flat btn-sm" style="vertical-align: top">
                    <i class="fas fa-file-pdf"></i>&nbsp;&nbsp;Ver PDF
                </button> -->
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped table-sm">
                  <thead>
                      <tr style="width:100px; text-align:center">
                        <th>Opciones</th>
                        <th>Organismo</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Observaciones</th>
                        <th>Ogd</th>
                        <th>Estado</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr v-for="destinos2 in arrayDestinos2" :key="destinos2.id">
                      <td style="width:100px; text-align:center">
                        <template v-if="destinos2.estado">
                          <button v-if="$auth.can('edit-destniv2')" type="button" @click="abrirEditar(destinos2)" class="btn btn-warning btn-sm" >
                            <i class="fas fa-edit"></i>
                          </button> &nbsp;
                          <button v-if="$auth.can('delete-destniv2')" type="button" class="btn btn-danger btn-sm" @click="DesactivarDestinos2(destinos2.id2)">
                              <i class="fas fa-trash"></i>
                          </button>
                        </template>
                        <template v-else>
                            <button v-if="$auth.can('delete-destniv2')" type="button" class="btn btn-secondary btn-sm" @click="ActivarDestinos2(destinos2.id2)">
                                <i class="far fa-times-circle"></i>
                            </button>
                        </template>
                      </td>
                      <td v-text="destinos2.descripcion"></td>
                      <td v-text="destinos2.descripcion2"></td>
                      <td v-text="destinos2.prioridad"></td>
                      <td v-text="destinos2.observacion"></td>
                      <td v-text="destinos2.ogd"></td>
                      <td style="width:100px; text-align:center">
                          <div v-if="destinos2.estado">
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

      <div class="modal fade" id="NuevoDestinos2"> <!-- Modal para registro nuevo CERO -->
        <div class="modal-dialog  ">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">REGISTRAR GRAN UNIDAD</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
              <div class="form-group row"><!-- destino nivel 1 -->
                <label class="col-md-3 form-control-label" for="text-input">Organismo</label>
                <div class="col-md-12">
                  <select class="form-control" v-model="iddestino1" :class="{ 'is-invalid' : $v.iddestino1.$error, 'is-valid':!$v.iddestino1.$invalid }">
                    <option value="0" disabled>SELECCIONE</option>
                    <option v-for="destino1 in arrayDestinos1" :key="destino1.id" :value="destino1.id" v-text="destino1.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino1.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
              </div>


              <div class="form-group row"><!-- descripcion -->
                  <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                  <div class="col-md-12">
                      <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcion.$error, 'is-valid':!$v.descripcion.$invalid }" style="text-transform:uppercase">
                      <div class="invalid-feedback">
                        <span v-if="!$v.descripcion.required">Este campo es Requerido</span>
                      </div>
                  </div>
              </div>

              <div class="form-group row"><!-- prioridad -->
                  <div class="col-md-6">
                    <label class="col-md-3 form-control-label" for="text-input">Prioridad</label>
                    <select class="form-control" v-model="prioridad" :class="{ 'is-invalid' : $v.prioridad.$error, 'is-valid':!$v.prioridad.$invalid }">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>      
                      <option value="5">5</option>
                    </select>
                    <div class="invalid-feedback">
                      <span v-if="!$v.prioridad.required">Este campo es Requerido</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="col-md-3 form-control-label" for="text-input">Ogd</label>
                    <select class="form-control" v-model="ogd" :class="{ 'is-invalid' : $v.ogd.$error, 'is-valid':!$v.ogd.$invalid }">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <div class="invalid-feedback">
                      <span v-if="!$v.ogd.required">Este campo es Requerido</span>
                    </div>
                  </div>
              </div>

              <div class="form-group row"><!-- observaciones -->
                <label class="col-md-3 form-control-label" for="text-input">Observaciones</label>
                <div class="col-md-12">
                  <input class="form-control" v-model="observaciones" placeholder="Ingrese observaciones" style="text-transform:uppercase;" maxlength="300">
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="RegistrarDestino2()">Registrar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" @click="Cerrar()">Cerrar</button>
            </div>
          </div>
            <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>
        <!-- /.modal -->

      <div class="modal fade" id="EditarDestinos2"> <!-- Modal para actualizar CERO-->
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">EDITAR GRAN UNIDAD</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form-group row"><!-- destino nivel 1 -->
                <label class="col-md-3 form-control-label" for="text-input">Organismo</label>
                <div class="col-md-12">
                  <select class="form-control" v-model="iddestino1A" :class="{ 'is-invalid' : $v.iddestino1A.$error, 'is-valid':!$v.iddestino1A.$invalid }">
                    <option value="0" disabled>SELECCIONE</option>
                    <option v-for="destino1 in arrayDestinos1" :key="destino1.id" :value="destino1.id" v-text="destino1.descripcion"></option>
                  </select>
                  <div class="invalid-feedback">
                    <span v-if="!$v.iddestino1A.required">Seleccione un valor porfavor</span>
                  </div>
                </div>
              </div>


              <div class="form-group row"><!-- descripcion -->
                  <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                  <div class="col-md-12">
                      <input type="text" v-model="descripcionA" class="form-control" placeholder="Ingrese descripción" :class="{ 'is-invalid' : $v.descripcionA.$error, 'is-valid':!$v.descripcionA.$invalid }" style="text-transform:uppercase">
                      <div class="invalid-feedback">
                        <span v-if="!$v.descripcionA.required">Este campo es Requerido</span>
                      </div>
                  </div>
              </div>

              <div class="form-group row"><!-- prioridad -->
                  <div class="col-md-6">
                    <label class="col-md-3 form-control-label" for="text-input">Prioridad</label>
                    <select class="form-control" v-model="prioridadA" :class="{ 'is-invalid' : $v.prioridadA.$error, 'is-valid':!$v.prioridadA.$invalid }">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>      
                      <option value="5">5</option>
                    </select>
                    <div class="invalid-feedback">
                      <span v-if="!$v.prioridadA.required">Este campo es Requerido</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="col-md-3 form-control-label" for="text-input">Ogd</label>
                    <select class="form-control" v-model="ogdA" :class="{ 'is-invalid' : $v.ogdA.$error, 'is-valid':!$v.ogdA.$invalid }">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <div class="invalid-feedback">
                      <span v-if="!$v.ogdA.required">Este campo es Requerido</span>
                    </div>
                  </div>
              </div>

              <div class="form-group row"><!-- observaciones -->
                <label class="col-md-3 form-control-label" for="text-input">Observaciones</label>
                <div class="col-md-12">
                  <input class="form-control" v-model="observacionesA" placeholder="Ingrese observaciones" style="text-transform:uppercase;" maxlength="300">
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
            descripcion : '',
            arrayDestinos2 : [],
            
            iddestino1 : "", 
            arrayDestinos1 : [], 
            descripcion : "",
            prioridad : "",
            ogd : "",
            observaciones : "",

            iddestino1A : 0,
            descripcionA : "",
            prioridadA : "",
            observacionesA : "",
            ogdA : "",
            id : "",

            

            pagination : {
                'total' : 0,   //total de registros       
                'current_page' : 0, //pagina actual
                'per_page' : 0, //numero de registro por paginas
                'last_page' : 0, //la ultima pagina
                'from' : 0, //desde la pagina 
                'to' : 0, //hasta la pagina
            },
            offset : 3, //pagination
            buscar: "",
            criterio: 'nivel1_destinos.descripcion',

          }
        },

        validations:{
          iddestino1 : { required},
          descripcion: {required},
          prioridad: {required},
          ogd: {required},
          iddestino1A : { required},
          descripcionA: {required},
          prioridadA: {required},
          ogdA: {required},
          validationGroupReg: ['iddestino1', 'descripcion','prioridad', 'ogd'],
          validationGroupEdit: ['iddestino1A', 'descripcionA','prioridadA', 'ogdA']
        },

        computed:{
          isActived: function(){
              return this.pagination.current_page;
          },
          //Calcuar los elementos de la paginacion
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

          listarDestinos2(page,buscar, criterio){
              let me = this;
              var url = '/listarDestino2?page=' + page + '&buscar=' + buscar.toUpperCase() + '&criterio=' + criterio;
              axios
              .get(url)
              .then(function (response) {
                  var respuesta= response.data;
                  me.arrayDestinos2 = respuesta.destino2.data;
                  me.pagination = respuesta.pagination;
              })
              .catch(function (error) {
              // handle error
              console.log(error);
              });
          },

          selectDestinos1(){
            let me =this;
            var url='/selectNivel1Destino';
            axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayDestinos1 = respuesta.destino1; 
              
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
          },

          cambiarPagina(page,buscar,criterio){
            let me = this;
            me.pagination.current_page = page;
            me.listarDestinos2(page,buscar,criterio);
          },

          NuevoDestinos2(){ //UNO
            this.$v.$reset()
            this.selectDestinos1();
            this.iddestino1 = "";
            this.descripcion = "";
            this.prioridad = "";
            this.observaciones = "";
            this.ogd = "";
            $('#NuevoDestinos2').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
          },

          RegistrarDestino2(){ //DOS
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
                    .post("/registrarDestino2", {
                      iddestino1: me.iddestino1,
                      des: me.descripcion.toUpperCase(),
                      pri: me.prioridad,
                      ogd: me.ogd,
                      obs: me.observaciones.toUpperCase()
                    })
                    .then(function (response) {
                      me.datos = response.data;
                      $('#NuevoDestinos2').modal('hide'); //nos permite cerrar
                      swal.fire(
                        "Aceptado", //TITULO
                        "Se añadio correctamente la Gran Unidad", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                      );
                      me.listarDestinos2(1, '', 'descripcion'); //Al momento de cerrar esto actualiza la lista
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                  }
                })
              }
              else{
                this.$v.$touch();
                Swal.fire({
                  icon: 'warning',
                  title: 'Ingrese todos los datos requeridos',
                  showConfirmButton: false,
                  timer: 2000
                })
              }
          },

          abrirEditar(destinos2){ //UNO_1
            this.id = destinos2.id2,
            this.iddestino1A = destinos2.d1_cod,
            this.descripcionA = destinos2.descripcion2,
            this.prioridadA = destinos2.prioridad,
            this.observacionesA = destinos2.observacion,
            this.ogdA = destinos2.ogd,
            $('#EditarDestinos2').modal('show');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
            this.selectDestinos1();
            
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
                  .put("/editarDestino2", { //Se pone put para el envio de datos
                      id: me.id,
                      destn1: me.iddestino1A,
                      des: me.descripcionA.toUpperCase(),
                      pri: me.prioridadA,
                      ogd: me.ogdA,
                      obs: me.observacionesA.toUpperCase()
                  })
                  .then(function (response) {
                      
                      me.datos = response.data;
                      $('#EditarDestinos2').modal('hide'); //nos permite cerrar
                      swal.fire(
                        "Aceptado", //TITULO
                        "Se modificó correctamente el Destino", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warnning, error, info)
                      )
                      me.listarDestinos2(1, '', 'descripcion2'); //Al momento de cerrar esto actualiza la lista
                  })
                  .catch(function (error) {
                      // handle error
                      console.log(error);
                  })
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

          DesactivarDestinos2(id2){ //DOS_2

            swal.fire({
              title: '¿Está seguro de Desactivar este Destino?', // TITULO 
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
                .put("/desactivarDestino2", { //Se pone put para el envio de datos
                    'id':id2
                })
                .then(function (response) {
                    
                    me.datos = response.data;
                    me.listarDestinos2(1, '', 'descripcion2'); //Al momento de cerrar esto actualiza la lista
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

          ActivarDestinos2(id2){ //DOS_2
            swal.fire({
              title: '¿Está seguro de Activar este Destino?', // TITULO 
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
                .put("/activarDestino2", { //Se pone put para el envio de datos
                    'id':id2
                })
                .then(function (response) {
                    
                    me.datos = response.data;
                    me.listarDestinos2(1, '', 'descripcion2'); //Al momento de cerrar esto actualiza la lista
                    swal.fire(
                        "Aceptado", //TITULO
                        "Se ha Activado el Destino.", //TEXTO DE MENSAJE
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
            window.open('http://sipefab.fab.bo/generarPdfDestinos2','_blank');
          }

        },

        mounted() {
            this.listarDestinos2(1, this.buscar, this.criterio); //Esto nos sirve para listar al principio la lista destinos
        },
    }
</script>

<style lang="scss" scoped>

</style>
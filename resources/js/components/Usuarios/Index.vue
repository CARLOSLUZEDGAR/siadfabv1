<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">            
            <h1>
              <i class="fas fa-users"></i> &nbsp;
              USUARIOS
            </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Modals & Alerts</li>
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
                <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                    <i class="fas fa-user-plus"></i> &nbsp;
                    REGISTRAR NUEVO USUARIO
                    </h3>
                </div>
                <div class="card-body">
                        <div class="row  d-flex justify-content-center">
                            <div class="col-md-8 ">
                                <div class="input-group">
                                    <div class="col-md-8">
                                        <v-select
                                            label="text"
                                            :options="Apersonal"
                                            v-model="per"
                                        >
                                            <template v-slot:no-options="{ search, searching }">
                                            <template v-if="searching">
                                                Lo sentimos, no hay opciones de coincidencia para <em>{{
                                                search
                                                }}</em
                                                >.
                                            </template>
                                            <em v-else
                                                >Lo sentimos, no hay opciones de coincidencia.</em
                                            >
                                            </template>
                                        </v-select>
                                    </div>    
                                    <button class="btn btn-primary" type="subnmit" @click="NuevoUsuarioModal()">
                                        <i class="fas fa-search"></i>&nbsp; BUSCAR
                                    </button>
                                </div>

                            </div>
                        </div>
                </div>
                <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
            </div>
            <!-- ./row -->
            <div class="row">
            <div class="col-md-12">
                <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                    <i class="far fa-list-alt"></i>&nbsp;
                    LISTA DE USUARIOS
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center"> 
                        <div class="col-md-4">
                            <label for="">BUSCAR:</label>
                            <input type="text" style="text-transform:uppercase;" class="form-control" @keyup="BuscarUsuario(1)" v-model="buscar">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 20%" class="text-center">OPCIONES</th>
                                    <th style="width: 40%" class="text-center">NOMBRE</th>
                                    <th style="width: 20%" class="text-center">CARNET MILITAR</th>
                                    <th style="width: 20%" class="text-center">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="u in Ausuarios">
                                    <td class="text-center">
                                        <button  type="button" class="btn btn-success btn-sm" @click="ModalRoles(u.id)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button  type="button" class="btn btn-primary btn-sm" @click="EditarModal(u.id)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button v-if="u.estado === 1" type="button" class="btn btn-danger btn-sm" @click="CambioEstado(u.estado, u.id)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-success btn-sm" @click="CambioEstado(u.estado, u.id)">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                    <td>{{u.grado}} {{u.complemento}} {{u.nombre}} {{u.paterno}} {{u.materno}}</td>
                                    <td class="text-center">{{u.cm}}</td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div v-if="u.estado === 1">
                                        <span class="badge badge-success">Habilitado</span>
                                        </div>
                                        <div v-else>
                                        <span class="badge badge-danger">Desabilitado</span>                                            
                                        </div>                            
                                    </td> 
                                </tr>
                            </tbody>
                            
                        </table> 
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                                </li>
                                
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                                </li>
                            </ul>
                        </nav>
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
      

        <!-- Seccion de Modals -->
        <!-- Modal Nuevo Usuario -->
        <div class="modal fade" id="NuevoUsuario">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">{{datos.grado}} {{datos.complemento}} {{datos.nombre}} {{datos.paterno}} {{datos.materno}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <!-- llenado de informacion de Datos -->
                        <div class="row">
                            <!-- Foto del Personal -->
                            <div  class="col-md-2" style="vertical-align:middle;">
                                 <img :src="'https://sipefab.fab.bo/img/personal/'+datos.foto" width="100%" height="100%">
                            </div>
                            <!-- datos personales -->
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <dl>
                                            <dt class="st">CARNET MILITAR</dt>
                                            <dd class="st">{{ datos.cm }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl>
                                            <dt class="st">CARNET DE IDENTIDAD</dt>
                                            <dd class="st">{{ datos.ci }} {{ datos.expedido }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl>
                                            <dt class="st">SITUACION</dt>
                                            <dd class="st">{{ datos.situacion }}</dd>
                                        </dl>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <dl>
                                            <dt class="st">DESTINO ACTUAL</dt>
                                            <dd class="st">{{ datos.des2 }} {{ datos.des3 }}</dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center"> 
                                    <div class="col-md-4">
                                        <label for="">NICK:</label>
                                        <input type="text" style=" background-color: rgba(182, 171, 171, 0.849); text-align: center;" class="form-control" disabled v-model="nick">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">PERMISOS:</label>
                                        <v-select
                                            label="name"
                                            :options="Aroles"
                                            v-model="rol"
                                        >
                                            //EN CASO QUE NO SE ENCENTRE EL VALOR EN LA LISTA
                                            <template v-slot:no-options="{ search, searching }">
                                            <template v-if="searching">
                                                Lo sentimos, no hay opciones de coincidencia.<em>{{
                                                search
                                                }}</em
                                                >.
                                            </template>
                                            <em v-else
                                                >Lo sentimos, no hay opciones de coincidencia.</em
                                            >
                                            </template>
                                        </v-select>

                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-md-12" for="">SECCION:</label>
                                        <select class="form-control col-md-12" v-model="seccion">
                                            <option value="1">OFICIALES</option>
                                            <option value="2">SUBOFICIALES Y SARGENTOS</option>
                                            <option value="3">PERSONAL CIVIL</option>
                                            <option value="4">TODOS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="CrearUsuario()">Crear Usuario</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Modal Editar Usuario -->
        <div class="modal fade" id="EditarUsuario">
            <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">{{Edatos.grado}} {{Edatos.complemento}} {{Edatos.nombre}} {{Edatos.paterno}} {{Edatos.materno}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <!-- llenado de informacion de Datos -->
                        <div class="row">
                            <!-- Foto del Personal -->
                            <div  class="col-md-2" style="vertical-align:middle;">
                                <img v-bind:src="'https://sipefab.fab.bo/img/personal/'+Edatos.foto" width="100%" height="100%">
                            </div>
                            <!-- Edatos personales -->
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <dl>
                                            <dt class="st">CARNET MILITAR</dt>
                                            <dd class="st">{{ Edatos.cm }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl>
                                            <dt class="st">CARNET DE IDENTIDAD</dt>
                                            <dd class="st">{{ Edatos.ci }} {{ Edatos.expedido }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-4">
                                        <dl>
                                            <dt class="st">SITUACION</dt>
                                            <dd class="st">{{ Edatos.situacion }}</dd>
                                        </dl>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <dl>
                                            <dt class="st">DESTINO:</dt>
                                            <dd class="st">{{ Edatos.des2 }} {{ Edatos.des3 }}</dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center"> 
                                    <div class="col-md-4">
                                        <label for="">NICK:</label>
                                        <input type="text" style=" background-color: rgba(182, 171, 171, 0.849); text-align: center;" class="form-control" disabled v-model="Edatos.nick">
                                    </div>
                                   <div class="col-md-4">
                                        <label class="col-md-12" for="">SECCION:</label>
                                        <select class="form-control col-md-12" v-model="eseccion">
                                            <option value="1">OFICIALES</option>
                                            <option value="2">SUBOFICIALES Y SARGENTOS</option>
                                            <option value="3">PERSONAL CIVIL</option>
                                            <option value="4">TODOS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" @click="EditarUsuario()">Editar Usuario</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->




        <!-- AGREGAR ROLES A UN USUARIO -->
        <div class="modal fade"  data-backdrop="static" id="AgregarRoles">
            <div class="modal-dialog modal-xs ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">ASIGNAR ROLES</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="row">                    
                        <div class="col-sm-12">
                            <label for="">ROLES:</label>
                            <v-select
                                label="name"
                                :options="Aroles"
                                v-model="role"
                            >
                                <template v-slot:no-options="{ search, searching }">
                                <template v-if="searching">
                                    Lo sentimos, no hay opciones de coincidencia.<em>{{
                                    search
                                    }}</em
                                    >.
                                </template>
                                <em v-else
                                    >Lo sentimos, no hay opciones de coincidencia.</em
                                >
                                </template>
                            </v-select>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary btn-block" @click="AgregarRol()">ASIGNAR ROL</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label for="">ROLES ASIGNADOS</label>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 25%" class="text-center">OPCIONES</th>
                                    <th style="width: 75%" class="text-center">ROL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="u in Usrol">
                                    <td class="text-center">
                                        <button  type="button" class="btn btn-danger btn-sm" @click="EliminarRol(u.name)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    <td class="text-center">{{u.name}} </td>
                                    
                                </tr>
                            </tbody>
                            
                        </table> 
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>










    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
    data() {
        return {
            /**
             * Variables
             */
            per: [],
            nick: '',
            password: null,
            Epassword: '',
            Eid: '',
            rol: '',
            idrol: '',
            /**
             * Array de personal
             */
            Apersonal: [],
            Ausuarios: [],
            Aroles: [],
            datos: [],
            Edatos: [],
            Erole: [],
            Erol: [],
            idErol:'',
            Aroles:[],
            role:[],
            Usrol:[],
            iduser: '',
            /**
            * Variables paginacion
            */
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            code: "",
            /**
             * BUSCADOR
             */

            buscar: '',
            setTiemoutBuscador: '',
            seccion: 1,
            eseccion: '',
        }
    },
    mounted() {
        this.ListarPersonal();
        this.ListarUsuarios(1);
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
        ListarPersonal(){
            let me = this;
            axios
            .get('/listPer')
            .then(function (response) {
                
                me.Apersonal = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });
        },
        ListarRoles(){
            let me = this;
            axios
            .get('/listarRoles')
            .then(function (response) {
                
                me.Aroles = response.data;
                me.Erole = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });
        },
        NuevoUsuarioModal(){
            try {
                if (this.per.id) {
                    let me = this;
                    me.ListarRoles();
                    axios
                    .post("/datPer", {
                        percodigo: me.per.id
                    })
                    .then(function (response) {
                        
                        me.datos = response.data;
                        me.nick = me.datos.nombre.substring(0,1)+ me.datos.paterno.substring(0,1)+ me.datos.materno.substring(0,1)+me.datos.percodigo+me.datos.cm.substring(0,3);
                        $('#NuevoUsuario').modal('show');
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                } else {
                    swal.fire(
                        "Error", //TITULO
                        "Debe seleccionar a un personal de la institucion.", //TEXTO DE MENSAJE
                        "error" // TIPO DE MODAL (success, warnning, error, info)
                    );
                }
                
            } catch (error) {
                swal.fire(
                    "Error", //TITULO
                    "Debe seleccionar a un personal de la institucion.", //TEXTO DE MENSAJE                    
                    "error" // TIPO DE MODAL (success, warnning, error, info)
                );
                
            }
            
            
        },
        CrearUsuario(){
            swal.fire({
                title: '¿Desea crear este usuario?', // TITULO 
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
                    .post("/crearUsuario", {
                        percodigo: me.datos.percodigo,
                        email:  me.datos.email,
                        nick: me.nick,
                        rol: me.rol.name,
                        des2: me.datos.des2,
                        des3: me.datos.des3,
                        nombre: me.datos.nombre,
                        paterno: me.datos.paterno,
                        materno: me.datos.materno,
                        seccion: me.seccion
                        
                    })
                    .then(function (response) {
                       
                       console.log(response);
                        swal.fire(
                            response.data.titulo, //TITULO
                            response.data.mensaje, //TEXTO DE MENSAJE
                            response.data.tipo // TIPO DE MODAL (success, warnning, error, info)
                        );
                        if (!response.data.code) {
                            $('#NuevoUsuario').modal('hide');
                            me.nick = '';
                            me.password = '';
                            me.ListarUsuarios(1);
                        } 
                        
                        
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                }else{
                     swal.fire(
                        "Informacion", //TITULO
                        "Solicitud cancelada.", //TEXTO DE MENSAJE
                        "info" // TIPO DE MODAL (success, warnning, error, info)
                    );
                }
            })

        },
        ModalRoles(id){
            this.RolesNoUsuario(id);
            this.RolesUsuario(id);
            this.iduser = id;
            $('#AgregarRoles').modal('show');

        },

        RolesNoUsuario(id){
            let me = this;
            axios
            .post("/listarol2", {
                per_cod: id
            })
            .then(function (response) {
                //Respuesta de la peticion
                console.log(response);
                me.Aroles = response.data;                

            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        },
        RolesUsuario(id){
            let me = this;
            
            axios
            .post("/listarolus", {
                per_cod: id
            })
            .then(function (response) {
                //Respuesta de la peticion
                console.log(response);
                me.Usrol = response.data;

            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        },
        EliminarRol(name){
            let me = this;
            axios
            .post("/quitarRol", {
                id: me.iduser,
                rol: name
            })
            .then(function (response) {
                swal.fire(
                    "Aceptado", //TITULO
                    "Se elimino correctamente el rol.", //TEXTO DE MENSAJE
                    "success" // TIPO DE MODAL (success, warning, error, info)
                );
                me.role = [];
                $('#AgregarRoles').modal('hide');       
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })    
        },
        AgregarRol(){
            let me = this;
            if (me.role == '') {
                swal.fire(
                    "Precaución", //TITULO
                    "Debe seleccionar un rol para agregar.", //TEXTO DE MENSAJE
                    "warning" // TIPO DE MODAL (success, warning, error, info)
                );

            }else{
                axios
                .post("/agregarRol", {
                    id: me.iduser,
                    rol: me.role.name
                })
                .then(function (response) {
                    swal.fire(
                        "Aceptado", //TITULO
                        "Se añadio correctamente el nuevo rol.", //TEXTO DE MENSAJE
                        "success" // TIPO DE MODAL (success, warning, error, info)
                    );
                    me.role = [];
                    $('#AgregarRoles').modal('hide');       
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })    
            }
            

        },
        cambiarPagina(page){
            let me = this;
            me.pagination.current_page = page;
            me.ListarUsuarios(page);
        },
        ListarUsuarios(page){
            let me = this;
            axios
            .post("/listarUsuarios", {
                buscar: me.buscar.toUpperCase(),
                page: page
            })
            .then(function (response) {
                
                me.Ausuarios = response.data.usuarios.data;
                me.pagination = response.data.pagination;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            
        },
        BuscarUsuario(){
            clearTimeout(this.setTiemoutBuscador);
            this.setTiemoutBuscador = setTimeout(() => {
                this.ListarUsuarios(1)
            }, 360)
        },
        EditarModal(id){
            let me = this;
            me.Eid = id;
            me.ListarRoles();
            axios
            .post("/datosUsuarios", {
                id: id
            })
            .then(function (response) {
                console.log(response);
                me.Edatos = response.data.usuarios;
                me.eseccion = response.data.usuarios.seccion;
                me.Erol = response.data.role.name
                me.namErol = response.data.role.name;
                $('#EditarUsuario').modal('show');
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        },
        EditarUsuario(){
            if (this.Erol.name) {
                var role = this.Erol.name;
            } else {
                var role = this.namErol;
            }
            swal.fire({
                title: '¿Desea editar este usuario?', // TITULO 
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
                    .put("/editarUsuarios", {
                        id: me.Eid,
                        seccion: me.eseccion
                    })
                    .then(function (response) {
                        
                        $('#EditarUsuario').modal('hide');
                        me.ListarUsuarios(1);
                        me.Eid = '';
                        me.Epassword = '';
                        me.eseccion = '';
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })                    
                }else{
                     swal.fire(
                        "Informacion", //TITULO
                        "Solicitud cancelada.", //TEXTO DE MENSAJE
                        "info" // TIPO DE MODAL (success, warnning, error, info)
                    );
                }
            })
        },
        CambioEstado(estado, id){
            if (estado == 1) {
                var titulo = '¿Desea deshabilitar este usuario?';
                var titulo2 = 'Usuario deshabilitado correctamente';
            } else {
                var titulo = '¿Desea habilitar este usuario?';
                var titulo2 = 'Usuario habilitado correctamente';
            }
            swal.fire({
                title: titulo, // TITULO 
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
                    .put("/cambiarEstadoUsuario", {
                        id: id,
                        estado: estado,
                    })
                    .then(function (response) {
                        
                        console.log(response);
                        me.ListarUsuarios(1);
                        swal.fire(
                            "Informacion", //TITULO
                            titulo2, //TEXTO DE MENSAJE
                            "info" // TIPO DE MODAL (success, warnning, error, info)
                        );
                        
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })                    
                }else{
                     swal.fire(
                        "Informacion", //TITULO
                        "Solicitud cancelada.", //TEXTO DE MENSAJE
                        "info" // TIPO DE MODAL (success, warnning, error, info)
                    );
                }
            })
        }
    },
};
</script>

<style>
.stlabel {
  font-size: 20px;
}

@media (min-width: 992px) {
  .modal-lg {
    max-width: 40%;
  }
  .modal-lg2 {
    max-width: 50%;
  }
}
</style>
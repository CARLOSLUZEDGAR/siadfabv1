<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">    
                <div class="row">
                  <h1>
                        <i class="far fa-bookmark"></i>
                        DATOS DE USUARIO
                    </h1>&nbsp;                  
                 </div>              
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Datos Usuario</li>
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
                    
                    <!-- card 2 Muestra Datos Personales -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            {{ datos.grado }} {{ datos.complemento }} {{ datos.nombre }} {{ datos.paterno }} {{ datos.materno }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    
                                    <img :src="'/img/personal/'+datos.foto" width="100%" height="100%" class="rounded float-left img-fluid">
                                </div>
                                
                                <div class="col-md-10 d-flex align-items-center">
                                    <div style="" class="col-md-12 d-flex flex-column bd-highlight mb-3">
                                        <!-- FILA 1 -->
                                        <div class="row p-2 bd-highlight">
                                            <div class="col-md-4">
                                                <dl>
                                                    <dt class="st">Carnet de Identidad</dt>
                                                    <dd class="st">{{ datos.ci }} {{ datos.expedido }}</dd>
                                                </dl>
                                            </div>
                                            <div class="col-md-4">
                                                <dl>
                                                    <dt class="st">Carnet Militar</dt>
                                                    <dd class="st">{{ datos.cm }}</dd>
                                                </dl>
                                            </div>                                                                                      
                                            <div class="col-md-4">
                                                <dl>
                                                    <dt class="st">Situacion Militar Actual</dt>
                                                    <dd class="st">{{datos.situacion}}</dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <!-- FILA 2 -->
                                        <div class="row p-2 bd-highlight">  
                                            <div class="col-md-12">
                                                <dl>
                                                    <dt class="st">Destino Actual</dt>
                                                    <dd class="st">{{ datos.des2 }} - {{ datos.des3 }}</dd>
                                                </dl>
                                            </div>

                                        </div>
                                        <!-- FILA 3 -->
                                        <div class="row p-2 bd-highlight">  
                                            <div class="col-md-6">
                                                <dl>
                                                    <dt class="st">Email</dt>
                                                    <dd class="st">{{ datos.email }}</dd>
                                                </dl>
                                            </div>                                          
                                            <div class="col-md-4">
                                                <dl>
                                                    <dt class="st">Nick</dt>
                                                    <dd class="st">{{datos.nick}}</dd>
                                                </dl>
                                            </div>


                                        </div>
                                        <!-- FILA 4 -->
                                        <div class="row p-2 bd-highlight justify-content-center">
                                            <div class="col-md-4">                                            
                                                    <input type="text" :class="{ 'is-invalid' : $v.contrasenaA.$error, 'is-valid':!$v.contrasenaA.$invalid }"  v-model="contrasenaA" placeholder="Ingrese antigua contraseña" class="form-control">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.contrasenaA.required">Este campo es Requerido</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                            
                                                    <input type="text" :class="{ 'is-invalid' : $v.contrasena.$error, 'is-valid':!$v.contrasena.$invalid }"  v-model="contrasena" placeholder="Ingrese nueva contraseña" class="form-control">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.contrasena.required">Este campo es Requerido</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">  
                                                    <button type="button" @click="EditarContraseña()" class="btn btn-sm btn-warning btn-block">
                                                    <i class="fas fa-edit"></i>&nbsp;Actualizar Contraseña
                                                    </button>
                                                </div>
                                            
                                        </div>
                                        

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
        </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";
export default {
    data() {
        return {
            datos: [],
            contrasena: '',
            contrasenaA: ''
        }
    },
    validations:{
        contrasena: {required},
        contrasenaA : { required }
    },
    mounted() {
        this.DatosUsuario();
    },
    methods: {
        DatosUsuario(){
            let me = this;
            axios
            .get('/datosUsuario')
            .then(function (response) {
                me.datos = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });

        },
        EditarContraseña(){            
            this.$v.$reset();
            if(!this.$v.$invalid){
                swal.fire({
                    title: '¿Desea cambiar la contraseña?', // TITULO 
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
                        .post("/editContrasena", {
                            contrasena: me.contrasena,
                            contrasenaA : me.contrasenaA
                        })
                        .then(function (response) {
                            if (response.data === 200 ) {
                                swal.fire(
                                    "Aceptado", //TITULO
                                    "Contraseña actualizada.", //TEXTO DE MENSAJE
                                    "success" // TIPO DE MODAL (success, warnning, error, info)
                                );
                                setTimeout(function(){                                
                                    location.reload();
                                }, 2000);
                            } else {
                                swal.fire(
                                    "Error", //TITULO
                                    "Contraseña Antigua Invalida.", //TEXTO DE MENSAJE
                                    "error" // TIPO DE MODAL (success, warnning, error, info)
                                );
                            }

                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })

                    }else{
                        swal.fire(
                            "Cancelado", //TITULO
                            "Actualizacion cancelada.", //TEXTO DE MENSAJE
                            "warning" // TIPO DE MODAL (success, warnning, error, info)
                        );

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
        }
    },
};
</script>

<style>
.dat {
    width: 100%;
  }

</style>
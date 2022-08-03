<template>
  <div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">            
                    <h1>
                        <i class="far fa-bookmark"></i>
                        Datos del Personal
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Datos del Personal</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5><i class="fas fa-edit"></i>Editar Datos Personales</h5>
                            <button type="button" class="btn btn-danger btn-sm position-reverse float-sm-right" style="margin-top:-37px" @click="Atras(per_codigo)">
                                <i class="fas fa-reply"></i>&nbsp; Volver Atrás
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group row border justify-content-center" style="border-color: #007bff !important;">
                                <div class="card-body col-md-12" style="font-size: 14px;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="row">
                                                <template v-if="v == 0">
                                                    <img class="rounded float-left img-fluid" width="100%" height="100%" :src="'/img/personal/'+imagen" alt="Fotografia">
                                                    <!-- <img :src="'/img/personal/avatar.jpg'" width="100%" height="100%"> -->
                                                </template>
                                                <template v-else>
                                                    <!-- <img :src="imagen" width="100%" height="100%"> -->
                                                    <img class="rounded float-left img-fluid" :src="imagen" width="100%" height="100%" alt="Fotografia">
                                                </template>
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row" style="margin-top: 15px;">
                                                <div class="col-md-4">
                                                    <label for="nombre">NOMBRE:</label>
                                                    <input type="text" @keypress="alphanumeric" v-model="nombre" class="form-control" style="text-transform:uppercase;" :class="{ 'is-invalid' : $v.nombre.$error, 'is-valid':!$v.nombre.$invalid }">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.nombre.required">Este campo es Requerido</span>
                                                        <span v-if="!$v.nombre.maxLength">Este campo permite solo 20 caracteres.</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="paterno">APELLIDO PATERNO:</label>
                                                    <input type="text" @keypress="alphanumeric" class="form-control" v-model="paterno" style="text-transform:uppercase;" >

                                                </div>
                                                <div class="col-md-4">
                                                    <label for="materno">APELLIDO MATERNO:</label>
                                                    <input type="text" @keypress="alphanumeric" class="form-control" v-model="materno" style="text-transform:uppercase;" >

                                                </div> 
                                            </div> 
                                            <div class="row" style="margin-top: 5px;">
                                                <div class="col-md-4">
                                                    <label>CARNET MILITAR</label>
                                                    <input type="text"  @keypress="alphanumeric" class="form-control" v-model="cm" style="text-transform:uppercase;" :class="{ 'is-invalid' : $v.cm.$error, 'is-valid':!$v.cm.$invalid }">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.cm.required">Este campo es Requerido</span>
                                                        <span v-if="!$v.cm.maxLength">Demaciados caracteres, maximo 10 caracteres</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <label for="carnetIdentidad">CARNET DE IDENTIDAD:</label>
                                                    <input type="text"  @keypress="alphanumeric" class="form-control" v-model="ci" style="text-transform:uppercase;" :class="{ 'is-invalid' : $v.ci.$error, 'is-valid':!$v.ci.$invalid }">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.ci.required">Este campo es Requerido</span>
                                                        <span v-if="!$v.ci.maxLength">Demaciados caracteres, maximo 10 caracteres</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>Exp.</label>
                                                    <select class="form-control" v-model="expedido">
                                                        <option value=""></option>
                                                        <option value="LP">LP</option>
                                                        <option value="SC">SC</option>
                                                        <option value="CH">CH</option>
                                                        <option value="BN">BN</option>
                                                        <option value="OR">OR</option>
                                                        <option value="CB">CB</option>
                                                        <option value="PN">PN</option>
                                                        <option value="PT">PT</option>
                                                        <option value="TJ">TJ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label>GENERO</label>
                                                    <select class="form-control" v-model="genero" :class="{ 'is-invalid' : $v.genero.$error, 'is-valid':!$v.genero.$invalid }">
                                                        <option value="FEMENINO">FEMENINO</option>
                                                        <option value="MASCULINO">MASCULINO</option>                            
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.nombre.required">Este campo es Requerido</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="estadoCivil">ESTADO CIVIL:</label>
                                                    <select class="form-control" v-model="estadoCivil" :class="{ 'is-invalid' : $v.estadoCivil.$error, 'is-valid':!$v.estadoCivil.$invalid }">
                                                        <option value="CASADO">CASADO(A)</option>
                                                        <option value="DIVORCIADO">DIVORCIADO(A)</option>
                                                        <option value="SOLTERO">SOLTERO(A)</option>
                                                        <option value="VIUDO">VIUDO(A)</option>
                                                    </select> 
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.estadoCivil.required">Este campo es Requerido</span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 5px;">
                                                <div class="col-md-4">
                                                    <label for="per_boleta_pago">CÓDIGO BOLETA DE PAGO:</label>
                                                    <input type="text" @keypress="onlyNumber" class="form-control" v-model="per_boleta_pago" :class="{ 'is-invalid' : $v.per_boleta_pago.$error, 'is-valid':!$v.per_boleta_pago.$invalid }">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.per_boleta_pago.required">Este campo es Requerido</span>
                                                        <span v-if="!$v.per_boleta_pago.maxLength">Demaciados caracteres, maximo 8 caracteres</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="email">CORREO INSTITUCIONAL:</label>
                                                    <input type="email" class="form-control" v-model="email" :class="{ 'is-invalid' : $v.email.$error, 'is-valid':!$v.email.$invalid }">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.email.required">Este campo es Requerido</span>
                                                        <span v-if="!$v.email.email">Ingrese un email correcto</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="celular">CELULAR:</label>
                                                    <input type="text" @keypress="onlyNumber" class="form-control" v-model="celular" :class="{ 'is-invalid' : $v.celular.$error, 'is-valid':!$v.celular.$invalid }">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.celular.required">Este campo es Requerido</span>
                                                        <span v-if="!$v.celular.maxLength">Demaciados caracteres, maximo 8 caracteres</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="telefono">TELEFONO:</label>
                                                    <input type="text" @keypress="onlyNumber" class="form-control" v-model="telefono" :class="{ 'is-invalid' : $v.telefono.$error, 'is-valid':!$v.telefono.$invalid }">
                                                    <div class="invalid-feedback">
                                                        <span v-if="!$v.telefono.maxLength">Demaciados caracteres, maximo 7 caracteres</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        
                                        <div class="col-md-3">
                                            <label for="celular">FOTO:</label>
                                            <input type="file" class="form-control" @change="obtenerImagen" accept="image/*" :class="{ 'is-invalid' : $v.obtenerImagen.$error, 'is-valid':!$v.obtenerImagen.$invalid }">
                                            <div class="invalid-feedback">
                                                <span v-if="!$v.obtenerImagen.required">Este campo es Requerido</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="seguro">CARNET SEGURO:</label>
                                            <input type="text" @keypress="alphanumeric" class="form-control" style="text-transform:uppercase;" v-model="seguro" :class="{ 'is-invalid' : $v.seguro.$error, 'is-valid':!$v.seguro.$invalid }">
                                            <div class="invalid-feedback">
                                                <span v-if="!$v.seguro.required">Este campo es Requerido</span>
                                                <span v-if="!$v.seguro.maxLength">Demaciados caracteres, maximo 12 caracteres</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="servMil">LIBRETA SERVICIO MILITAR:</label>
                                            <input type="text" @keypress="alphanumeric" class="form-control" style="text-transform:uppercase;" v-model="servMil" :class="{ 'is-invalid' : $v.servMil.$error, 'is-valid':!$v.servMil.$invalid }">
                                            <div class="invalid-feedback">
                                                <span v-if="!$v.servMil.maxLength">Demaciados caracteres, maximo 15 caracteres</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>RELIGION</label>
                                            <select class="form-control" v-model="religion" :class="{ 'is-invalid' : $v.religion.$error, 'is-valid':!$v.religion.$invalid }">
                                                <option value="ADVENTISTA">ADVENTISTA</option>
                                                <option value="CATOLICA">CATÓLICA</option>
                                                <option value="CRISTIANA">CRISTIANA</option>
                                                <option value="JUDIA">JUDÍA</option>
                                                <option value="MORMON">MORMÓN</option>
                                                <option value="TJ">TESTIGOS DE JEHOVÁ</option>
                                                <option value="OTRA">OTRA</option>                                        
                                            </select>
                                            <div class="invalid-feedback">
                                                <span v-if="!$v.religion.required">Este campo es Requerido</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="col-md-12">
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">DATOS DE NACIMIENTO</legend>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="fechaNacimiento">FECHA:</label>
                                                        <input type="date" class="form-control" min="01/01/2021" v-model="fechaNacimiento" :class="{ 'is-invalid' : $v.fechaNacimiento.$error, 'is-valid':!$v.fechaNacimiento.$invalid }">
                                                        <div class="invalid-feedback">
                                                            <span v-if="!$v.fechaNacimiento.required">Este campo es Requerido</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label for="carnetIdentidad">LUGAR:</label>
                                                        <div class="row">
                                                            <div class="col-md-4" style="margin-top: 5px;">
                                                                <v-select
                                                                    label="nombre"
                                                                    :options="Adepartamento"
                                                                    v-model="departamentoC"
                                                                    @input="Provincia"
                                                                    placeholder="DEPARTAMENTO"
                                                                    :class="{ 'is-invalid' : $v.departamentoC.$error, 'is-valid':!$v.departamentoC.$invalid }"
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
                                                                <div class="invalid-feedback">
                                                                    <span v-if="!$v.departamentoC.required">Debe seleccionar un valor</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-top: 5px;">
                                                                <v-select
                                                                    label="nombre"
                                                                    :options="Aprovincia"
                                                                    v-model="provincia"
                                                                    @input="Localidad"
                                                                    placeholder="PROVINCIA"
                                                                    :class="{ 'is-invalid' : $v.provincia.$error, 'is-valid':!$v.provincia.$invalid }"
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
                                                                <div class="invalid-feedback">
                                                                    <span v-if="!$v.provincia.required">Debe seleccionar un valor</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-top: 5px;">
                                                                <v-select
                                                                    label="nombre"
                                                                    :options="Alocalidad"
                                                                    v-model="localidad"
                                                                    placeholder="LOCALIDAD"
                                                                    :class="{ 'is-invalid' : $v.localidad.$error, 'is-valid':!$v.localidad.$invalid }"
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
                                                                <div class="invalid-feedback">
                                                                    <span v-if="!$v.localidad.required">Debe seleccionar un valor</span>
                                                                </div>
                                                            </div>
                                                        </div>              
                                                    </div>
                                                </div>                        
                                            </fieldset> 
                                        </div>
                                            
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">DIRECCION</legend>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="fechaNacimiento">CIUDAD:</label>
                                                        <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="per_ciudad" :class="{ 'is-invalid' : $v.per_ciudad.$error, 'is-valid':!$v.per_ciudad.$invalid }"></textarea>
                                                        <div class="invalid-feedback">
                                                            <span v-if="!$v.per_ciudad.required">Este campo es Requerido</span>
                                                            <span v-if="!$v.per_ciudad.maxLength">Demaciados caracteres, maximo 300 caracteres.</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <label for="fechaNacimiento">ZONA:</label>
                                                        <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="per_zona" :class="{ 'is-invalid' : $v.per_zona.$error, 'is-valid':!$v.per_zona.$invalid }"></textarea>
                                                        <div class="invalid-feedback">
                                                            <span v-if="!$v.per_zona.required">Este campo es Requerido</span>
                                                            <span v-if="!$v.per_zona.maxLength">Demaciados caracteres, maximo 300 caracteres.</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-5">
                                                        <label for="fechaNacimiento">CALLE/AVENIDA/NRO.:</label>
                                                        <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="per_calle" :class="{ 'is-invalid' : $v.per_calle.$error, 'is-valid':!$v.per_calle.$invalid }"></textarea>
                                                        <div class="invalid-feedback">
                                                            <span v-if="!$v.per_ciudad.required">Este campo es Requerido</span>
                                                            <span v-if="!$v.per_ciudad.maxLength">Demaciados caracteres, maximo 300 caracteres.</span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </fieldset>    
                                        </div> 
                                    </div> 

                                    <div class="col-md-12"><!--btn-->
                                            <div class="form-group">
                                                <div style="text-align: center;">
                                                    <button type="submit" @click="actualizarDatosPersonal()" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>&nbsp; Actualizar Datos Personales</button>
                                                    <button class="btn btn-danger btn-sm" @click="Atras(per_codigo)" ><i class="far fa-window-close"></i>&nbsp; Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </div>
</template>

<script>

import {FormWizard, TabContent, ValidationHelper} from 'vue-step-wizard'
import { required, maxLength, email } from 'vuelidate/lib/validators'
export default {

    data(){
        const today = new Date();
        return {
            //VARIABLES DE FORMULARIO

            percod: this.$route.params.codigo, 
            per_codigo: this.$route.params.codigo,
            datos:[],

            //localidad
                departamentoC:[],
                provincia:'',
                localidad:'',
                iddepa_cod : "",
                idprov_cod : "",
                idloca_cod : "",

                v : 0,
                nombre:'',
            
                /***
                 * TAB 1
                 */
                paterno:'',
                materno:'',
                genero:'',
                ci:'',
                cm:'',
                per_boleta_pago : '',
                expedido:'',
                estadoCivil:'',
                telefono:'',
                celular:'',
                email:'',
                foto: '',
                carnetSeguro:'',
                libreta:'',
                seguro:'',
                servMil:'',
                per_ciudad: '',
                per_zona : '',
                per_ciudad : '',
                per_calle : '',
                libreta:'',
                religion:'',
                fechaNacimiento: new Date(today.getTime() - 5842 * 24 * 3600 * 1000),
                
                //direccion
                ciudad:'',
                zona:'',
                calle:'',    
                /**
                 * TAB 2
                 */
                //situacion
                situacion:'',
                subsituacion:'',
                detalleSituacion:'',
                //escalafon
                escalafon:'',
                subescalafon:'',
                grado:'',
                //documento
                sitTipoDocumento:'',
                sitFechaDocumento: new Date(today.getTime()),
                sitNroDocumento:'',
                cm:'',
                sitObser:'',

                /**
                 * TAB 3
                 */
                //estudios
                estudios:'',
                //especialidad
                especialidad: '',
                subespecialidad: '',
                //documento
                comFechaDocumento: new Date(today.getTime()),
                comDocumento:'',
                comNroDocumento:'',
                comObser:'',
            
            
            complemento: '',    
            
            /**
             * variables de imagen
             */
            v: 0,
            fotoMin: '',

            //VARIABLE DE ARRAYS DE RECUPERACION
            //Escalafon
            Aescalafon:[],
            Asubescalafon:[],
            Agrado:[],
            //Situacion
            Asituacion:[],
            Asubsituacion:[],
            AdetalleSituacion:[],
            //Localidad
            Adepartamento:[],
            Aprovincia:[],
            Alocalidad:[],
            //Estudios
            Aestudios:[],
            //Especialidad
            Aespecialidad: [],
            Asubespecialidad: [],

        }
    },

    validations:{ 
        nombre: { required, maxLength: maxLength (20)},
        genero: { required },
        cm: { required, maxLength: maxLength (10) },
        ci: { required, maxLength: maxLength (10) },
        estadoCivil: { required },
        per_boleta_pago : { required, maxLength: maxLength (8) },
        telefono: { maxLength: maxLength (7) },
        celular: { required,maxLength: maxLength (8)  },
        email: { required, email}, 
        obtenerImagen: {required},
        seguro: { required, maxLength: maxLength (12) }, 
        servMil: { maxLength: maxLength (15) },
        religion: { required },   
        fechaNacimiento: { required },
        //localidad
        departamentoC: { required },
        provincia: { required },
        localidad: { required },
        //direccion
        per_ciudad: { required, maxLength: maxLength (300) },
        per_zona: { required, maxLength: maxLength (300) },
        per_calle: { required, maxLength: maxLength (300) },

        validationGroupEdit: ['nombre','genero', 'ci', 'estadoCivil', 'telefono', 'celular', 'cm', 
        'email', 'obtenerImagen', 'seguro', 'religion', 'fechaNacimiento', 'per_boleta_pago',
        'departamentoC', 'provincia', 'localidad', 'per_ciudad', 'per_zona', 'per_calle','servMil'],

    },
                
            

    mounted() {
        this.verDatos(this.per_codigo);



        this.Escalafon();
        this.Estudios();
        this.Situacion();
        this.Departamento();
        this.Especialidad()
    },
    computed:{
        mostrarCom(){
            try {
                this.complemento = this.formData.estudios.abreviatura
            } catch (error) {
                this.complemento = ''
            }
            
        },
        imagen(){
            return this.datos.per_foto;
        }
    },
    methods: {
        verDatos(per_codigo){
            let me = this;
            axios
            .post("/verDatosPersonales", {
                per_codigo: per_codigo
            })
            .then(function (response) {
                me.datos = response.data.datos
                me.nombre = response.data.datos.nombre;
                me.paterno = response.data.datos.paterno;
                me.materno = response.data.datos.materno;
                me.genero = response.data.datos.genero;
                me.cm = response.data.datos.cm;
                me.ci = response.data.datos.ci;
                me.expedido = response.data.datos.expedido;
                me.estadoCivil = response.data.datos.estadoCivil;
                me.telefono = response.data.datos.telefono;
                me.celular = response.data.datos.celular;
                me.email = response.data.datos.email;
                me.foto = response.data.datos.foto;
                me.per_boleta_pago = response.data.datos.per_boleta_pago;
                me.seguro = response.data.datos.seguro;
                me.servMil = response.data.datos.servMil;
                me.religion = response.data.datos.religion;
                me.fechaNacimiento = response.data.datos.fechaNacimiento;
                me.per_ciudad = response.data.datos.per_ciudad;
                me.per_zona = response.data.datos.per_zona;
                me.per_calle = response.data.datos.per_calle;

                me.iddepa_cod = response.data.datos.depa_codigo;
                me.idprov_cod = response.data.datos.prov_codigo;
                me.idloca_cod = response.data.datos.loca_codigo;
                me.BuscarDepartamento(me.iddepa_cod);
                me.BuscarProvincia(me.idprov_cod);
                me.BuscarLocalidad(me.idloca_cod);
                me.Departamento();
            })    
            .catch(function (error) {
                console.log(error);
            })
            
        },

        BuscarDepartamento(iddepa_cod){
            let me = this;
            axios
            .post("/departamento/selectbuscarDepartamento", {
                buscar: iddepa_cod
            })
            .then(function (response) {
                me.departamento = response.data.departamento
                me.departamentoC = me.departamento[0]['nombre'];
            })    
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            
        },

        BuscarProvincia(prov_codigo){
            let me = this;
            axios
            .post("/provincia/selectbuscarProv", {
                buscar: prov_codigo
            })
            .then(function (response) {
                me.provincia = response.data.provincia
                me.provincia = me.provincia[0]['nombre'];
            })    
            .catch(function (error) {
                console.log(error);
            })
            
        },

        BuscarLocalidad(loca_codigo){
            let me = this;
            axios
            .post("/localidad/selectbuscarLoca", {
                buscar: loca_codigo
            })
            .then(function (response) {
                me.localidad = response.data.localidad
                me.nombreloca = me.localidad[0]['nombre'];
            })    
            .catch(function (error) {
                console.log(error);
            })
            
        },

        obtenerImagen(e){
            try {
                var fileReader = new FileReader();

                fileReader.onload = (e) => {
                    this.datos.per_foto = e.target.result;
                }
                fileReader.readAsDataURL(e.target.files[0])
                this.v = 1;
            } catch (error) {
                
            }
        },

        actualizarDatosPersonal(){
            this.$v.$reset()
            if (!this.$v.validationGroupEdit.$invalid) {
                swal.fire({
                    title: '¿Desea realizar la modificación del Personal ?', // TITULO 
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
                            if (me.departamentoC.id) {
                                var depa_cod = me.departamentoC.id;
                            } else {
                                var depa_cod =  me.iddepa_cod;
                            }
                            if (me.provincia.id) {
                                var prov_cod = me.provincia.id;
                            } else {
                                var prov_cod =  me.idprov_cod;
                            }
                            if (me.localidad.id) {
                                var loca_cod = me.localidad.id;
                            } else {
                                var loca_cod =  me.idloca_cod;
                            }
                            if(me.paterno!==null){
                                me.paterno = me.paterno.toUpperCase();
                            }
                            if(me.materno!==null){
                                me.materno = me.materno.toUpperCase();
                            }
                            if(me.servMil!==null){
                                me.servMil = me.servMil.toUpperCase();
                            }

                            axios
                            .put("/editarDatosPersonales", {
                                celular : me.celular,
                                ci : me.ci,
                                cm : me.cm,
                                codigo : this.datos.codigo,
                                depa_codigo : depa_cod,
                                email : me.email,
                                estadoCivil : me.estadoCivil,
                                expedido : me.expedido,
                                fechaNacimiento : me.fechaNacimiento,
                                genero : me.genero,
                                loca_codigo : loca_cod,
                                nombre : me.nombre.toUpperCase(),
                                paterno : me.paterno,
                                materno : me.materno,
                                per_boleta_pago : me.per_boleta_pago,
                                per_calle : me.per_calle.toUpperCase(),
                                per_ciudad : me.per_ciudad.toUpperCase(),
                                per_foto : this.datos.per_foto,
                                per_zona : me.per_zona.toUpperCase(),
                                prov_codigo : prov_cod,
                                religion : me.religion,
                                seguro : me.seguro.toUpperCase(),
                                servMil : me.servMil,
                                telefono : me.telefono,

                            })
                            .then(function (response) {
                                
                                
                                swal.fire(
                                    "Aceptado", //TITULO
                                    "Se modificó correctamente los Datos Personales.", //TEXTO DE MENSAJE
                                    "success" // TIPO DE MODAL (success, warnning, error, info)
                                )
                                me.Atras(me.per_codigo);
                                
                            })
                            .catch(function (error) {
                            // handle error
                            console.log(error);
                        })   
                    }else{
                        swal.fire(
                        "Anulado", //TITULO
                        "No se realizo la actualización de los Datos Personales.", //TEXTO DE MENSAJE
                        "info" // TIPO DE MODAL (success, warnning, error, info)
                        )
                    }
                })
            } else {
            this.$v.$touch();
                Swal.fire({
                    icon: 'warning',
                    title: 'Ingrese todos los datos requeridos',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        },

        efecha1(date) {
            const today = new Date();
            console.log(today);
            today.setHours(0, 0, 0, 0);
            return  date > new Date(today.getTime() - 5842 * 24 * 3600 * 1000);
        },

        fechaactual(date){
            const today = new Date();
            console.log(today);
            today.setHours(0, 0, 0, 0);
            return  date > new Date(today.getTime());
        },
   
        Escalafon(){
            let me = this;
            axios
            .get('/escalafonesCombo')
            .then(function (response) {
                
                me.Aescalafon = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });

        },
        SubEscalafon(){
            try {
                let me = this;
                me.formData.subescalafon = '';
                me.formData.grado = '';
                axios
                .post("/subescalafonesCombo", {
                    escalafon: me.formData.escalafon.id
                })
                .then(function (response) {
                    
                    me.Asubescalafon = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Asubescalafon = [];
                this.Agrado = [];
            }
        },

        Grado(){
            try {
                let me = this;
                me.formData.grado = '';
                axios
                .post("/gradosCombo", {
                    subescalafon: me.formData.subescalafon.id
                })
                .then(function (response) {
                    
                    me.Agrado = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Agrado = [];
            }
        },
        Estudios(){
            let me = this;
            axios
            .get('/estudiosCombo')
            .then(function (response) {
                
                me.Aestudios = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });

        },
        Situacion(){
            let me = this;
            axios
            .get('/situacionesCombo')
            .then(function (response) {
                
                me.Asituacion = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });

        },
        SubSituacion(){
            try {
                let me = this;
                me.formData.subsituacion = '';
                me.formData.detalleSituacion = '';
                axios
                .post("/subsituacionesCombo", {
                    situacion: me.formData.situacion.id
                })
                .then(function (response) {
                    
                    me.Asubsituacion = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Asubsituacion = [];
                this.AdetalleSituacion = [];
            }
        },
        DetalleSituacion(){
            try {
                let me = this;
                me.formData.detalleSituacion = '';
                axios
                .post("/detallesituacionesCombo", {
                    subsituacion: me.formData.subsituacion.id
                })
                .then(function (response) {
                    
                    me.AdetalleSituacion = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.AdetalleSituacion = [];
            }
        },
        Departamento(){
            let me = this;
            axios
            .get('/departamentosCombo')
            .then(function (response) {
                
                me.Adepartamento = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });

        },
        Provincia(){
            try {
                let me = this;
                me.localidad = '';
                me.provincia = '';
                axios
                .post("/provinciasCombo", {
                    departamento: me.departamentoC.id
                })
                .then(function (response) {
                    
                    me.Aprovincia = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Aprovincia = [];
                this.Alocalidad = [];
            }
        },
        Localidad(){
            try {
                let me = this;
                me.localidad = '';
                axios
                .post("/localidadesCombo", {
                    provincia: me.provincia.id
                })
                .then(function (response) {
                    
                    me.Alocalidad = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Alocalidad = [];
            }
        },
        Registrar(){
            swal.fire({
                title: '¿Seguro de registrar el nuevo Personal?', // TITULO 
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
                    .post("/registrarPersonal", {                        
                        data: me.formData,
                    })
                    .then(function (response) {
                        
                        swal.fire(
                            "Aceptado", //TITULO
                            "Se añadio correctamente el nuevo Personal.", //TEXTO DE MENSAJE
                            "success" // TIPO DE MODAL (success, warnning, error, info)
                        );
                        me.atras();

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
        
        Especialidad(){
            let me = this;
            axios
            .get('/especialidadesCombo')
            .then(function (response) {
                // 
                me.Aespecialidad = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });

        },
        Subespecialidad(){
            try {
                let me = this;
                me.formData.subespecialidad = '';
                axios
                .post("/subespecialidadesCombo", {
                    id: me.formData.especialidad.id
                })
                .then(function (response) {
                    
                    me.Asubespecialidad = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Asubespecialidad = [];
            }
        },
        atras(){
            this.$router.push({
                name: "DatosPersonal",
            });
        },

        /**
         * validaciones de campos
         */
        onlyNumber ($event) { //SOLO NUMEROS
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
                $event.preventDefault();
            }
        },
        alphanumeric ($event) { //NUMEROS Y LETRAS
            // console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122) && (keyCode < 48 || keyCode > 57)  && keyCode !== 209 && keyCode !== 241 && keyCode !== 32 && keyCode !== 45) { // 46 is dot
                $event.preventDefault();
            }
        },
        onlyletters ($event) { //SOLO letras
            console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122) &&  keyCode !== 209 && keyCode !== 241 && keyCode !== 32) { // 46 is dot
                $event.preventDefault();
            }
        },
        numDoc ($event) { //SOLO NUMEROS y "/"
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 47) { // 46 is dot
                $event.preventDefault();
            }
        },

        Atras(datos){
            this.$router.push({
                name: "Personal_datos",
                //ENVIO DE DATOS
                params:{
                    e: datos
                }
                
            });
        },
    },



}
</script>

<style>
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1.2em !important;
    font-weight: bold !important;
    text-align: left !important;
    width:auto;
    padding:0 5px;
    border-bottom:none;
}

.separador {
    border-left: 1px #000 solid;
    padding-left: 15px;
}
.dat {
    max-width: 100%;
  }
</style>
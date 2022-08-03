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
                        REGISTRO NUEVO PERSONAL
                    </h1>&nbsp; &nbsp;
                    <button class="btn btn-sm btn-danger" @click="atras()">
                        <i class="fas fa-undo"></i> &nbsp;
                        CANCELAR
                    </button>
                </div>                 
            
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Modals & Alerts</li>
            </ol>
          </div> -->
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <div>
        
    </div>

    <form-wizard @onComplete="Registrar()">
        <!-- PASO 1 -->
        <!-- <fieldset class="scheduler-border">
            <legend class="scheduler-border">DATOS SANCIONADO</legend>
            
        </fieldset> -->
        <tab-content title="DATOS PERSONALES" :selected="true">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-2">
                        <div class="row">
                            <template v-if="v == 0">
                                <img :src="'/img/personal/avatar.jpg'" width="100%" height="100%">
                            </template>
                            <template v-else>
                                <img :src="imagen" width="100%" height="100%">
                            </template>
                            
                        </div>                       
                    </div>
                    <div class="col-md-10">
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-4">
                                <label for="nombre">NOMBRE:</label>
                                <input type="text" @keypress="alphanumeric" class="form-control" style="text-transform:uppercase;" v-model="formData.nombre" :class="hasError('nombre') ? 'is-invalid' : ''">
                                <div v-if="hasError('nombre')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.nombre.required">Ingrese valor porfavor.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="paterno">APELLIDO PATERNO:</label>
                                <input type="text" @keypress="alphanumeric" class="form-control" v-model="formData.paterno" style="text-transform:uppercase;" >
                            </div>
                            <div class="col-md-4">
                                <label for="materno">APELLIDO MATERNO:</label>
                                <input type="text" @keypress="alphanumeric" class="form-control" v-model="formData.materno" style="text-transform:uppercase;" >
                            </div> 
                        </div> 
                        <div class="row" style="margin-top: 5px;">
                            <div class="col-md-3">
                                <label>GENERO</label>
                                <select class="form-control" v-model="formData.genero" :class="hasError('genero') ? 'is-invalid' : ''">
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="MASCULINO">MASCULINO</option>                            
                                </select>
                                <div v-if="hasError('genero')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.genero.required">Ingrese valor porfavor.</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="carnetIdentidad">CARNET DE IDENTIDAD:</label>
                                <input type="text"  @keypress="alphanumeric" class="form-control" v-model="formData.ci" style="text-transform:uppercase;" :class="hasError('ci') ? 'is-invalid' : ''">
                                <div v-if="hasError('ci')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.ci.required">Ingrese valor porfavor.</div>
                                    <div class="error" v-if="!$v.formData.ci.maxLength">Demaciados caracteres, maximo 10 caracteres.</div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>Exp.</label>
                                <select class="form-control" v-model="formData.expedido">
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
                            <div class="col-md-4">
                                <label for="estadoCivil">ESTADO CIVIL:</label>
                                <select class="form-control" v-model="formData.estadoCivil" :class="hasError('estadoCivil') ? 'is-invalid' : ''">
                                    <option value="CASADO">CASADO(A)</option>
                                    <option value="DIVORCIADO">DIVORCIADO(A)</option>
                                    <option value="SOLTERO">SOLTERO(A)</option>
                                    <option value="VIUDO">VIUDO(A)</option>
                                </select> 
                                <div v-if="hasError('estadoCivil')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.estadoCivil.required">Selecciona un valor porfavor.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 5px;">
                            <div class="col-md-4">
                                <label for="telefono">TELEFONO:</label>
                                <input type="text" @keypress="onlyNumber" class="form-control" v-model="formData.telefono" :class="hasError('telefono') ? 'is-invalid' : ''">
                                <div v-if="hasError('telefono')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.telefono.maxLength">Demaciados caracteres, maximo 7 caracteres.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="celular">CELULAR:</label>
                                <input type="text" @keypress="onlyNumber" class="form-control" v-model="formData.celular" :class="hasError('celular') ? 'is-invalid' : ''">
                                <div v-if="hasError('celular')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.celular.required">Ingrese valor porfavor.</div>
                                    <div class="error" v-if="!$v.formData.celular.maxLength">Demaciados caracteres, maximo 8 caracteres.</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="email">CORREO INSTITUCIONAL:</label>
                                <input type="email" class="form-control" v-model="formData.email" :class="hasError('email') ? 'is-invalid' : ''">
                                <div v-if="hasError('email')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.email.required">Ingrese valor porfavor.</div>
                                    <div class="error" v-if="!$v.formData.email.email">Ingrese un email correcto.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    
                    <div class="col-md-3">
                        <label for="celular">FOTO:</label>
                        <input type="file" class="form-control" @change="obtenerImagen" accept="image/*" :class="hasError('foto') ? 'is-invalid' : ''">
                        <div v-if="hasError('foto')" class="invalid-feedback">
                            <div class="error" v-if="!$v.formData.foto.required">Ingrese valor porfavor.</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="carnetSeguro">CARNET SEGURO:</label>
                        <input type="text" @keypress="alphanumeric" class="form-control" style="text-transform:uppercase;" v-model="formData.carnetSeguro">
                        <div v-if="hasError('carnetSeguro')" class="invalid-feedback">
                            <div class="error" v-if="!$v.formData.carnetSeguro.maxLength">Demaciados caracteres, maximo 12 caracteres.</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="libreta">LIBRETA SERVICIO MILITAR:</label>
                        <input type="text" @keypress="alphanumeric" class="form-control" style="text-transform:uppercase;" v-model="formData.libreta" :class="hasError('libreta') ? 'is-invalid' : ''">
                        <div v-if="hasError('libreta')" class="invalid-feedback">
                            <div class="error" v-if="!$v.formData.libreta.maxLength">Demaciados caracteres, maximo 15 caracteres.</div>
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>RELIGION</label>
                        <select class="form-control" v-model="formData.religion" :class="hasError('religion') ? 'is-invalid' : ''">
                            <option value="ADVENTISTA">ADVENTISTA</option>
                            <option value="CATOLICA">CATÓLICA</option>
                            <option value="CRISTIANA">CRISTIANA</option>
                            <option value="JUDIA">JUDÍA</option>
                            <option value="MORMON">MORMÓN</option>
                            <option value="TJ">TESTIGOS DE JEHOVÁ</option>
                            <option value="OTRA">OTRA</option>                                        
                        </select>
                        <div v-if="hasError('religion')" class="invalid-feedback">
                            <div class="error" v-if="!$v.formData.religion.required">Seleccione un valor porfavor.</div>
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
                                    <date-picker class="dat" value-type="date" format="DD/MM/YYYY"
                                        v-model="formData.fechaNacimiento"
                                        :disabled-date="efecha1"
                                        :class="hasError('fechaNacimiento') ? 'is-invalid' : ''"
                                    ></date-picker>
                                    <!-- <input type="date" class="form-control" min="01/01/2021" v-model="formData.fechaNacimiento" :class="hasError('fechaNacimiento') ? 'is-invalid' : ''"> -->
                                    <div v-if="hasError('fechaNacimiento')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.fechaNacimiento.required">Ingrese valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="carnetIdentidad">LUGAR:</label>
                                    <div class="row">
                                        <div class="col-md-4" style="margin-top: 5px;">
                                            <v-select
                                                label="nombre"
                                                :options="Adepartamento"
                                                v-model="formData.departamento"
                                                @input="Provincia"
                                                placeholder="DEPARTAMENTO"
                                                :class="hasError('departamento') ? 'is-invalid' : ''"
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
                                            <div v-if="hasError('departamento')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.departamento.required">Seleccione un valor porfavor.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="margin-top: 5px;">
                                            <v-select
                                                label="nombre"
                                                :options="Aprovincia"
                                                v-model="formData.provincia"
                                                @input="Localidad"
                                                placeholder="PROVINCIA"
                                                :class="hasError('provincia') ? 'is-invalid' : ''"
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
                                            <div v-if="hasError('provincia')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.provincia.required">Seleccione un valor porfavor.</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="margin-top: 5px;">
                                            <v-select
                                                label="nombre"
                                                :options="Alocalidad"
                                                v-model="formData.localidad"
                                                placeholder="LOCALIDAD"
                                                :class="hasError('localidad') ? 'is-invalid' : ''"
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
                                            <div v-if="hasError('localidad')" class="invalid-feedback">
                                                <div class="error" v-if="!$v.formData.localidad.required">Seleccione un valor porfavor.</div>
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
                                    <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="formData.ciudad" :class="hasError('ciudad') ? 'is-invalid' : ''"></textarea>
                                    <div v-if="hasError('ciudad')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.ciudad.required">Ingrese valor porfavor.</div>
                                        <div class="error" v-if="!$v.formData.ciudad.maxLength">Demaciados caracteres, maximo 300 caracteres.</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="fechaNacimiento">ZONA:</label>
                                    <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="formData.zona" :class="hasError('zona') ? 'is-invalid' : ''"></textarea>
                                    <div v-if="hasError('zona')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.zona.required">Ingrese valor porfavor.</div>
                            <div class="error" v-if="!$v.formData.zona.maxLength">Demaciados caracteres, maximo 300 caracteres.</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-5">
                                    <label for="fechaNacimiento">CALLE/AVENIDA:</label>
                                    <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="formData.calle" :class="hasError('calle') ? 'is-invalid' : ''"></textarea>
                                    <div v-if="hasError('calle')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.calle.required">Ingrese valor porfavor.</div>
                            <div class="error" v-if="!$v.formData.calle.maxLength">Demaciados caracteres, maximo 300 caracteres.</div>
                                    </div>
                                </div>
                                
                            </div>
                        </fieldset>    
                    </div> 
                </div>   
                
            </div>
        </tab-content>

        <!-- PASO 2 -->
        <tab-content title="DATOS MILITARES">
            <!-- SITUACION -->
            <div class="form-group">
                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">SITUACION MILITAR</legend>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-md-3">
                                    <label for="">SITUACION</label>
                                    <v-select
                                        label="nombre"
                                        :options="Asituacion"
                                        v-model="formData.situacion"
                                        @input="SubSituacion"
                                        :class="hasError('situacion') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('situacion')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.situacion.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">SUBSITUACION</label>
                                    <v-select
                                        label="nombre"
                                        :options="Asubsituacion"
                                        v-model="formData.subsituacion"
                                        @input="DetalleSituacion"
                                        :class="hasError('subsituacion') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('subsituacion')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.subsituacion.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="">DETALLE SITUACION</label>
                                    <v-select
                                        label="nombre"
                                        :options="AdetalleSituacion"
                                        v-model="formData.detalleSituacion"
                                        :class="hasError('detalleSituacion') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('detalleSituacion')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.detalleSituacion.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">ESCALAFON</legend>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-md-3">
                                    <label for="">ESCALAFON</label>
                                    <v-select
                                        label="nombre"
                                        :options="Aescalafon"
                                        v-model="formData.escalafon"
                                        @input="SubEscalafon"
                                        :class="hasError('escalafon') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('escalafon')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.escalafon.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="">SUBESCALAFON</label>
                                    <v-select
                                        label="nombre"
                                        :options="Asubescalafon"
                                        v-model="formData.subescalafon"
                                        @input="Grado"
                                        class="style-chooser"
                                        :class="hasError('subescalafon') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('subescalafon')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.subescalafon.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">GRADO</label>
                                    <v-select
                                        label="nombre"
                                        :options="Agrado"
                                        v-model="formData.grado"
                                        :class="hasError('grado') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('grado')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.grado.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">DOCUMENTO</legend>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-md-3">
                                    <label for="carnetIdentidad">TIPO DOCUMENTO:</label>
                                    <select class="form-control" v-model="formData.sitTipoDocumento" :class="hasError('sitTipoDocumento') ? 'is-invalid' : ''">
                                        <option value="MEMORANDUM">MEMORANDUM</option>
                                        <option value="ORDEN DEL DIA">ORDEN DEL DIA</option>
                                        <option value="ORDEN GERNERAL DE DESTINO">ORDEN GERNERAL DE DESTINO</option>
                                    </select> 
                                    <div v-if="hasError('sitTipoDocumento')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.sitTipoDocumento.required">Ingrese valor porfavor.</div>
                                        <div class="error" v-if="!$v.formData.sitTipoDocumento.maxLength">Demaciados caracteres, maximo 20 caracteres.</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="carnetIdentidad">FECHA DOCUMENTO:</label>
                                    <date-picker class="dat" value-type="date" format="DD/MM/YYYY"
                                        v-model="formData.sitFechaDocumento"
                                        :disabled-date="fechaactual"
                                        :class="hasError('sitFechaDocumento') ? 'is-invalid' : ''"
                                    ></date-picker>
                                    <!-- <input type="date" class="form-control" v-model="formData.sitFechaDocumento" :class="hasError('sitFechaDocumento') ? 'is-invalid' : ''"> -->
                                    <div v-if="hasError('sitFechaDocumento')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.sitFechaDocumento.required">Ingrese valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="carnetIdentidad">NUMERO DOCUMENTO:</label>
                                    <input type="text" @keypress="numDoc" style="text-transform:uppercase;" class="form-control" v-model="formData.sitNroDocumento" :class="hasError('sitNroDocumento') ? 'is-invalid' : ''">
                                    <div v-if="hasError('sitNroDocumento')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.sitNroDocumento.required">Ingrese valor porfavor.</div>
                                        <div class="error" v-if="!$v.formData.sitNroDocumento.maxLength">Demaciados caracteres, maximo 8 caracteres.</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">CARNET MILITAR:</label>
                                    <input type="text" @keypress="onlyNumber" style="text-transform:uppercase;" class="form-control" v-model="formData.cm" :class="hasError('cm') ? 'is-invalid' : ''">
                                    <div v-if="hasError('cm')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.cm.required">Ingrese valor porfavor.</div>
                                        <div class="error" v-if="!$v.formData.cm.maxLength">Demaciados caracteres, maximo 8 caracteres.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <label for="">OBSERVACION:</label>
                                <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="formData.sitObser" :class="hasError('sitObser') ? 'is-invalid' : ''"></textarea>
                                <div v-if="hasError('sitObser')" class="invalid-feedback">
                                    <div class="error" v-if="!$v.formData.sitObser.maxLength">Demaciados caracteres, maximo 500 caracteres.</div>
                                </div>
                            </div>  
                        </fieldset>                        
                    </div>
                </div>
            </div>
            
            
        </tab-content>

        <!-- PASO 3 -->
        <tab-content title="ESTUDIOS">
            <div class="form-group">
                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-12">                        
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">COMPLEMENTO</legend>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="">ESTUDIOS:</label>
                                    <v-select
                                        label="nombre"
                                        :options="Aestudios"
                                        v-model="formData.estudios"
                                        @input="mostrarCom"
                                        :class="hasError('estudios') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('estudios')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.estudios.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="carnetIdentidad">COMPLEMENTO:</label>
                                    <input type="text" class="form-control" disabled v-model="complemento">
                                </div>                   
                            </div>   
                        </fieldset> 
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">ESPECIALIDAD</legend>
                            <div class="row" style="margin-top: 5px;">                    
                                <div class="col-md-6">
                                    <label for="">ESPECIALIDAD</label>
                                    <v-select
                                        label="nombre"
                                        :options="Aespecialidad"
                                        v-model="formData.especialidad"
                                        @input="Subespecialidad"
                                        :class="hasError('especialidad') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('especialidad')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.especialidad.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">SUBESPECIALIDAD</label>
                                    <v-select
                                        label="nombre"
                                        :options="Asubespecialidad"
                                        v-model="formData.subespecialidad"
                                        :class="hasError('subespecialidad') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('subespecialidad')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.subespecialidad.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>
                            </div>   
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">DOCUMENTO</legend>
                                <div class="row" style="margin-top: 5px;">
                                    <div class="col-md-4">
                                        <label for="carnetIdentidad">FECHA DOCUMENTO:</label>
                                        <date-picker class="dat" value-type="date" format="DD/MM/YYYY"
                                            v-model="formData.comFechaDocumento"
                                            :disabled-date="fechaactual"
                                            :class="hasError('comFechaDocumento') ? 'is-invalid' : ''"
                                        ></date-picker>
                                        <!-- <input type="date" class="form-control" v-model="formData.comFechaDocumento" :class="hasError('comFechaDocumento') ? 'is-invalid' : ''"> -->
                                        <div v-if="hasError('comFechaDocumento')" class="invalid-feedback">
                                            <div class="error" v-if="!$v.formData.comFechaDocumento.required">Ingrese valor porfavor.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="carnetIdentidad">TIPO DOCUMENTO:</label>
                                        <select class="form-control" v-model="formData.comDocumento" :class="hasError('comDocumento') ? 'is-invalid' : ''">
                                            <option value="MEMORANDUM">MEMORANDUM</option>
                                            <option value="ORDEN DEL DIA">ORDEN DEL DIA</option>
                                            <option value="ORDEN GERNERAL DE DESTINO">ORDEN GERNERAL DE DESTINO</option>
                                        </select> 
                                        <div v-if="hasError('comDocumento')" class="invalid-feedback">
                                            <div class="error" v-if="!$v.formData.comDocumento.required">Ingrese valor porfavor.</div>
                                            <div class="error" v-if="!$v.formData.comDocumento.maxLength">Demaciados caracteres, maximo 20 caracteres.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="carnetIdentidad">NUMERO DOCUMENTO:</label>
                                        <input type="text" @keypress="numDoc" style="text-transform:uppercase;" class="form-control" v-model="formData.comNroDocumento" :class="hasError('comNroDocumento') ? 'is-invalid' : ''">
                                        <div v-if="hasError('comNroDocumento')" class="invalid-feedback">
                                            <div class="error" v-if="!$v.formData.comNroDocumento.required">Ingrese valor porfavor.</div>
                                            <div class="error" v-if="!$v.formData.comNroDocumento.maxLength">Demaciados caracteres, maximo 8 caracteres.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 5px;">
                                    <label for="carnetIdentidad">OBSERVACION:</label>
                                    <textarea class="form-control" style="text-transform:uppercase;" rows="2" v-model="formData.comObser" :class="hasError('comObser') ? 'is-invalid' : ''"></textarea>
                                    <div v-if="hasError('comObser')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.comObser.maxLength">Demaciados caracteres, maximo 500 caracteres.</div>
                                    </div>
                        
                                </div>     
                        </fieldset> 
                    </div>                    
                </div>                
            </div>
        </tab-content>
        <!-- PASO 4 -->
        <tab-content title="DESTINO">
            <div class="form-group">
                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-12">                        
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">DESTINO</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">ORGANISMO:</label>
                                    <v-select
                                        label="descripcion"
                                        :options="Ad1"
                                        v-model="formData.d1"
                                        @input="Destino2"
                                        :class="hasError('d1') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('d1')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.d1.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <label for="">GRAN UNIDAD:</label>
                                    <v-select
                                        label="descripcion"
                                        :options="Ad2"
                                        v-model="formData.d2"
                                        @input="Destino3"
                                        :class="hasError('d2') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('d2')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.d2.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>                  
                            </div>  
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">REPARTICION:</label>
                                    <v-select
                                        label="descripcion"
                                        :options="Ad3"
                                        v-model="formData.d3"
                                        @input="Destino4"
                                        :class="hasError('d3') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('d3')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.d3.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <label for="">SUBREPARTICION:</label>
                                    <v-select
                                        label="descripcion"
                                        :options="Ad4"
                                        v-model="formData.d4"
                                        :class="hasError('d4') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('d4')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.d4.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div>                  
                            </div>
                            <div class="row" style="margin-top: 5px;">
                                <div class="col-md-4">
                                    <label for="carnetIdentidad">TIPO DOCUMENTO:</label>
                                    <select class="form-control" v-model="formData.tipoDocDest" :class="hasError('tipoDocDest') ? 'is-invalid' : ''">
                                        <option value="MEMORANDUM">MEMORANDUM</option>
                                        <option value="ORDEN DEL DIA">ORDEN DEL DIA</option>
                                        <option value="ORDEN GERNERAL DE DESTINO">ORDEN GERNERAL DE DESTINO</option>
                                    </select> 
                                    <div v-if="hasError('tipoDocDest')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.tipoDocDest.required">Ingrese valor porfavor.</div>
                                        <div class="error" v-if="!$v.formData.tipoDocDest.maxLength">Demaciados caracteres, maximo 20 caracteres.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="carnetIdentidad">FECHA DOCUMENTO:</label>
                                    <date-picker class="dat" value-type="date" format="DD/MM/YYYY"
                                        v-model="formData.fechDocDest"
                                        :disabled-date="fechaactual"
                                        :class="hasError('fechDocDest') ? 'is-invalid' : ''"
                                    ></date-picker>
                                    <div v-if="hasError('fechDocDest')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.fechDocDest.required">Ingrese valor porfavor.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="carnetIdentidad">NUMERO DOCUMENTO:</label>
                                    <input type="text" @keypress="numDoc" style="text-transform:uppercase;" class="form-control" v-model="formData.nroDocDest" :class="hasError('nroDocDest') ? 'is-invalid' : ''">
                                    <div v-if="hasError('nroDocDest')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.nroDocDest.required">Ingrese valor porfavor.</div>
                                        <div class="error" v-if="!$v.formData.nroDocDest.maxLength">Demaciados caracteres, maximo 8 caracteres.</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">CARGO</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">CARGO 1:</label>
                                    <v-select
                                        label="descripcion"
                                        :options="Ac1"
                                        v-model="formData.c1"
                                        :class="hasError('c1') ? 'is-invalid' : ''"
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
                                    <div v-if="hasError('c1')" class="invalid-feedback">
                                        <div class="error" v-if="!$v.formData.c1.required">Seleccione un valor porfavor.</div>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <label for="">CARGO 2:</label>
                                    <v-select
                                        label="descripcion"
                                        :options="Ac2"
                                        v-model="formData.c2"
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
                            </div>   
                        </fieldset>
                    </div>                    
                </div>                
            </div>
        </tab-content>  
        
    </form-wizard>
  </div>
</template>

<script>

import {FormWizard, TabContent, ValidationHelper} from 'vue-step-wizard'
import { required, maxLength, email } from 'vuelidate/lib/validators'
export default {
    name: 'BasicStepperForm',
    components: {
        FormWizard, TabContent
    },
    mixins: [ValidationHelper],
    data(){
        const today = new Date();
        return {
            //VARIABLES DE FORMULARIO
            formData:{
                /***
                 * TAB 1
                 */
                nombre:'',
                paterno:'',
                materno:'',
                genero:'',
                ci:'',
                expedido:'',
                estadoCivil:'',
                telefono:'',
                celular:'',
                email:'',
                foto: '',
                carnetSeguro:'',
                libreta:'',
                religion:'',
                fechaNacimiento: new Date(today.getTime() - 5842 * 24 * 3600 * 1000),
                //localidad
                departamento:'',
                provincia:'',
                localidad:'',
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
                d1:'',
                d2:'',
                d3:'',
                d4:'',
                c1:'',
                c2:'',
                tipoDocDest:'',
                fechDocDest:'',
                nroDocDest:''

            },
            
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
            Ad1:[],
            Ad2:[],
            Ad3:[],
            Ad4:[],
            Ac1:[],
            Ac2:[],


            validationRules: [
                { 
                    nombre: { required },
                    genero: { required },
                    ci: { required, maxLength: maxLength (10) },
                    estadoCivil: { required },
                    telefono: { maxLength: maxLength (7) },
                    celular: { required,maxLength: maxLength (8)  },
                    email: { required, email}, 
                    foto: {required},
                    carnetSeguro: { maxLength: maxLength (12) }, 
                    religion: { required },                    
                    fechaNacimiento: { required },
                    libreta: { maxLength: maxLength (15) },
                    //localidad
                    departamento: { required },
                    provincia: { required },
                    localidad: { required },
                    //direccion
                    ciudad: { required, maxLength: maxLength (300) },
                    zona: { required, maxLength: maxLength (300) },
                    calle: { required, maxLength: maxLength (300) },
                },
                { 
                    situacion: { required },
                    subsituacion: { required },
                    detalleSituacion: { required },
                    escalafon: { required },
                    subescalafon: { required },
                    sitTipoDocumento: { required, maxLength: maxLength (20) },
                    grado: { required },
                    sitFechaDocumento: { required },
                    sitNroDocumento: { required, maxLength: maxLength (8) },
                    cm: { required, maxLength: maxLength (8) },
                    sitObser: { maxLength: maxLength (300) },
                    
                },
                { 
                    estudios: { required }, 
                    especialidad: { required }, 
                    subespecialidad: { required }, 
                    comFechaDocumento: { required },                    
                    comDocumento: { required, maxLength: maxLength (20) },
                    comNroDocumento: { required, maxLength: maxLength (8) },
                    comObser: { maxLength: maxLength (300) },
                },
                {
                    d1: {required},
                    c1: {required},
                    d2: {required},
                    d3: {required},
                    d4: {required},
                    fechDocDest: { required },                    
                    tipoDocDest: { required, maxLength: maxLength (20) },
                    nroDocDest: { required, maxLength: maxLength (8) },
                }
            ]
        }
    },
    mounted() {
        this.Escalafon();
        this.Estudios();
        this.Situacion();
        this.Departamento();
        this.Especialidad();
        this.Destino1();
    },
    created() {
        
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
            return this.formData.foto;
        }
    },
    methods: {
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
        //DESTINOS
        Destino1(){
            let me = this;
            axios
            .get('/destino1Combo')
            .then(function (response) {
                me.Ad1 = response.data;
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            });
        },
        Destino2(){
            try {
                let me = this;
                me.formData.d2 = '';
                me.formData.d3 = '';
                me.formData.d4 = '';
                axios
                .post("/destino2Combo", {
                    dest1: me.formData.d1.id
                })
                .then(function (response) {
                    me.Ad2 = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Ad2 = [];
                this.Ad3 = [];
                this.Ad4 = [];
            }            
        },
        Destino3(){
            try {
                let me = this;
                me.formData.d3 = '';
                me.formData.d4 = '';
                axios
                .post("/destino3Combo", {
                    dest2: me.formData.d2.id
                })
                .then(function (response) {
                    me.Ad3 = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Ad3 = [];
                this.Ad4 = [];
            }
            
        },
        Destino4(){
            try {
                let me = this;
                me.formData.d4 = '';
                axios
                .post("/destino4Combo", {
                    dest3: me.formData.d3.id
                })
                .then(function (response) {
                    me.Ad4 = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            } catch (error) {
                this.Ad4 = [];
            }
            
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
                me.formData.c1 = '';
                me.formData.c2 = '';
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
                this.Ac1 = [];
                this.Ac2 = [];
            }
        },

        Grado(){
            try {
                let me = this;
                me.formData.grado = '';
                me.formData.c1 = '';
                me.formData.c2 = '';
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

                //lista cargos
                axios
                .post("/listarCargos", {
                    filtro : me.formData.subescalafon.id
                })
                .then(function (response) {
                    me.Ac1 = response.data;
                    me.Ac2 = response.data;
                })
                .catch(function (error) {
                // handle error
                console.log(error);
                });
            } catch (error) {
                this.Agrado = [];
                this.Ac1 = [];
                this.Ac2 = [];
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
                me.formData.localidad = '';
                me.formData.provincia = '';
                axios
                .post("/provinciasCombo", {
                    departamento: me.formData.departamento.id
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
                me.formData.localidad = '';
                axios
                .post("/localidadesCombo", {
                    provincia: me.formData.provincia.id
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
                        if (response.data.code == 200) {
                            swal.fire(
                                "Aceptado", //TITULO
                                "Se añadio correctamente el nuevo Personal.", //TEXTO DE MENSAJE
                                "success" // TIPO DE MODAL (success, warnning, error, info)
                            );
                            me.atras();
                        } else {
                            swal.fire(
                                "Error", //TITULO
                                "Ocurrio un error al guardar los datos.", //TEXTO DE MENSAJE
                                "error" // TIPO DE MODAL (success, warnning, error, info)
                            );
                        }
                        

                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                }else{
                // console.log('no empezamos');
                }
            })

            
        },
        obtenerImagen(e){
            try {
                var fileReader = new FileReader();

                fileReader.onload = (e) => {
                    this.formData.foto = e.target.result;
                }
                fileReader.readAsDataURL(e.target.files[0])
                this.v = 1;
            } catch (error) {
                
            }
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
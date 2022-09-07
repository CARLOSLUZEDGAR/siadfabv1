<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * Rutas de funciones estandarizadas
 */

/************RUTAS CONFIRMADAS EN SISTEMA */
/************MIGRAR TABLAS */

/************FIN MIGRAR TABLAS */
Route::put('/migrar/personal_destinos', 'MigracionController@migrarPersonalDestinos');
Route::put('/migrar/personal_escalafones', 'MigracionController@migrarPersonalEscalafones');

/************FIN RUTAS CONFIRMADAS */

Route::post('/listadorPersonal','PersonalController@ListadorPersonal');
Route::post('/listadorPersonalSofSgto','PersonalController@ListadorPersonalSofSgto');


/* *************************DESTINOS NIVEL 1************************************* */
Route::get('/listarDestino1','Nivel1_destinoController@ListarDestino1');
Route::post('/registrarDestino1','Nivel1_destinoController@RegistrarDestino1');
Route::put('/editarDestino1','Nivel1_destinoController@EditarDestino1');
Route::put('/desactivarDestino1','Nivel1_destinoController@DesactivarDestino1');
Route::put('/activarDestino1','Nivel1_destinoController@ActivarDestino1');

Route::get('/selectNivel1Destino', 'Nivel1_destinoController@SelectNivel1Destino');
Route::get('/generarPdfDestinos1','Nivel1_destinoController@GenerarPdfDestinos1');

/* *************************DESTINOS NIVEL 2************************************* */
Route::get('/listarDestino2','Nivel2_destinoController@ListarDestino2');
Route::post('/registrarDestino2','Nivel2_destinoController@RegistrarDestino2'); //TRES
Route::put('/editarDestino2','Nivel2_destinoController@EditarDestino2');//TRES_3
Route::put('/desactivarDestino2','Nivel2_destinoController@DesactivarDestino2');
Route::put('/activarDestino2','Nivel2_destinoController@ActivarDestino2');

Route::get('/selectDestinos_nivel2', 'Nivel2_destinoController@selectDestinosNivel2'); //select
Route::get('/selectbuscarDestinosNivel2', 'Nivel2_destinoController@selectbuscarDestinosNivel2'); //select buscar
Route::get('/generarPdfDestino2','Nivel2_destinoController@GenerarPdfDestino2');

/* *************************DESTINOS NIVEL 3************************************* */
Route::get('/listarDestino3','Nivel3_destinoController@ListarDestino3');
Route::post('/registrarDestino3','Nivel3_destinoController@RegistrarDestino3'); //TRES
Route::put('/editarDestino3','Nivel3_destinoController@EditarDestino3');//TRES_3
Route::put('/desactivarDestino3','Nivel3_destinoController@DesactivarDestino3');
Route::put('/activarDestino3','Nivel3_destinoController@ActivarDestino3');

Route::get('/selectDestinos_nivel3', 'Nivel3_destinoController@selectDestinosNivel3'); //select
Route::get('/selectbuscarDestinosNivel3', 'Nivel3_destinoController@selectbuscarDestinosNivel3'); //select buscar
Route::get('/generarPdfDestino3','Nivel3_destinoController@GenerarPdfDestino3');

/* *************************DESTINOS NIVEL 4************************************* */
Route::get('/listarDestino4','Nivel4_destinoController@ListarDestino4'); //listar personal
Route::post('/registrarDestino4','Nivel4_destinoController@RegistrarDestino4'); //TRES
Route::put('/editarDestino4','Nivel4_destinoController@EditarDestino4');//TRES_3
Route::put('/desactivarDestino4','Nivel4_destinoController@DesactivarDestinos4');
Route::put('/activarDestino4','Nivel4_destinoController@ActivarDestinos4');

Route::get('/generarPdfDestino4','Nivel4_destinoController@GenerarPdfDestino4');

//***  DESDE ACA TRABAJO EL ARMING  ***** */

/* **********************  PERSONAL ************************************* */
Route::get('/listarPersonalmasivo', 'PersonalController@masivo');
Route::get('/persona/escalafon', 'PersonalController@listarPersona_ParaEscalafon');

Route::get('/generarAscensoReporte', 'ordenGeneralAscensoController@createPDF');

/* Rutas Sof. Alberto */
Route::post('/listarPersonal2', 'PersonalController@listperdest');


Route::post('/listarPersonalDestinos', 'PersonalDestinosController@index');
Route::post('/registrarDestino', 'PersonalDestinosController@store');
Route::put('/editarDestino', 'PersonalDestinosController@update');
Route::put('/desactivarDestino', 'PersonalDestinosController@desactivarDestino');

Route::post('/actualizarDestino','PersonalDestinosController@index');

Route::post('/cambiarGrado','PersonalDestinosController@cambiarGrado');

Route::post('/listarPersonalDestAct', 'PersonalDestinosController@destact');


//SELECT DINAMICOS
Route::get('/destinos_nivel1/selectDestinos_nivel1', 'Nivel1_destinoController@SelectNivel1Destino');
Route::get('/destinos_nivel2/selectDestinos_nivel2', 'Nivel2_destinoController@selectDestinosNivel2');
Route::get('/destinos_nivel2/selectbuscarDestinos_nivel2', 'Nivel2_destinoController@selectbuscarDestinosNivel2');
Route::get('/destinos_nivel3/selectDestinos_nivel3', 'Nivel3_destinoController@selectDestinosNivel3');
Route::get('/destinos_nivel3/selectbuscarDestinos_nivel3', 'Nivel3_destinoController@selectbuscarDestinosNivel3');
Route::get('/destinos_nivel4/selectDestinos_nivel4', 'Nivel4_destinoController@selectDestinosNivel4');
Route::get('/destinos_nivel4/selectbuscarDestinos_nivel4', 'Nivel4_destinoController@selectbuscarDestinosNivel4');
Route::post('/listarGrado','PersonalDatosController@perdatdest');
//FIN SELECTS DINAMICOS
//BUSCADOR CON SELECT
Route::post('/listarCargos','CargoController@ListarCargos');
//FIN BUSCADOR CON SELECT
//REPORTE FPDF
Route::get('/ordenDestinos', 'ReporteDestinosController@createPDF');
Route::get('/cuadroEfectivos', 'PersonalDestinosController@cuadroEfectivos');

//REPORTE DOMPDF
Route::get('/reporteDesglose','ReportesDestinosController@ReporteDesglose');
Route::get('/certificadoDestAscenso','ReportesDestinosController@CertificadoDestAscenso');
Route::get('/certificadoDestFrontera','ReportesDestinosController@CertificadoDestFrontera');
Route::get('/certificadoDestDesglose','ReportesDestinosController@CertificadoDestDesglose');
Route::get('/certificadoDesglServicio','ReportesDestinosController@CertDesglServicio');
//Route::get('/reparticiones','ReportesDestinosController@Subreparticiones');

//ELIMINAR
Route::get('/cuadroPericia', 'PruebaReportesController@cuadroPericias');
Route::get('/cuadroEfectivoTotal', 'PruebaReportesController@cuadroEfectivoTotal');
Route::get('/cuadroEgresadoNoEgresado', 'PruebaReportesController@cuadroEgresadosNoEgresados');
Route::get('/cuadroFamiliaresPersonal', 'PruebaReportesController@cuadroFamiliaresPersonal');
Route::get('/cuadroPromocionCant', 'PruebaReportesController@cuadroPromocionCant');
Route::get('/cuadroSituacionPersonal', 'PruebaReportesController@cuadroSituacionPersonal');
Route::get('/cuadroFechaIncorporacion', 'PruebaReportesController@cuadroFechaIncorporacion');

//FIN ELIMINAR

//FIN REPORTE
Route::post('/datosPersonal','PersonalDatosController@perdatdest');

/**Rutas para Personal MATTOS */
Route::put('/editarPersonal','PersonalController@EditarPersonal');
Route::post('/datosPersonales','PersonalController@DatosPersonales');
Route::post('/listarPersonal','PersonalController@ListarPersonal');
Route::get('/listarPersonalSituacion','PersonalController@index');

Route::get('/listarDestinos','DestinosController@ListarDestinos');

//DATOS FAMILIARES
Route::get('/personallistardatfam', 'PersonalController@listarfam');

// PERSONAL PROFESION
Route::get('/listarPersonal', 'PersonalController@index');

/* DATOS PERSONALES  */

Route::post('/verDatosPersonales','PersonalController@VerDatosPersonales');

//**************************RUTAS DE ACCESO AL SISTEMA******************************* */


/**
 * Rutas para personal
 */
Route::get('/listPer','PersonalController@ListPersonal');
Route::post('/datPer','PersonalController@DatosPersonalesAcceso');

/**
 * RUTAS PARA CREACION DE USUARIOS
 */
Route::post('/crearUsuario','UsuarioController@CrearUsuario');
Route::post('/listarUsuarios','UsuarioController@ListarUsuarios');
Route::post('/datosUsuarios','UsuarioController@DatosUsuarios');
Route::put('/editarUsuarios','UsuarioController@EditarUsuario');
Route::put('/cambiarEstadoUsuario','UsuarioController@CambiarEstadoUsuario');
Route::get('/datosUsuario','UsuarioController@DatosUsuario');
Route::post('/editContrasena','UsuarioController@EditContrasena');


/**
 * Autor: Hidalgo Miranda Ariel Wilson
 * Fecha: 20/09/2020
 * Descripcion: Ruta de authenticacion
 */

Route::post('/authenticate/ingreso','Auth\LoginController@login');
Route::get('/authenticate/salir','Auth\LoginController@logout')->name('logout');
Route::get('/listarPermisos','Auth\LoginController@ListarPermisos');
Route::get('/login','Auth\LoginController@VistaLogin')->name('login');

/**
 * rutas para la admnitraciond e datos
 */
Route::post('/listarol','RoleController@ListarRole');
Route::post('/listarol2','RoleController@ListarRole2'); //Roles qu no tiene aasignado el usuario
Route::post('/listarolus','RoleController@ListarRoleUsuario');
Route::post('/listarPermisos','RoleController@ListarPermisos');
Route::post('/listaRolPermiso','RoleController@ListaRolPermiso');
Route::post('/guardarRol','RoleController@GuardarRol');
Route::post('/editarRol','RoleController@EditarRol');
Route::get('/listarRoles','RoleController@ListarRoles');
//rutas que permiten adicionar y quitar roles a los usuarios
Route::post('/agregarRol','RoleController@AgregarRol');
Route::post('/quitarRol','RoleController@QuitarRol');

/**
 * Rutas para listar permisos
 */
Route::post('/listapermisos','PermisoController@ListarPermisos');
Route::post('/guadarPermiso','PermisoController@GuardarPermisos');
Route::post('/editarPermiso','PermisoController@EditarPermisos');
Route::post('/datosPermiso','PermisoController@DatosPermiso');
Route::get('/listarModulos','PermisoController@ListarModulos');

//NOMBRE DEL USUARIO
Route::get('/datosP','DatosController@datosP');

/**
 * RUTAS PARA EL FORMULARIO DE NUEVO INGRESO
 */
// Rutas para tablas parametricas para el uso en combos anidados
//REGISTRAR NUEVO PERSONAL
Route::post('/registrarPersonal','PersonalController@RegistrarPersonal');
//ESCALAFON
Route::get('/escalafonesCombo','DatosController@Escalafon');
//SUBESCALAFONES
Route::post('/subescalafonesCombo','DatosController@SubEscalafon');
//GRADOS POR ESCALAFON
Route::post('/gradosCombo','DatosController@Grado');
//GRADOS POR NIVELES
Route::post('/gradosClasificacionCombo','DatosController@GradoClasificacion');
//SITUACIONES
Route::get('/situacionesCombo','DatosController@Situacion');
//SUBSITUACIONES
Route::post('/subsituacionesCombo','DatosController@SubSituacion');
//DETALLESITUACIONES
Route::post('/detallesituacionesCombo','DatosController@DetalleSituacion');
//ESTUDIOS
Route::get('/estudiosCombo','DatosController@Estudios');
//ESTUDIOS DEMERITOS
Route::get('/estudiosComboDem','DatosController@EstudiosDem');
//DEPARTAMENTO
Route::get('/departamentosCombo','DatosController@Departamentos');
//PROVINCIA
Route::post('/provinciasCombo','DatosController@Provincias');
//LOCALIDAD
Route::post('/localidadesCombo','DatosController@Localidades');
//ESPECIALIDADES
Route::get('/especialidadesCombo','DatosController@Especialidades');
//SUBESPECIALIDADES
Route::post('/subespecialidadesCombo','DatosController@SubEspecialidades');


/**
 * RUTAS PARA MODULO DE DEMERITOS
 */

//LISTA DE PERSONAL POR UNIDAD
Route::post('/listarPersonalUnidad','PersonalController@ListarPersonalUnidad');
//LISTAR PERSONAL EXTERNA A LA UNIDAD
Route::post('/ListarPersonalExterna','PersonalController@ListarPersonalExterna');
//DESTINO 1
Route::get('/destino1Combo','DestinosController@Destinos1');
//DESTINO 2
Route::post('/destino2Combo','DestinosController@Destinos2');
//DESTINO 3
Route::post('/destino3Combo','DestinosController@Destinos3');
//VALIDAR ABREVIATURA DESTINO 3
Route::get('/valDestino3Abrev','DatosController@ValidarAbrevDestino3');
Route::post('/guardarAbreviaturaDestino3','DatosController@GuardarAbreviaturaDestino3');
//DESTINO 4
Route::post('/destino4Combo','DestinosController@Destinos4');

//NOMBRE DE UNIDAD
Route::get('/nombreUnidad','DatosController@NombreUnidad');
//GRADOS POR NIVELES
Route::post('/gradosClasificacionCombo','DatosController@GradoClasificacion');

// LISTA DE SANCIONADORES
Route::post('/listarPersonalTotal','PersonalController@ListarPersonalTotal');
Route::post('/listarPersonalTotalUnidad','PersonalController@ListarPersonalTotalUnidad');


Route::put('/editarDatosPersonales','PersonalController@EditarDatosPersonales');

Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
   ->where('optional','.*');


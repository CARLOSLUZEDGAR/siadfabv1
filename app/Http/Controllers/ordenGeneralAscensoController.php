<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
//use App\Pdf;


class ordenGeneralAscensoController extends Controller

{
    public function createPDF(Request $request)
    {

        // $conn = pg_pconnect("host=192.168.3.77 port=5432 dbname=sipefab110821 user=postgres password=Qi58e_t$*/");
        $conn = pg_pconnect("host=127.0.0.1 port=5432 dbname=system_1 user=postgres password=7612120");

        $gestion_actual = $request->gestion;
        //CONSULTAS 1RA PARTE
        //OFICIALES
        $escalafon_oficiales = pg_query($conn,"SELECT escalafones.nombre
                                    FROM escalafones 
                                    INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                    INNER JOIN vista_grado_anterior_oficiales ON personal_escalafones.per_codigo = vista_grado_anterior_oficiales.antof_percodigo 
                                    INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_oficiales.antof_percodigo = personal_ascenso_promociones.per_codigo
                                    WHERE  personal_escalafones.estado =1 
                                    AND(personal_escalafones.subesc_cod=1 OR personal_escalafones.subesc_cod=2 OR personal_escalafones.subesc_cod=3)
                                    AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                    GROUP BY escalafones.id,escalafones.nombre
                                    ORDER BY  escalafones.id");
        $al_grado_oficiales = pg_query($conn,"SELECT grados.nombre,
                                        grados.id as graid
                                    FROM grados 
                                        INNER JOIN personal_escalafones ON personal_escalafones.gra_cod = grados.id 
                                        INNER JOIN vista_grado_anterior_oficiales ON personal_escalafones.per_codigo = vista_grado_anterior_oficiales.antof_percodigo 
                                        INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_oficiales.antof_percodigo = personal_ascenso_promociones.per_codigo
                                        INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                        INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                    WHERE  personal_escalafones.estado =1 
                                        AND(personal_escalafones.subesc_cod=1 OR personal_escalafones.subesc_cod=2 OR personal_escalafones.subesc_cod=3)
                                        AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                    GROUP BY grados.id,grados.nombre
                                    ORDER BY  grados.id");

        $personal_ascensos_oficiales = pg_query($conn,"SELECT subescalafones.nombre, 
                                                escalafones.nombre, 
                                                instancia_ascensos.instancia, 
                                                grados.nombre as nomgra,
                                                grados.id as graid,
                                                vista_grado_anterior_oficiales.antof_grado,
                                                vista_grado_anterior_oficiales.antof_estudio,
                                                vista_grado_anterior_oficiales.antof_paterno, 
                                                vista_grado_anterior_oficiales.antof_materno,
                                                vista_grado_anterior_oficiales.antof_nombre,
                                                personal_ascenso_promociones.antigfin, 
                                                personal_ascenso_promociones.observacion, 
                                                personal_ascenso_promociones.fechasc
                                            FROM escalafones 
                                            INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                            INNER JOIN vista_grado_anterior_oficiales ON personal_escalafones.per_codigo = vista_grado_anterior_oficiales.antof_percodigo 
                                            INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                            INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_oficiales.antof_percodigo = personal_ascenso_promociones.per_codigo
                                            INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                            INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                            WHERE  personal_escalafones.estado =1 
                                            AND(personal_escalafones.subesc_cod=1 OR personal_escalafones.subesc_cod=2 OR personal_escalafones.subesc_cod=3)
                                            AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                            ORDER BY  personal_escalafones.esca_cod,
                                                    personal_escalafones.subesc_cod,
                                                    personal_escalafones.gra_cod,
                                                    personal_ascenso_promociones.antiguedad");
        //FIN OFICIALES
        //SOFS SGTOS TECNICOS
        $escalafon_softec = pg_query($conn,"SELECT escalafones.nombre
                                                FROM escalafones 
                                                INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                INNER JOIN vista_grado_anterior_softec ON personal_escalafones.per_codigo = vista_grado_anterior_softec.antsoftec_percodigo 
                                                INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_softec.antsoftec_percodigo = personal_ascenso_promociones.per_codigo
                                                WHERE  personal_escalafones.estado =1 
                                                AND(personal_escalafones.subesc_cod=4 OR personal_escalafones.subesc_cod=5 OR personal_escalafones.subesc_cod=6)
                                                AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY escalafones.id,escalafones.nombre
                                                ORDER BY  escalafones.id");
        $al_grado_softec = pg_query($conn,"SELECT grados.nombre,
                                                    grados.id as graid
                                                FROM grados 
                                                    INNER JOIN personal_escalafones ON personal_escalafones.gra_cod = grados.id 
                                                    INNER JOIN vista_grado_anterior_softec ON personal_escalafones.per_codigo = vista_grado_anterior_softec.antsoftec_percodigo 
                                                    INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_softec.antsoftec_percodigo = personal_ascenso_promociones.per_codigo
                                                    INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                    INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                WHERE  personal_escalafones.estado =1 
                                                    AND(personal_escalafones.subesc_cod=4 OR personal_escalafones.subesc_cod=5 OR personal_escalafones.subesc_cod=6)
                                                    AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY grados.id,grados.nombre
                                                ORDER BY  grados.id");

        $personal_ascensos_softec = pg_query($conn,"SELECT subescalafones.nombre, 
                                                            escalafones.nombre, 
                                                            instancia_ascensos.instancia, 
                                                            grados.nombre as nomgra,
                                                            grados.id as graid,
                                                            vista_grado_anterior_softec.antsoftec_grado,
                                                            vista_grado_anterior_softec.antsoftec_estudio,
                                                            vista_grado_anterior_softec.antsoftec_paterno, 
                                                            vista_grado_anterior_softec.antsoftec_materno,
                                                            vista_grado_anterior_softec.antsoftec_nombre,
                                                            personal_ascenso_promociones.antigfin, 
                                                            personal_ascenso_promociones.observacion, 
                                                            personal_ascenso_promociones.fechasc
                                                        FROM escalafones 
                                                        INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                        INNER JOIN vista_grado_anterior_softec ON personal_escalafones.per_codigo = vista_grado_anterior_softec.antsoftec_percodigo 
                                                        INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                                        INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_softec.antsoftec_percodigo = personal_ascenso_promociones.per_codigo
                                                        INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                        INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                        WHERE  personal_escalafones.estado =1 
                                                        AND(personal_escalafones.subesc_cod=4 OR personal_escalafones.subesc_cod=5 OR personal_escalafones.subesc_cod=6)
                                                        AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                        ORDER BY  personal_escalafones.esca_cod,
                                                                personal_escalafones.subesc_cod,
                                                                personal_escalafones.gra_cod,
                                                                personal_ascenso_promociones.antiguedad");
        //FIN SOFS SGTOS TECNICOS
        //SOF SGTOS MUSICOS
        $escalafon_sofmus = pg_query($conn,"SELECT escalafones.nombre
                                                FROM escalafones 
                                                INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                INNER JOIN vista_grado_anterior_sofmus ON personal_escalafones.per_codigo = vista_grado_anterior_sofmus.antsofmus_percodigo 
                                                INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_sofmus.antsofmus_percodigo = personal_ascenso_promociones.per_codigo
                                                WHERE  personal_escalafones.estado =1 
                                                AND personal_escalafones.subesc_cod=21
                                                AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY escalafones.id,escalafones.nombre
                                                ORDER BY  escalafones.id");
        $al_grado_sofmus = pg_query($conn,"SELECT grados.nombre,
                                                    grados.id as graid
                                                FROM grados 
                                                    INNER JOIN personal_escalafones ON personal_escalafones.gra_cod = grados.id 
                                                    INNER JOIN vista_grado_anterior_sofmus ON personal_escalafones.per_codigo = vista_grado_anterior_sofmus.antsofmus_percodigo 
                                                    INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_sofmus.antsofmus_percodigo = personal_ascenso_promociones.per_codigo
                                                    INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                    INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                WHERE  personal_escalafones.estado =1 
                                                    AND personal_escalafones.subesc_cod=21
                                                    AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY grados.id,grados.nombre
                                                ORDER BY  grados.id");

        $personal_ascensos_sofmus = pg_query($conn,"SELECT subescalafones.nombre, 
                                                            escalafones.nombre, 
                                                            instancia_ascensos.instancia, 
                                                            grados.nombre as nomgra,
                                                            grados.id as graid,
                                                            REPLACE(vista_grado_anterior_sofmus.antsofmus_grado,'..','.') as antsofmus_grado,
                                                            vista_grado_anterior_sofmus.antsofmus_estudio,
                                                            vista_grado_anterior_sofmus.antsofmus_paterno, 
                                                            vista_grado_anterior_sofmus.antsofmus_materno,
                                                            vista_grado_anterior_sofmus.antsofmus_nombre,
                                                            personal_ascenso_promociones.antigfin, 
                                                            personal_ascenso_promociones.observacion, 
                                                            personal_ascenso_promociones.fechasc
                                                        FROM escalafones 
                                                        INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                        INNER JOIN vista_grado_anterior_sofmus ON personal_escalafones.per_codigo = vista_grado_anterior_sofmus.antsofmus_percodigo 
                                                        INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                                        INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_sofmus.antsofmus_percodigo = personal_ascenso_promociones.per_codigo
                                                        INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                        INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                        WHERE  personal_escalafones.estado =1 
                                                        AND personal_escalafones.subesc_cod=21
                                                        AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                        ORDER BY  personal_escalafones.esca_cod,
                                                                personal_escalafones.subesc_cod,
                                                                personal_escalafones.gra_cod,
                                                                personal_ascenso_promociones.antiguedad");
        //FIN SOFS SGTOS MUSICOS
        //OF SOFS SGTOS DE SERVICIO
        $escalafon_serv = pg_query($conn,"SELECT escalafones.nombre
                                                FROM escalafones 
                                                INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                INNER JOIN vista_grado_anterior_serv ON personal_escalafones.per_codigo = vista_grado_anterior_serv.antserv_percodigo 
                                                INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_serv.antserv_percodigo = personal_ascenso_promociones.per_codigo
                                                WHERE  personal_escalafones.estado =1 
                                                AND (personal_escalafones.subesc_cod=7 OR personal_escalafones.subesc_cod=8)
                                                AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY escalafones.id,escalafones.nombre
                                                ORDER BY  escalafones.id");
        $al_grado_serv = pg_query($conn,"SELECT grados.nombre,
                                                    grados.id as graid
                                                FROM grados 
                                                    INNER JOIN personal_escalafones ON personal_escalafones.gra_cod = grados.id 
                                                    INNER JOIN vista_grado_anterior_serv ON personal_escalafones.per_codigo = vista_grado_anterior_serv.antserv_percodigo 
                                                    INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_serv.antserv_percodigo = personal_ascenso_promociones.per_codigo
                                                    INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                    INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                WHERE  personal_escalafones.estado =1 
                                                    AND (personal_escalafones.subesc_cod=7 OR personal_escalafones.subesc_cod=8)
                                                    AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY grados.id,grados.nombre
                                                ORDER BY  grados.id");

        $personal_ascensos_serv = pg_query($conn,"SELECT subescalafones.nombre, 
                                                            escalafones.nombre, 
                                                            instancia_ascensos.instancia, 
                                                            grados.nombre as nomgra,
                                                            grados.id as graid,
                                                            REPLACE(vista_grado_anterior_serv.antserv_grado,'...','.') as antserv_grado,
                                                            vista_grado_anterior_serv.antserv_estudio,
                                                            vista_grado_anterior_serv.antserv_paterno, 
                                                            vista_grado_anterior_serv.antserv_materno,
                                                            vista_grado_anterior_serv.antserv_nombre,
                                                            personal_ascenso_promociones.antigfin, 
                                                            personal_ascenso_promociones.observacion, 
                                                            personal_ascenso_promociones.fechasc
                                                        FROM escalafones 
                                                        INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                        INNER JOIN vista_grado_anterior_serv ON personal_escalafones.per_codigo = vista_grado_anterior_serv.antserv_percodigo 
                                                        INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                                        INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_serv.antserv_percodigo = personal_ascenso_promociones.per_codigo
                                                        INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                        INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                        WHERE  personal_escalafones.estado =1 
                                                        AND (personal_escalafones.subesc_cod=7 OR personal_escalafones.subesc_cod=8)
                                                        AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                        ORDER BY  personal_escalafones.esca_cod,
                                                                personal_escalafones.subesc_cod,
                                                                personal_escalafones.gra_cod,
                                                                personal_ascenso_promociones.antiguedad");
        //FIN OF SOFS SGTOS DE SERVICIO
        //CIVIL
        $escalafon_civ = pg_query($conn,"SELECT escalafones.nombre
                                                FROM escalafones 
                                                INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                INNER JOIN vista_grado_anterior_civ ON personal_escalafones.per_codigo = vista_grado_anterior_civ.antciv_percodigo 
                                                INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_civ.antciv_percodigo = personal_ascenso_promociones.per_codigo
                                                WHERE  personal_escalafones.estado =1 
                                                AND (personal_escalafones.subesc_cod=9 OR personal_escalafones.subesc_cod=10 OR personal_escalafones.subesc_cod=11 OR personal_escalafones.subesc_cod=12)
                                                AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY escalafones.id,escalafones.nombre
                                                ORDER BY  escalafones.id");
        $al_grado_civ = pg_query($conn,"SELECT grados.nombre,
                                                    grados.id as graid
                                                FROM grados 
                                                    INNER JOIN personal_escalafones ON personal_escalafones.gra_cod = grados.id 
                                                    INNER JOIN vista_grado_anterior_civ ON personal_escalafones.per_codigo = vista_grado_anterior_civ.antciv_percodigo 
                                                    INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_civ.antciv_percodigo = personal_ascenso_promociones.per_codigo
                                                    INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                    INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                WHERE  personal_escalafones.estado =1 
                                                    AND (personal_escalafones.subesc_cod=9 OR personal_escalafones.subesc_cod=10 OR personal_escalafones.subesc_cod=11 OR personal_escalafones.subesc_cod=12)
                                                    AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                GROUP BY grados.id,grados.nombre
                                                ORDER BY  grados.id");

        $personal_ascensos_civ = pg_query($conn,"SELECT subescalafones.nombre, 
                                                            escalafones.nombre, 
                                                            instancia_ascensos.instancia, 
                                                            grados.nombre as nomgra,
                                                            grados.id as graid,
                                                            REPLACE(vista_grado_anterior_civ.antciv_grado,'...','.') as antciv_grado,
                                                            vista_grado_anterior_civ.antciv_estudio,
                                                            vista_grado_anterior_civ.antciv_paterno, 
                                                            vista_grado_anterior_civ.antciv_materno,
                                                            vista_grado_anterior_civ.antciv_nombre,
                                                            personal_ascenso_promociones.antigfin, 
                                                            personal_ascenso_promociones.observacion, 
                                                            personal_ascenso_promociones.fechasc
                                                        FROM escalafones 
                                                        INNER JOIN personal_escalafones ON escalafones.id = personal_escalafones.esca_cod 
                                                        INNER JOIN vista_grado_anterior_civ ON personal_escalafones.per_codigo = vista_grado_anterior_civ.antciv_percodigo 
                                                        INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                                        INNER JOIN personal_ascenso_promociones ON vista_grado_anterior_civ.antciv_percodigo = personal_ascenso_promociones.per_codigo
                                                        INNER JOIN instancia_ascensos ON personal_ascenso_promociones.instasc_cod = instancia_ascensos.id 
                                                        INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                                        WHERE  personal_escalafones.estado =1 
                                                        AND (personal_escalafones.subesc_cod=9 OR personal_escalafones.subesc_cod=10 OR personal_escalafones.subesc_cod=11 OR personal_escalafones.subesc_cod=12)
                                                        AND date_part('YEAR',personal_ascenso_promociones.fechasc)= $gestion_actual
                                                        ORDER BY  personal_escalafones.esca_cod,
                                                                personal_escalafones.subesc_cod,
                                                                personal_escalafones.gra_cod,
                                                                personal_ascenso_promociones.antiguedad");
        //FIN CIVIL


        $situacion = pg_query($conn,"SELECT s.id as ids,
                                s.nombre,
                                s.ogd
                                FROM situaciones as s
                                INNER JOIN personal_situaciones as ps ON ps.sit_cod = s.id
                                WHERE ps.estado = 1 
                                AND date_part('YEAR',ps.fecha_documento)=$gestion_actual
                                group by 
                                s.nombre,
                                ps.sit_cod,
                                s.id,
                                s.ogd
                                ORDER BY ps.sit_cod
                                ");

        $subsituacion = pg_query($conn,"SELECT sb.id as subsitid,
                                sb.nombre as nomsb,
                                sb.sit_cod as siid,
                                sb.ogd
                                FROM subsituaciones as sb
                                INNER JOIN personal_situaciones as ps ON ps.subsit_cod = sb.id
                                INNER JOIN situaciones as s ON s.id = ps.sit_cod
                                WHERE ps.estado = 1 
                                AND date_part('YEAR',ps.fecha_documento)=$gestion_actual
                                group by
                                ps.subsit_cod,
                                sb.id,
                                sb.nombre,
                                sb.sit_cod,
                                sb.ogd
                                ORDER BY ps.subsit_cod");

        $detalle_situacion = pg_query($conn,"SELECT ds.id as dsid,
                                    ds.nombre as nomds,
                                    ds.subsit_cod,
                                    ds.articulo,
                                    ds.ogd
                                    FROM detalle_situaciones as ds
                                    INNER JOIN personal_situaciones as ps ON ps.detsit_cod = ds.id
                                    INNER JOIN subsituaciones as sb ON sb.id =ps.subsit_cod
                                    WHERE ps.estado = 1 
                                    AND date_part('YEAR',ps.fecha_documento)=$gestion_actual
                                    GROUP BY
                                    ps.detsit_cod,
                                    ds.id,
                                    ds.nombre,
                                    ds.subsit_cod,
                                    ds.articulo,
                                    ds.ogd
                                    ORDER BY ps.detsit_cod");

        $personal_situacion = pg_query($conn,"SELECT detalle_situaciones.id as detsitid,
                                    detalle_situaciones.articulo, 
                                    situaciones.nombre as nomsit, 
                                    subsituaciones.nombre as nomsubsit, 
                                    detalle_situaciones.nombre as nomdetsit, 
                                    escalafones.nombre as nomesc, 
                                    subescalafones.nombre as nomsubesc,
                                    REPLACE(grados.abreviatura,'...','.') as grado, 
                                    REPLACE(estudios.abreviatura,'.',' ') as complemento,
                                    personals.per_nombre,
                                    personals.per_paterno,
                                    personals.per_materno, 
                                    personal_situaciones.fecha_documento 
                                    FROM personals 
                                    INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo 
                                    INNER JOIN situaciones ON personal_situaciones.sit_cod = situaciones.id 
                                    INNER JOIN subsituaciones ON personal_situaciones.subsit_cod = subsituaciones.id 
                                    INNER JOIN detalle_situaciones ON personal_situaciones.detsit_cod = detalle_situaciones.id 
                                    INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
                                    INNER JOIN escalafones ON personal_escalafones.esca_cod = escalafones.id 
                                    INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id 
                                    INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                    INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
                                    INNER JOIN estudios ON personal_estudios.est_cod = estudios.id
                                    WHERE personal_situaciones.estado = 1 
                                    AND personal_escalafones.estado = 1 
                                    AND personal_estudios.estado = 1 
                                    AND date_part('YEAR',personal_situaciones.fecha_documento)=$gestion_actual
                                    AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
                                    ORDER BY personal_situaciones.sit_cod,
                                    personal_situaciones.subsit_cod,
                                    personal_situaciones.detsit_cod, 
                                    personal_escalafones.esca_cod,
                                    personal_escalafones.subesc_cod,
                                    personal_escalafones.gra_cod,
                                    SUBSTRING(personals.per_cm,1,3),
                                    SUBSTRING(personals.per_cm,4,2),
                                    SUBSTRING(personals.per_cm,7,2),
                                    personal_estudios.est_cod");

        $promocion = pg_query($conn,"SELECT personal_situaciones.promo
                                    FROM personals 
                                    INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo 
                                    INNER JOIN situaciones ON personal_situaciones.sit_cod = situaciones.id 
                                    INNER JOIN subsituaciones ON personal_situaciones.subsit_cod = subsituaciones.id 
                                    INNER JOIN detalle_situaciones ON personal_situaciones.detsit_cod = detalle_situaciones.id 
                                    WHERE personal_situaciones.estado = 1 
                                    AND personal_situaciones.sit_cod = 1 
                                    AND personal_situaciones.subsit_cod = 2 
                                    AND personal_situaciones.detsit_cod = 6
                                    AND date_part('YEAR',personal_situaciones.fecha_documento) BETWEEN $gestion_actual-3 AND $gestion_actual 
                                    AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
                                    GROUP BY personal_situaciones.promo
                                    ORDER BY personal_situaciones.promo");
            
        $reserva_activa = pg_query($conn,"SELECT detalle_situaciones.articulo, 
                                                situaciones.nombre, 
                                                subsituaciones.nombre, 
                                                detalle_situaciones.nombre, 
                                                escalafones.nombre, 
                                                subescalafones.nombre,
                                                grados.abreviatura,
                                                estudios.abreviatura,
                                                personals.per_nombre,
                                                personals.per_paterno,
                                                personals.per_materno, 
                                                personal_situaciones.fecha_documento,
                                                personal_situaciones.promo
                                            FROM personals 
                                            INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo 
                                            INNER JOIN situaciones ON personal_situaciones.sit_cod = situaciones.id 
                                            INNER JOIN subsituaciones ON personal_situaciones.subsit_cod = subsituaciones.id 
                                            INNER JOIN detalle_situaciones ON personal_situaciones.detsit_cod = detalle_situaciones.id 
                                            INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
                                            INNER JOIN escalafones ON personal_escalafones.esca_cod = escalafones.id 
                                            INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id 
                                            INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                            INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
                                            INNER JOIN estudios ON personal_estudios.est_cod= estudios.id
                                            WHERE personal_situaciones.estado = 1 
                                            AND personal_escalafones.estado = 1 
                                            AND personal_estudios.estado = 1 
                                            AND personal_situaciones.sit_cod = 1 
                                            AND personal_situaciones.subsit_cod = 2 
                                            AND personal_situaciones.detsit_cod = 6
                                            AND date_part('YEAR',personal_situaciones.fecha_documento) BETWEEN $gestion_actual-3 AND $gestion_actual 
                                            AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
                                            ORDER BY personal_situaciones.promo,
                                                    personal_escalafones.esca_cod,
                                                    personal_escalafones.subesc_cod,
                                                    personal_escalafones.gra_cod,
                                                    personal_situaciones.sit_cod,
                                                    personal_situaciones.subsit_cod,
                                                    personal_situaciones.detsit_cod, 
                                                    SUBSTRING(personals.per_cm,1,3),
                                                    SUBSTRING(personals.per_cm,4,2),
                                                    SUBSTRING(personals.per_cm,7,2),
                                                    personal_estudios.est_cod");
        //CONSULTAS 2DA PARTE
        $entidad = pg_query($conn,"SELECT 
                            nd1.id as iddestn1, 
                            descripcion,
                            nd1.ogd
                            from personals as p
                            join personal_destinos as pd on p.per_codigo = pd.per_codigo
                            join nivel1_destinos as nd1 on nd1.id = pd.d1_cod
                            join personal_situaciones as ps on ps.per_codigo = p.per_codigo
                            join situaciones as s on s.id = ps.sit_cod
                            join detalle_situaciones as ds on ds.id = ps.detsit_cod
                            where pd.estado = 1
                            and s.id = 1
                            AND (ds.id=1 OR ds.id=2 OR ds.id=4 OR ds.id=5 OR ds.id=8 OR ds.id=9 OR ds.id=11 OR ds.id=13 OR ds.id=14 OR ds.id=16 OR ds.id=17 OR ds.id=29 OR ds.id=30 OR ds.id=31 OR ds.id=32 OR ds.id=33) 
                            AND ps.estado='1'
                            AND (per_cm LIKE '1%' OR per_cm LIKE '3%' OR per_cm LIKE '5%')                      
                            group by nd1.id,
                            pd.d1_cod,
                            descripcion,
                            nd1.ogd
                            order by pd.d1_cod");
        $gran_unidad = pg_query($conn,"SELECT 
                            nd2.id as iddestn2, 
                            descripcion,
                            nd2.d1_cod as d1cod,
                            nd2.ogd
                            from personals as p
                            join personal_destinos as pd on p.per_codigo = pd.per_codigo
                            join nivel2_destinos as nd2 on nd2.id = pd.d2_cod
                            join personal_situaciones as ps on ps.per_codigo = p.per_codigo
                            join situaciones as s on s.id = ps.sit_cod
                            join detalle_situaciones as ds on ds.id = ps.detsit_cod
                            where pd.estado = 1
                            and s.id = 1
                            AND (ds.id=1 OR ds.id=2 OR ds.id=4 OR ds.id=5 OR ds.id=8 OR ds.id=9 OR ds.id=11 OR ds.id=13 OR ds.id=14 OR ds.id=16 OR ds.id=17 OR ds.id=29 OR ds.id=30 OR ds.id=31 OR ds.id=32 OR ds.id=33) 
                            AND ps.estado='1'
                            AND (per_cm LIKE '1%' OR per_cm LIKE '3%' OR per_cm LIKE '5%')                      
                            group by nd2.id,
                            pd.d2_cod,
                            descripcion,
                            nd2.ogd
                            order by nd2.prioridad,nd2.id");
        $reparticion = pg_query($conn,"SELECT 
                        nd3.id as iddestn3, 
                        descripcion,
                        nd3.d2_cod as d2cod,
                        nd3.ogd
                        from personals as p
                        join personal_destinos as pd on p.per_codigo = pd.per_codigo
                        join nivel3_destinos as nd3 on nd3.id = pd.d3_cod
                        join personal_situaciones as ps on ps.per_codigo = p.per_codigo
                        join situaciones as s on s.id = ps.sit_cod
                        join detalle_situaciones as ds on ds.id = ps.detsit_cod
                        where pd.estado = 1
                        and s.id = 1
                        AND (ds.id=1 OR ds.id=2 OR ds.id=4 OR ds.id=5 OR ds.id=8 OR ds.id=9 OR ds.id=11 OR ds.id=13 OR ds.id=14 OR ds.id=16 OR ds.id=17 OR ds.id=29 OR ds.id=30 OR ds.id=31 OR ds.id=32 OR ds.id=33) 
                        AND ps.estado='1'
                        AND (per_cm LIKE '1%' OR per_cm LIKE '3%' OR per_cm LIKE '5%')                      
                        group by nd3.id,
                        pd.d3_cod,
                        descripcion,
                        nd3.ogd
                        order by nd3.prioridad,nd3.id"); 
        $subreparticion = pg_query($conn,"SELECT 
                        nd4.id as iddestn4, 
                        descripcion,
                        nd4.d3_cod as d3cod, 
                        nd4.ogd
                        from personals as p
                        join personal_destinos as pd on p.per_codigo = pd.per_codigo
                        join nivel4_destinos as nd4 on nd4.id = pd.d4_cod
                        join personal_situaciones as ps on ps.per_codigo = p.per_codigo
                        join situaciones as s on s.id = ps.sit_cod
                        join detalle_situaciones as ds on ds.id = ps.detsit_cod
                        where pd.estado = 1
                        and s.id = 1
                        AND (ds.id=1 OR ds.id=2 OR ds.id=4 OR ds.id=5 OR ds.id=8 OR ds.id=9 OR ds.id=11 OR ds.id=13 OR ds.id=14 OR ds.id=16 OR ds.id=17 OR ds.id=29 OR ds.id=30 OR ds.id=31 OR ds.id=32 OR ds.id=33) 
                        AND ps.estado='1'
                        AND (per_cm LIKE '1%' OR per_cm LIKE '3%' OR per_cm LIKE '5%')                      
                        group by nd4.id,
                        pd.d4_cod,
                        descripcion,
                        nd4.ogd
                        order by nd4.orden,nd4.id");
        
        $personalDestinos1 = pg_query($conn,"SELECT  personal_destinos.id as idpersonal_destinos,
                                            personal_destinos.d4_cod,
                                            REPLACE(grados.abreviatura,'...','.') as grado,
                                            REPLACE(estudios.abreviatura,'.',' ') as complemento,
                                            personals.per_nombre,
                                            personals.per_paterno,
                                            personals.per_materno,
                                            personals.per_cm as cm, 
                                            grados.id as gracod,
                                            cargos.descripcion
                                            FROM personals 
                                            INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
                                            INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
                                            INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo
                                            INNER JOIN situaciones ON situaciones.id = personal_situaciones.sit_cod
                                            INNER JOIN detalle_situaciones ON detalle_situaciones.id = personal_situaciones.detsit_cod
                                            INNER JOIN personal_destinos ON personals.per_codigo = personal_destinos.per_codigo
                                            INNER JOIN nivel1_destinos ON personal_destinos.d1_cod = nivel1_destinos.id 
                                            INNER JOIN nivel2_destinos ON personal_destinos.d2_cod = nivel2_destinos.id 
                                            INNER JOIN nivel3_destinos ON personal_destinos.d3_cod = nivel3_destinos.id 
                                            INNER JOIN nivel4_destinos ON personal_destinos.d4_cod = nivel4_destinos.id 
                                            INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                            INNER JOIN estudios ON personal_estudios.est_cod = estudios.id
                                            INNER JOIN personal_cargos on personal_destinos.id = personal_cargos.dest_cod
                                            INNER JOIN cargos on personal_cargos.car_cod = cargos.id
                                        WHERE personal_destinos.estado = 1 AND situaciones.id = 1 
                                        AND (detalle_situaciones.id=1 OR detalle_situaciones.id=2 OR detalle_situaciones.id=4 OR detalle_situaciones.id=5 OR detalle_situaciones.id=8 OR detalle_situaciones.id=9 OR detalle_situaciones.id=11 OR detalle_situaciones.id=13 OR detalle_situaciones.id=14 OR detalle_situaciones.id=16 OR detalle_situaciones.id=17 OR detalle_situaciones.id=29 OR detalle_situaciones.id=30 OR detalle_situaciones.id=31 OR detalle_situaciones.id=32 OR detalle_situaciones.id=33) 
                                        AND personal_situaciones.estado = 1 
                                        AND personal_estudios.estado = 1 
                                        AND personal_escalafones.estado = 1
                                        AND personal_cargos.nivel_cargo = 1
                                        AND (per_cm LIKE '1%' OR per_cm LIKE '3%' OR per_cm LIKE '5%')                      
                                        ORDER BY personal_destinos.d1_cod,
                                            nivel2_destinos.prioridad,
                                            nivel3_destinos.d2_cod,
                                            nivel3_destinos.orden,
                                            nivel4_destinos.d3_cod,
                                            nivel4_destinos.orden,
                                            personal_escalafones.esca_cod,
                                            grados.id,
                                            personal_destinos.promocion,
                                            SUBSTRING(per_cm,1,3),
                                            SUBSTRING(per_cm,4,2),
                                            SUBSTRING(per_cm,7,2)");
        $personalDestinos2 = pg_query($conn,"SELECT  personal_destinos.id as idpersonal_destinos,
                                            personal_destinos.d4_cod,
                                            REPLACE(grados.abreviatura,'...','.') as grado,
                                            REPLACE(estudios.abreviatura,'.',' ') as complemento,
                                            personals.per_nombre,
                                            personals.per_paterno,
                                            personals.per_materno,
                                            personals.per_cm as cm, 
                                            grados.id as gracod,
                                            cargos.id as idcargo,
                                            cargos.descripcion
                                            FROM personals 
                                            INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
                                            INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
                                            INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo
                                            INNER JOIN situaciones ON situaciones.id = personal_situaciones.sit_cod
                                            INNER JOIN detalle_situaciones ON detalle_situaciones.id = personal_situaciones.detsit_cod
                                            INNER JOIN personal_destinos ON personals.per_codigo = personal_destinos.per_codigo
                                            INNER JOIN nivel1_destinos ON personal_destinos.d1_cod = nivel1_destinos.id 
                                            INNER JOIN nivel2_destinos ON personal_destinos.d2_cod = nivel2_destinos.id 
                                            INNER JOIN nivel3_destinos ON personal_destinos.d3_cod = nivel3_destinos.id 
                                            INNER JOIN nivel4_destinos ON personal_destinos.d4_cod = nivel4_destinos.id 
                                            INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
                                            INNER JOIN estudios ON personal_estudios.est_cod = estudios.id
                                            INNER JOIN personal_cargos on personal_destinos.id = personal_cargos.dest_cod
                                            INNER JOIN cargos on personal_cargos.car_cod = cargos.id
                                        WHERE personal_destinos.estado = 1 AND situaciones.id = 1 
                                        AND (detalle_situaciones.id=1 OR detalle_situaciones.id=2 OR detalle_situaciones.id=4 OR detalle_situaciones.id=5 OR detalle_situaciones.id=8 OR detalle_situaciones.id=9 OR detalle_situaciones.id=11 OR detalle_situaciones.id=13 OR detalle_situaciones.id=14 OR detalle_situaciones.id=16 OR detalle_situaciones.id=17 OR detalle_situaciones.id=29 OR detalle_situaciones.id=30 OR detalle_situaciones.id=31 OR detalle_situaciones.id=32 OR detalle_situaciones.id=33) 
                                        AND personal_situaciones.estado = 1 
                                        AND personal_estudios.estado = 1 
                                        AND personal_escalafones.estado = 1
                                        AND personal_cargos.nivel_cargo = 2
                                        AND (per_cm LIKE '1%' OR per_cm LIKE '3%' OR per_cm LIKE '5%')                      
                                        ORDER BY personal_destinos.d1_cod,
                                            nivel2_destinos.prioridad,
                                            nivel3_destinos.d2_cod,
                                            nivel3_destinos.orden,
                                            nivel4_destinos.d3_cod,
                                            nivel4_destinos.orden,
                                            personal_escalafones.esca_cod,
                                            grados.id,
                                            personal_destinos.promocion,
                                            SUBSTRING(per_cm,1,3),
                                            SUBSTRING(per_cm,4,2),
                                            SUBSTRING(per_cm,7,2)");
        //CONSULTAS 3RA PARTE
        $diplomas = pg_query($conn,"SELECT desgloce_cursos.descripcion,
                                            desgloce_cursos.id as desgid,
                                            tipo_cursos.id as tipcurid
                                            FROM personals 
                                            INNER JOIN personal_cursos ON personals.per_codigo = personal_cursos.per_codigo 
                                            INNER JOIN tipo_cursos ON personal_cursos.tipcur_cod = tipo_cursos.id
                                            INNER JOIN desgloce_cursos on desgloce_cursos.id = personal_cursos.desgcur_cod
                                            WHERE
                                            (personal_cursos.tipcur_cod=98 OR personal_cursos.tipcur_cod=5 OR personal_cursos.tipcur_cod=6 OR personal_cursos.tipcur_cod=8 OR personal_cursos.tipcur_cod=9 OR personal_cursos.tipcur_cod=3 OR personal_cursos.tipcur_cod=4 OR personal_cursos.tipcur_cod=20 OR personal_cursos.tipcur_cod=21 OR personal_cursos.tipcur_cod=160 OR personal_cursos.tipcur_cod=19 OR personal_cursos.tipcur_cod=158 OR personal_cursos.tipcur_cod=159 OR personal_cursos.tipcur_cod=104 OR personal_cursos.tipcur_cod=105 OR personal_cursos.tipcur_cod=155 OR personal_cursos.tipcur_cod=151 OR personal_cursos.tipcur_cod=153 OR personal_cursos.tipcur_cod=154 OR personal_cursos.tipcur_cod=161) 
                                            AND date_part('YEAR',personal_cursos.fecha_otorgacion)=$gestion_actual
                                            group by 
                                            desgloce_cursos.descripcion,
                                            desgloce_cursos.id,
                                            tipo_cursos.id,
                                            tipo_cursos.orden_dip
                                            order by tipo_cursos.orden_dip");
        $personal_diplomas = pg_query($conn,"SELECT tipo_cursos.descripcion, 
                                            tipo_cursos.id as tipcurid,
                                            desgloce_cursos.id as desgid,
                                            REPLACE(grados.abreviatura,'..','.') as grado,
                                            REPLACE(estudios.abreviatura,'.',' ') as complemento,
                                            personals.per_nombre,
                                            personals.per_paterno,
                                            personals.per_materno, 
                                            personal_cursos.fecha_otorgacion as fecha
                                        FROM personals 
                                            INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
                                            INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
                                            INNER JOIN grados ON personal_escalafones.gra_cod = grados.id
                                            INNER JOIN estudios ON personal_estudios.est_cod = estudios.id 
                                            INNER JOIN personal_cursos ON personals.per_codigo = personal_cursos.per_codigo 
                                            INNER JOIN tipo_cursos ON personal_cursos.tipcur_cod = tipo_cursos.id
                                            INNER JOIN desgloce_cursos ON personal_cursos.desgcur_cod = desgloce_cursos.id
                                        WHERE personal_escalafones.estado=1 
                                        AND personal_estudios.estado=1 
                                        AND (personal_cursos.tipcur_cod=98 OR personal_cursos.tipcur_cod=5 OR personal_cursos.tipcur_cod=6 OR personal_cursos.tipcur_cod=8 OR personal_cursos.tipcur_cod=9 OR personal_cursos.tipcur_cod=3 OR personal_cursos.tipcur_cod=4 OR personal_cursos.tipcur_cod=20 OR personal_cursos.tipcur_cod=21 OR personal_cursos.tipcur_cod=160 OR personal_cursos.tipcur_cod=19 OR personal_cursos.tipcur_cod=158 OR personal_cursos.tipcur_cod=159 OR personal_cursos.tipcur_cod=104 OR personal_cursos.tipcur_cod=105 OR personal_cursos.tipcur_cod=155 OR personal_cursos.tipcur_cod=151 OR personal_cursos.tipcur_cod=153 OR personal_cursos.tipcur_cod=154 OR personal_cursos.tipcur_cod=161) 
                                        AND date_part('YEAR',personal_cursos.fecha_otorgacion)=$gestion_actual
                                        AND personal_escalafones.esca_cod=1 
                                        ORDER BY tipo_cursos.orden_dip, 
                                            personal_escalafones.esca_cod, 
                                            personal_escalafones.subesc_cod,
                                            personal_escalafones.gra_cod,
                                            SUBSTRING(personals.per_cm,1,3),
                                            SUBSTRING(personals.per_cm,4,2),
                                            SUBSTRING(personals.per_cm,6,3)");

        $brevet = pg_query($conn,"SELECT brevets.descripcion, 
                        brevets.id as breid
                        FROM personals 
                        INNER JOIN personal_brevets ON personals.per_codigo = personal_brevets.per_codigo 
                        INNER JOIN brevets ON personal_brevets.brevet_cod = brevets.id 
                        WHERE brevets.clasificacion='BR' 
                        AND (personal_brevets.brevet_cod=38 OR 
                        personal_brevets.brevet_cod=39 OR 
                        personal_brevets.brevet_cod=40 OR 
                        personal_brevets.brevet_cod=41 OR  
                        personal_brevets.brevet_cod=42 OR 
                        personal_brevets.brevet_cod=43 OR 
                        personal_brevets.brevet_cod=4 OR 
                        personal_brevets.brevet_cod=5 OR 
                        personal_brevets.brevet_cod=6 OR 
                        personal_brevets.brevet_cod=9 OR
                        personal_brevets.brevet_cod=10 OR
                        personal_brevets.brevet_cod=27 OR 
                        personal_brevets.brevet_cod=28 OR 
                        personal_brevets.brevet_cod=29 OR
                        personal_brevets.brevet_cod=30 OR
                        personal_brevets.brevet_cod=22 OR
                        personal_brevets.brevet_cod=12 OR
                        personal_brevets.brevet_cod=13 OR
                        personal_brevets.brevet_cod=14 OR
                        personal_brevets.brevet_cod=15)
                        AND date_part('YEAR',personal_brevets.fecha_imposicion) = $gestion_actual
                        --AND personals.per_codigo=393
                        group by brevets.descripcion, 
                        brevets.id
                        ORDER BY brevets.id");
        $personal_brevets = pg_query($conn,"SELECT brevets.descripcion, 
                                            brevets.id as breid,
                                            REPLACE(grados.abreviatura,'..','.') as grado,
                                            REPLACE(estudios.abreviatura,'.',' ') as complemento,
                                            personals.per_nombre,
                                            personals.per_paterno,
                                            personals.per_materno,
                                            personals.per_codigo as pcod, 
                                            subescalafones.id, 
                                            personal_brevets.fecha_imposicion as fecha
                                            FROM personals 
                                            INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
                                            INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
                                            INNER JOIN personal_brevets ON personals.per_codigo = personal_brevets.per_codigo 
                                            INNER JOIN brevets ON personal_brevets.brevet_cod = brevets.id 
                                            INNER JOIN estudios ON personal_estudios.est_cod = estudios.id 
                                            INNER JOIN grados ON personal_escalafones.gra_cod = grados.id
                                            INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
                                            INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo
                                            WHERE brevets.clasificacion='BR' 
                                            AND personal_escalafones.estado = 1 
                                            AND personal_estudios.estado = 1 
                                            AND personal_situaciones.sit_cod = 1 
                                            AND personal_situaciones.subsit_cod = 1 
                                            AND personal_situaciones.estado = 1 
                                            AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
                                            AND (personal_brevets.brevet_cod=38 OR 
                                            personal_brevets.brevet_cod=39 OR 
                                            personal_brevets.brevet_cod=40 OR 
                                            personal_brevets.brevet_cod=41 OR  
                                            personal_brevets.brevet_cod=42 OR 
                                            personal_brevets.brevet_cod=43 OR 
                                            personal_brevets.brevet_cod=4 OR 
                                            personal_brevets.brevet_cod=5 OR 
                                            personal_brevets.brevet_cod=6 OR 
                                            personal_brevets.brevet_cod=9 OR
                                            personal_brevets.brevet_cod=10 OR
                                            personal_brevets.brevet_cod=27 OR 
                                            personal_brevets.brevet_cod=28 OR 
                                            personal_brevets.brevet_cod=29 OR
                                            personal_brevets.brevet_cod=30 OR
                                            personal_brevets.brevet_cod=22 OR
                                            personal_brevets.brevet_cod=12 OR
                                            personal_brevets.brevet_cod=13 OR
                                            personal_brevets.brevet_cod=14 OR
                                            personal_brevets.brevet_cod=15)
                                            AND date_part('YEAR',personal_brevets.fecha_imposicion) = $gestion_actual
                                            --AND personals.per_codigo=393
                                            ORDER BY brevets.id,
                                            personal_escalafones.esca_cod, 
                                            subescalafones.id,
                                            personal_escalafones.gra_cod");

        $pdf = new Pdf ('P','mm','Letter');
        $title = 'ORDEN DE ASCENSOS';
        $pdf->SetTitle($title);
        $pdf->SetX(20);
        $pdf->AliasNbPages();
        $fecha = date("dHi-M-Y");
        $pdf->Ln(5);
        global $i;
        for ( $i=0; $i<=4; $i++) { 
            //INCIO PARTE 1
            if($i == 0){
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('ASCENSOS EN LA CATEGORÍA DE OFICIALES SUPERIORES Y OFICIALES SUBALTERNOS.'),0);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('En cumplimiento al Art.65°. - Inciso ñ) de la Ley Orgánica de las FF.AA. de la Nación (LOFA. 1405), previa autorización del Señor Comandante en Jefe de las FF.AA., en conformidad del Señor Ministro de Defensa Nacional y la Aprobación del Señor Presidente Constitucional del Estado Plurinacional.'),0);
                while($escaof = pg_fetch_array($escalafon_oficiales)){
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetX(20);
                    $pdf->Cell(176,7,utf8_decode('ESCALAFÓN DE '.$escaof['nombre']),0,0,'L');
                    $pdf->Ln();
                    pg_result_seek($al_grado_oficiales, 0);
                    while($algraof = pg_fetch_array($al_grado_oficiales)){
                        $pdf->SetFont('Arial','B',11);
                        $pdf->SetX(25);
                        $pdf->Cell(176,7,utf8_decode('AL GRADO DE '.$algraof['nombre']),0,0,'L');
                        $pdf->Ln();
                        pg_result_seek($personal_ascensos_oficiales, 0);
                        while($ascof = pg_fetch_array($personal_ascensos_oficiales)){
                            if($ascof['graid'] == $algraof['graid']){
                                if($ascof['graid'] != 9){
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode($ascof['antof_grado'].$ascof['antof_estudio'].' '.$ascof['antof_nombre'].' '.$ascof['antof_paterno'].' '.$ascof['antof_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascof['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }else{
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode('CDTE. IV. '.$ascof['antof_nombre'].' '.$ascof['antof_paterno'].' '.$ascof['antof_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascof['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }
                            }
                        }
                    }
                }
                $pdf->AddPage();
                $pdf->SetFont('Arial','B',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('ASCENSOS EN LA CATEGORÍA DE SUBOFICIALES Y SARGENTOS.'),0);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('En cumplimiento al Art.65°. - Inciso ñ) de la Ley Orgánica de las FF.AA. de la Nación (LOFA. 1405), previa autorización del Señor Comandante en Jefe de las FF.AA., en conformidad del Señor Ministro de Defensa Nacional y la Aprobación del Señor Presidente Constitucional del Estado Plurinacional.'),0);
                while($escasoftec = pg_fetch_array($escalafon_softec)){
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetX(20);
                    $pdf->Cell(176,7,utf8_decode('ESCALAFÓN DE '.$escasoftec['nombre']),0,0,'L');
                    $pdf->Ln();
                    pg_result_seek($al_grado_softec, 0);
                    while($algrasoftec = pg_fetch_array($al_grado_softec)){
                        $pdf->SetFont('Arial','B',11);
                        $pdf->SetX(25);
                        $pdf->Cell(176,7,utf8_decode('AL GRADO DE '.$algrasoftec['nombre']),0,0,'L');
                        $pdf->Ln();
                        pg_result_seek($personal_ascensos_softec, 0);
                        while($ascsoftec = pg_fetch_array($personal_ascensos_softec)){
                            if($ascsoftec['graid'] == $algrasoftec['graid']){
                                if($ascsoftec['graid'] != 17){
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode($ascsoftec['antsoftec_grado'].$ascsoftec['antsoftec_estudio'].' '.$ascsoftec['antsoftec_nombre'].' '.$ascsoftec['antsoftec_paterno'].' '.$ascsoftec['antsoftec_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascsoftec['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }else{
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode('ALM. III. '.$ascsoftec['antsoftec_nombre'].' '.$ascsoftec['antsoftec_paterno'].' '.$ascsoftec['antsoftec_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascsoftec['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }
                            }
                        }
                    }
                }

                $pdf->AddPage();
                $pdf->SetFont('Arial','B',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('ASCENSOS EN LA CATEGORÍA DE SUBOFICIALES Y SARGENTOS DE MUSICA.'),0);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('En cumplimiento al Art.65°. - Inciso ñ) de la Ley Orgánica de las FF.AA. de la Nación (LOFA. 1405), previa autorización del Señor Comandante en Jefe de las FF.AA., en conformidad del Señor Ministro de Defensa Nacional y la Aprobación del Señor Presidente Constitucional del Estado Plurinacional.'),0);
                while($escasofmus = pg_fetch_array($escalafon_sofmus)){
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetX(20);
                    $pdf->Cell(176,7,utf8_decode('ESCALAFÓN DE '.$escasofmus['nombre']),0,0,'L');
                    $pdf->Ln();
                    pg_result_seek($al_grado_sofmus, 0);
                    while($algrasofmus = pg_fetch_array($al_grado_sofmus)){
                        $pdf->SetFont('Arial','B',11);
                        $pdf->SetX(25);
                        $pdf->Cell(176,7,utf8_decode('AL GRADO DE '.$algrasofmus['nombre']),0,0,'L');
                        $pdf->Ln();
                        pg_result_seek($personal_ascensos_sofmus, 0);
                        while($ascsofmus = pg_fetch_array($personal_ascensos_sofmus)){
                            if($ascsofmus['graid'] == $algrasofmus['graid']){
                                if($ascsofmus['graid'] != 172){
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode($ascsofmus['antsofmus_grado'].$ascsofmus['antsofmus_estudio'].' '.$ascsofmus['antsofmus_nombre'].' '.$ascsofmus['antsofmus_paterno'].' '.$ascsofmus['antsofmus_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascsofmus['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }else{
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode('ALM. III. '.$ascsofmus['antsofmus_nombre'].' '.$ascsofmus['antsofmus_paterno'].' '.$ascsofmus['antsofmus_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascsofmus['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }
                            }
                        }
                    }
                }

                $pdf->AddPage();
                $pdf->SetFont('Arial','B',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('ASCENSOS PARA SEÑORES OFICIALES, SUBOFICIALES Y SARGENTOS DE SERVICIOS.'),0);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('En cumplimiento al Art.65°. - Inciso ñ) de la Ley Orgánica de las FF.AA. de la Nación (LOFA. 1405), previa autorización del Señor Comandante en Jefe de las FF.AA., en conformidad del Señor Ministro de Defensa Nacional y la Aprobación del Señor Presidente Constitucional del Estado Plurinacional.'),0);
                while($escaserv = pg_fetch_array($escalafon_serv)){
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetX(20);
                    $pdf->Cell(176,7,utf8_decode('ESCALAFÓN DE '.$escaserv['nombre']),0,0,'L');
                    $pdf->Ln();
                    pg_result_seek($al_grado_serv, 0);
                    while($algraserv = pg_fetch_array($al_grado_serv)){
                        $pdf->SetFont('Arial','B',11);
                        $pdf->SetX(25);
                        $pdf->Cell(176,7,utf8_decode('AL GRADO DE '.$algraserv['nombre']),0,0,'L');
                        $pdf->Ln();
                        pg_result_seek($personal_ascensos_serv, 0);
                        while($ascserv = pg_fetch_array($personal_ascensos_serv)){
                            if($ascserv['graid'] == $algraserv['graid']){
                                if($ascserv['graid'] != 172){
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode($ascserv['antserv_grado'].$ascserv['antserv_estudio'].' '.$ascserv['antserv_nombre'].' '.$ascserv['antserv_paterno'].' '.$ascserv['antserv_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascserv['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }else{
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode('ALM. III. '.$ascserv['antserv_nombre'].' '.$ascserv['antserv_paterno'].' '.$ascserv['antserv_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascserv['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }
                            }
                        }
                    }
                }

                $pdf->AddPage();
                $pdf->SetFont('Arial','B',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('ASCENSOS PARA EL PERSONAL CIVIL.'),0);
                $pdf->Ln(2);
                $pdf->SetFont('Arial','',11);
                $pdf->SetX(20);
                $pdf->MultiCell(176,5,utf8_decode('En cumplimiento al Art.65°. - Inciso ñ) de la Ley Orgánica de las FF.AA. de la Nación (LOFA. 1405), previa autorización del Señor Comandante en Jefe de las FF.AA., en conformidad del Señor Ministro de Defensa Nacional y la Aprobación del Señor Presidente Constitucional del Estado Plurinacional.'),0);
                while($escaciv = pg_fetch_array($escalafon_civ)){
                    $pdf->SetFont('Arial','B',11);
                    $pdf->SetX(20);
                    $pdf->Cell(176,7,utf8_decode('ESCALAFÓN DE '.$escaciv['nombre']),0,0,'L');
                    $pdf->Ln();
                    pg_result_seek($al_grado_civ, 0);
                    while($algraciv = pg_fetch_array($al_grado_civ)){
                        $pdf->SetFont('Arial','B',11);
                        $pdf->SetX(25);
                        $pdf->Cell(176,7,utf8_decode('AL GRADO DE '.$algraciv['nombre']),0,0,'L');
                        $pdf->Ln();
                        pg_result_seek($personal_ascensos_civ, 0);
                        while($ascciv = pg_fetch_array($personal_ascensos_civ)){
                            if($ascciv['graid'] == $algraciv['graid']){
                                if($ascciv['graid'] != 172){
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode($ascciv['antciv_grado'].$ascciv['antciv_estudio'].' '.$ascciv['antciv_nombre'].' '.$ascciv['antciv_paterno'].' '.$ascciv['antciv_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascciv['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }else{
                                    $pdf->SetFont('Arial','',10);
                                    $pdf->SetX(30);
                                    $pdf->Cell(120,7,utf8_decode('ALM. III. '.$ascciv['antciv_nombre'].' '.$ascciv['antciv_paterno'].' '.$ascciv['antciv_materno']),0,0,'L');
                                    $pdf->SetX(150);
                                    $pdf->Cell(30,7,utf8_decode($ascciv['antigfin']),0,0,'R');
                                    $pdf->Ln();
                                }
                            }
                        }
                    }
                }
            }//FIN PARTE 1
            //INICIO PARTE 2
            elseif($i == 1){
                $pdf->AddPage();
                $pdf->SetX(20);
                // while($ent = pg_fetch_array($entidad)){
                //     $pdf->SetFont('Arial','B',10);
                //     $pdf->SetX(20);
                //     if($ent['ogd'] == 1){
                //     $pdf->Cell(176,7,utf8_decode($ent['descripcion']),0,0,'L');
                //     $pdf->Ln();
                //     }else{
                //         $pdf->Ln(0);
                //     }
                //     pg_result_seek($gran_unidad, 0);
                //     while($gu = pg_fetch_array($gran_unidad)){
                //         if($gu['d1cod'] == $ent['iddestn1']){
                //             $pdf->SetFont('Arial','B',9);
                //             $pdf->SetX(22,5);
                //             if($gu['ogd'] == 1){
                //             $pdf->Cell(176,7,utf8_decode($gu['descripcion']),0,0,'L');
                //             $pdf->Ln();
                //             }else{
                //                 $pdf->Ln(0);
                //             }
                //             pg_result_seek($reparticion, 0);
                //             while($rep = pg_fetch_assoc($reparticion)){
                //                 if($rep['d2cod'] == $gu['iddestn2']){
                //                     $pdf->SetFont('Arial','B',9);
                //                     $pdf->SetX(25);
                //                     if($rep['ogd'] == 1){
                //                     $pdf->Cell(176,7,utf8_decode($rep['descripcion']),0,0,'L');
                //                     $pdf->Ln();
                //                     }else{
                //                         $pdf->Ln(0);
                //                     }
                //                     pg_result_seek($subreparticion, 0);
                //                     while($subrep = pg_fetch_assoc($subreparticion)){
                //                         if($subrep['d3cod'] == $rep['iddestn3']){
                //                             $pdf->SetFont('Arial','B',9);
                //                             $pdf->SetX(27,5);
                //                             if($subrep['ogd'] == 1){
                //                             $pdf->Cell(176,7,utf8_decode($subrep['descripcion']),0,0,'L');
                //                             $pdf->Ln();
                //                             }else{
                //                                 $pdf->Ln(0);
                //                             }
                //                             pg_result_seek($personalDestinos1, 0);
                //                             while($pd1 = pg_fetch_assoc($personalDestinos1)){
                //                                 if($pd1['d4_cod'] == $subrep['iddestn4']){
                //                                     $pdf->SetFont('Arial','',9);
                //                                     $pdf->SetX(27,5);
                //                                     $pdf->Cell(100,7,utf8_decode($pd1['grado'].$pd1['complemento'].' '.$pd1['per_nombre'].' '.$pd1['per_paterno'].' '.$pd1['per_materno']),0,0,'L');
                //                                     $pdf->SetX(127,5);
                //                                     $pdf->Cell(40,7,utf8_decode($pd1['descripcion']),0,0,'L');
                //                                     pg_result_seek($personalDestinos2, 0);
                //                                     while($pd2 = pg_fetch_assoc($personalDestinos2)){
                //                                         if($pd2['idpersonal_destinos'] == $pd1['idpersonal_destinos']){
                //                                             $pdf->SetFont('Arial','',9);
                //                                             $pdf->SetX(165);
                //                                             if($pd2['idcargo'] != '369'){
                //                                             $pdf->Cell(36,7,utf8_decode($pd2['descripcion']),0,0,'L');
                //                                             }
                //                                         }
                //                                     }
                //                                     $pdf->Ln(); 
                //                                 }
                //                             }
                //                         }
                //                     }
                //                 }
                //             }
                //         }
                //     }
                // }
                $pdf->Ln();
            }//FIN PARTE 2
            //INICIO PARTE 3
            elseif($i == 2){
                $pdf->AddPage();
                $pdf->Ln(30);
                $pdf->SetFont('Arial','',12);
                $pdf->SetX(20);
                $pdf->Cell(115,5,utf8_decode('Gral.Div.Aé. Marcelo Juan Heredia Cuba'),0,0,'C');
                $pdf->Ln();
                $pdf->SetFont('Arial','B',12);
                $pdf->SetX(20);
                $pdf->Cell(115,5,utf8_decode('COMANDANTE GENERAL ACC. DE LA FUERZA AÉREA'),0,0,'C');
                $pdf->Ln(10);
                $pdf->SetFont('Arial','',12);
                $pdf->SetX(70);
                $pdf->Cell(125,5,utf8_decode('AUTORIZADO:'),0,0,'C');
                $pdf->Ln(30);
                $pdf->SetFont('Arial','',12);
                $pdf->SetX(70);
                $pdf->Cell(125,5,utf8_decode('Gral.Div.Aé. Cesar Moises Vallejos Rocha'),0,0,'C');
                $pdf->Ln();
                $pdf->SetFont('Arial','B',12);
                $pdf->SetX(70);
                $pdf->Cell(125,5,utf8_decode('COMANDANTE EN JEFE ACC. DE LAS FF.AA. DEL ESTADO'),0,0,'C');
                $pdf->Ln(10);
                $pdf->SetFont('Arial','',12);
                $pdf->SetX(20);
                $pdf->Cell(90,5,utf8_decode('ES CONFORME:'),0,0,'C');
                $pdf->Ln(30);
                $pdf->SetFont('Arial','',12);
                $pdf->SetX(20);
                $pdf->Cell(90,5,utf8_decode('Edmundo Novillo Aguilar'),0,0,'C');
                $pdf->Ln();
                $pdf->SetFont('Arial','B',12);
                $pdf->SetX(20);
                $pdf->Cell(90,5,utf8_decode('MINISTRO DE DEFENSA'),0,0,'C');
                $pdf->Ln(10);
                $pdf->SetFont('Arial','',12);
                $pdf->SetX(90);
                $pdf->Cell(100,5,utf8_decode('APROBADO:'),0,0,'C');
                $pdf->Ln(30);
                $pdf->SetFont('Arial','',12);
                $pdf->SetX(90);
                $pdf->Cell(100,5,utf8_decode('Lic. Luis Alberto Arce Catacora'),0,0,'C');
                $pdf->Ln();
                $pdf->SetFont('Arial','B',12);
                $pdf->SetX(90);
                $pdf->MultiCell(100,5,utf8_decode('PRESIDENTE DEL ESTADO PLURINACIONAL DE BOLIVIA Y CAPITÁN GENERAL DE LAS FUERZAS ARMADAS'),0,'C');
            }//FIN PARTE 3
            
            else{

            }
        }//FIN FOR
        $pdf->SetX(20);
        ob_clean();
        $pdf->SetX(20);
        $pdf->Output();
        $pdf->SetX(20);
        exit;
    }
}

class Pdf extends Fpdf
{
    public function Header()
    { 
        global $i;
        $this->Image('./img/comando_agua.png',33,61.5,150,150);

        if ($i == 0){ 
            $this->SetFont('Arial','B',12);
            $this->SetY(12);
            $this->SetX(20);
            $this->Cell(176,5,utf8_decode('- SECRETO -'),0,0,'C');
            $this->SetFont('Arial','B',8);
            $this->SetY(20);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('COMANDO EN JEFE DE LAS FUERZAS ARMADAS DEL ESTADO'),0,0,'C');
            $gestion=date("Y");
            $this->SetY(20);
            $this->SetX(20);
            $this->Cell(176,3,utf8_decode('CG. LA PAZ 31-DIC-'.$gestion),0,0,'R');
            $this->SetY(23);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('COMANDO GENERAL DE LA FUERZA AÉREA'),0,0,'C');
            $this->SetY(26);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('ESTADO MAYOR GENERAL DE LA FAB'),0,0,'C');
            $this->SetY(29);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('DEPARTAMENTO I - PERS. EMGFAB'),0,0,'C');
            $this->SetFont('Arial','BU',8);
            $this->SetY(32);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('BOLIVIA'),0,0,'C');
            $this->Ln(10);
            $this->SetFont('Arial','B',12);
            $this->SetX(20);
            $nrogestion=date("y");
            $this->Cell(176,7,utf8_decode('ORDEN GENERAL DE ASCENSOS 01/'.$nrogestion),0,2,'C');
            $this->SetFont('Arial','B',10);
            $this->SetX(20);
            $this->Cell(176,7,utf8_decode('PRIMERA PARTE'),0,2,'C');
            $this->SetFont('Arial','BU',10);
            $this->SetX(20);
            $this->Cell(176,7,utf8_decode('ASCENSOS'),0,2,'C');
            }
        if ($i == 1){ 
            $this->SetFont('Arial','B',12);
            $this->SetY(12);
            $this->SetX(20);
            $this->Cell(176,5,utf8_decode('- SECRETO -'),0,0,'C');
            $this->SetFont('Arial','B',8);
            $this->SetY(20);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('COMANDO EN JEFE DE LAS FUERZAS ARMADAS DEL ESTADO'),0,0,'C');
            $gestion=date("Y");
            $this->SetY(20);
            $this->SetX(20);
            $this->Cell(176,3,utf8_decode('CG. LA PAZ 31-DIC-'.$gestion),0,0,'R');
            $this->SetY(23);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('COMANDO GENERAL DE LA FUERZA AÉREA'),0,0,'C');
            $this->SetY(26);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('ESTADO MAYOR GENERAL DE LA FAB'),0,0,'C');
            $this->SetY(29);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('DEPARTAMENTO I - PERS. EMGFAB'),0,0,'C');
            $this->SetFont('Arial','BU',8);
            $this->SetY(32);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('BOLIVIA'),0,0,'C');
            $this->Ln(10);
            $this->SetFont('Arial','B',12);
            $this->SetX(20);
            $nrogestion=date("y");
            $this->Cell(176,7,utf8_decode('ORDEN GENERAL DE ASCENSOS 01/'.$nrogestion),0,2,'C');
            $this->SetFont('Arial','B',10);
            $this->SetX(20);
            $this->Cell(176,7,utf8_decode('SEGUNDA PARTE'),0,2,'C');
            $this->SetFont('Arial','BU',10);
            $this->SetX(20);
            $this->Cell(176,7,utf8_decode('CAMBIO DE ESCALAFON'),0,2,'C');
        }
        if ($i == 2){ 
            $this->SetFont('Arial','B',12);
            $this->SetY(12);
            $this->SetX(20);
            $this->Cell(176,5,utf8_decode('- SECRETO -'),0,0,'C');
            $this->SetFont('Arial','B',8);
            $this->SetY(20);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('COMANDO EN JEFE DE LAS FUERZAS ARMADAS DEL ESTADO'),0,0,'C');
            $gestion=date("Y");
            $this->SetY(20);
            $this->SetX(20);
            $this->Cell(176,3,utf8_decode('CG. LA PAZ 31-DIC-'.$gestion),0,0,'R');
            $this->SetY(23);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('COMANDO GENERAL DE LA FUERZA AÉREA'),0,0,'C');
            $this->SetY(26);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('ESTADO MAYOR GENERAL DE LA FAB'),0,0,'C');
            $this->SetY(29);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('DEPARTAMENTO I - PERS. EMGFAB'),0,0,'C');
            $this->SetFont('Arial','BU',8);
            $this->SetY(32);
            $this->SetX(20);
            $this->Cell(88,3,utf8_decode('BOLIVIA'),0,0,'C');
            $this->Ln(10);
            $this->SetFont('Arial','B',12);
            $this->SetX(20);
            $nrogestion=date("y");
            $this->Cell(176,7,utf8_decode('ORDEN GENERAL DE ASCENSOS 01/'.$nrogestion),0,2,'C');
            $this->SetFont('Arial','B',10);
            $this->SetX(20);
            $this->Cell(176,7,utf8_decode('TERCERA PARTE'),0,2,'C');
            $this->SetFont('Arial','BU',10);
            $this->SetX(20);
            $this->Cell(176,7,utf8_decode('FIRMAS'),0,2,'C');
        }
    }
    public function Footer()
    {
        $this->SetFont('Arial','B',12);
        $this->SetY(-15);
        $this->SetX(20);
        $this->Cell(176,5,utf8_decode('- SECRETO -'),0,0,'C');
        $this->SetFont('Arial','B',10);
        $this->SetY(-11);
        $this->SetX(20);
        $this->Cell(176,5,$this->PageNo().' '.'-'.' '.'{nb}',0,0,'C');
    }
}


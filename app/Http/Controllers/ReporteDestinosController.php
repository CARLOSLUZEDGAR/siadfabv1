<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;
//use App\Pdf;
use App\Http\Controllers\createindex;


class ReporteDestinosController extends createindex
{
    public function createPDF(Request $request)
    {
        // $conn = pg_pconnect('host=192.168.3.81 port=5432 dbname=sipefab_prod user=postgres password=4$Ku8&_d@B/9in*0w%');
        $conn = pg_pconnect('host=127.0.0.1 port=5433 dbname=asigDestinosdb user=postgres password=lu12ed29');

        $gestion_actual = date("Y");
        // $gestion_actual = 2008;

        //CONSULTAS 1RA PARTE
        // $situacion = pg_query($conn,"SELECT s.id as ids,
        //                         s.nombre,
        //                         s.ogd
        //                         FROM situaciones as s
        //                         INNER JOIN personal_situaciones as ps ON ps.sit_cod = s.id
        //                         WHERE ps.estado = 1 
        //                         AND date_part('YEAR',ps.fecha_documento)=$gestion_actual
        //                         group by 
        //                         s.nombre,
        //                         ps.sit_cod,
        //                         s.id,
        //                         s.ogd
        //                         ORDER BY ps.sit_cod");

        // $subsituacion = pg_query($conn,"SELECT sb.id as subsitid,
        //                         sb.nombre as nomsb,
        //                         sb.sit_cod as siid,
        //                         sb.ogd
        //                         FROM subsituaciones as sb
        //                         INNER JOIN personal_situaciones as ps ON ps.subsit_cod = sb.id
        //                         INNER JOIN situaciones as s ON s.id = ps.sit_cod
        //                         WHERE ps.estado = 1 
        //                         AND date_part('YEAR',ps.fecha_documento)=$gestion_actual
        //                         group by
        //                         ps.subsit_cod,
        //                         sb.id,
        //                         sb.nombre,
        //                         sb.sit_cod,
        //                         sb.ogd
        //                         ORDER BY ps.subsit_cod");

        // $detalle_situacion = pg_query($conn,"SELECT ds.id as dsid,
        //                             ds.nombre as nomds,
        //                             ds.subsit_cod,
        //                             ds.articulo,
        //                             ds.ogd
        //                             FROM detalle_situaciones as ds
        //                             INNER JOIN personal_situaciones as ps ON ps.detsit_cod = ds.id
        //                             INNER JOIN subsituaciones as sb ON sb.id =ps.subsit_cod
        //                             WHERE ps.estado = 1 
        //                             AND date_part('YEAR',ps.fecha_documento)=$gestion_actual
        //                             GROUP BY
        //                             ps.detsit_cod,
        //                             ds.id,
        //                             ds.nombre,
        //                             ds.subsit_cod,
        //                             ds.articulo,
        //                             ds.ogd
        //                             ORDER BY ps.detsit_cod");

        // $escalafon = pg_query($conn,"SELECT escalafones.id as escid,
        //                             escalafones.nombre as nomesc 
        //                             FROM personals 
        //                             INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo 
        //                             INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
        //                             INNER JOIN escalafones ON personal_escalafones.esca_cod = escalafones.id 
        //                             INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id 
        //                             WHERE personal_situaciones.estado = 1 
        //                             AND personal_escalafones.estado = 1 
        //                             AND date_part('YEAR',personal_situaciones.fecha_documento)='2019'
        //                             AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
        //                             GROUP BY escalafones.id,escalafones.nombre
        //                             ORDER BY escalafones.id");

        // $personal_situacion = pg_query($conn,"SELECT detalle_situaciones.id as detsitid,
        //                             detalle_situaciones.articulo, 
        //                             situaciones.nombre as nomsit, 
        //                             subsituaciones.nombre as nomsubsit, 
        //                             detalle_situaciones.nombre as nomdetsit, 
        //                             escalafones.id as escid,
        //                             escalafones.nombre as nomesc, 
        //                             subescalafones.nombre as nomsubesc,
        //                             REPLACE(grados.abreviatura,'...','.') as grado, 
        //                             REPLACE(estudios.abreviatura,'.',' ') as complemento,
        //                             personals.per_nombre,
        //                             personals.per_paterno,
        //                             personals.per_materno, 
        //                             personal_situaciones.fecha_documento 
        //                             FROM personals 
        //                             INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo 
        //                             INNER JOIN situaciones ON personal_situaciones.sit_cod = situaciones.id 
        //                             INNER JOIN subsituaciones ON personal_situaciones.subsit_cod = subsituaciones.id 
        //                             INNER JOIN detalle_situaciones ON personal_situaciones.detsit_cod = detalle_situaciones.id 
        //                             INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
        //                             INNER JOIN escalafones ON personal_escalafones.esca_cod = escalafones.id 
        //                             INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id 
        //                             INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
        //                             INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
        //                             INNER JOIN estudios ON personal_estudios.est_cod = estudios.id
        //                             WHERE personal_situaciones.estado = 1 
        //                             AND personal_escalafones.estado = 1 
        //                             AND personal_estudios.estado = 1 
        //                             AND date_part('YEAR',personal_situaciones.fecha_documento)=$gestion_actual
        //                             AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
        //                             ORDER BY personal_situaciones.sit_cod,
        //                             personal_situaciones.subsit_cod,
        //                             personal_situaciones.detsit_cod, 
        //                             personal_escalafones.esca_cod,
        //                             personal_escalafones.subesc_cod,
        //                             personal_escalafones.gra_cod,
        //                             SUBSTRING(personals.per_cm,1,3),
        //                             SUBSTRING(personals.per_cm,4,2),
        //                             SUBSTRING(personals.per_cm,7,2),
        //                             personal_estudios.est_cod");

        // $promocion_reserva_activa = pg_query($conn,"SELECT personal_situaciones.promo
        //                             FROM personals 
        //                             INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo 
        //                             INNER JOIN situaciones ON personal_situaciones.sit_cod = situaciones.id 
        //                             INNER JOIN subsituaciones ON personal_situaciones.subsit_cod = subsituaciones.id 
        //                             INNER JOIN detalle_situaciones ON personal_situaciones.detsit_cod = detalle_situaciones.id 
        //                             WHERE personal_situaciones.estado = 1 
        //                             AND personal_situaciones.sit_cod = 1 
        //                             AND personal_situaciones.subsit_cod = 2 
        //                             AND personal_situaciones.detsit_cod = 6
        //                             AND date_part('YEAR',personal_situaciones.fecha_documento) BETWEEN $gestion_actual-3 AND $gestion_actual 
        //                             AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
        //                             GROUP BY personal_situaciones.promo
        //                             ORDER BY personal_situaciones.promo");
            
        // $reserva_activa = pg_query($conn,"SELECT detalle_situaciones.articulo, 
        //                                         situaciones.nombre, 
        //                                         subsituaciones.nombre, 
        //                                         detalle_situaciones.nombre, 
        //                                         escalafones.nombre, 
        //                                         subescalafones.nombre,
        //                                         REPLACE(grados.abreviatura,'...','.') as grado, 
        //                                         REPLACE(estudios.abreviatura,'.',' ') as complemento,
        //                                         personals.per_nombre,
        //                                         personals.per_paterno,
        //                                         personals.per_materno, 
        //                                         personal_situaciones.fecha_documento,
        //                                         personal_situaciones.promo
        //                                     FROM personals 
        //                                     INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo 
        //                                     INNER JOIN situaciones ON personal_situaciones.sit_cod = situaciones.id 
        //                                     INNER JOIN subsituaciones ON personal_situaciones.subsit_cod = subsituaciones.id 
        //                                     INNER JOIN detalle_situaciones ON personal_situaciones.detsit_cod = detalle_situaciones.id 
        //                                     INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
        //                                     INNER JOIN escalafones ON personal_escalafones.esca_cod = escalafones.id 
        //                                     INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id 
        //                                     INNER JOIN grados ON personal_escalafones.gra_cod = grados.id 
        //                                     INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
        //                                     INNER JOIN estudios ON personal_estudios.est_cod= estudios.id
        //                                     WHERE personal_situaciones.estado = 1 
        //                                     AND personal_escalafones.estado = 1 
        //                                     AND personal_estudios.estado = 1 
        //                                     AND personal_situaciones.sit_cod = 1 
        //                                     AND personal_situaciones.subsit_cod = 2 
        //                                     AND personal_situaciones.detsit_cod = 6
        //                                     AND date_part('YEAR',personal_situaciones.fecha_documento) BETWEEN $gestion_actual-3 AND $gestion_actual 
        //                                     AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
        //                                     ORDER BY personal_situaciones.promo,
        //                                             personal_escalafones.esca_cod,
        //                                             personal_escalafones.subesc_cod,
        //                                             personal_escalafones.gra_cod,
        //                                             personal_situaciones.sit_cod,
        //                                             personal_situaciones.subsit_cod,
        //                                             personal_situaciones.detsit_cod, 
        //                                             SUBSTRING(personals.per_cm,1,3),
        //                                             SUBSTRING(personals.per_cm,4,2),
        //                                             SUBSTRING(personals.per_cm,7,2),
        //                                             personal_estudios.est_cod");
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
                            $entidad2 = pg_query($conn,"SELECT 
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
        // $diplomas = pg_query($conn,"SELECT desgloce_cursos.descripcion,
        //                                     desgloce_cursos.id as desgid,
        //                                     tipo_cursos.id as tipcurid
        //                                     FROM personals 
        //                                     INNER JOIN personal_cursos ON personals.per_codigo = personal_cursos.per_codigo 
        //                                     INNER JOIN tipo_cursos ON personal_cursos.tipcur_cod = tipo_cursos.id
        //                                     INNER JOIN desgloce_cursos on desgloce_cursos.id = personal_cursos.desgcur_cod
        //                                     WHERE
        //                                     (personal_cursos.tipcur_cod=98 OR personal_cursos.tipcur_cod=5 OR personal_cursos.tipcur_cod=6 OR personal_cursos.tipcur_cod=8 OR personal_cursos.tipcur_cod=9 OR personal_cursos.tipcur_cod=3 OR personal_cursos.tipcur_cod=4 OR personal_cursos.tipcur_cod=20 OR personal_cursos.tipcur_cod=21 OR personal_cursos.tipcur_cod=160 OR personal_cursos.tipcur_cod=19 OR personal_cursos.tipcur_cod=158 OR personal_cursos.tipcur_cod=159 OR personal_cursos.tipcur_cod=104 OR personal_cursos.tipcur_cod=105 OR personal_cursos.tipcur_cod=155 OR personal_cursos.tipcur_cod=151 OR personal_cursos.tipcur_cod=153 OR personal_cursos.tipcur_cod=154 OR personal_cursos.tipcur_cod=161) 
        //                                     AND date_part('YEAR',personal_cursos.fecha_otorgacion)=$gestion_actual
        //                                     group by 
        //                                     desgloce_cursos.descripcion,
        //                                     desgloce_cursos.id,
        //                                     tipo_cursos.id,
        //                                     tipo_cursos.orden_dip
        //                                     order by tipo_cursos.orden_dip");
        // $personal_diplomas = pg_query($conn,"SELECT tipo_cursos.descripcion, 
        //                                     tipo_cursos.id as tipcurid,
        //                                     desgloce_cursos.id as desgid,
        //                                     REPLACE(grados.abreviatura,'..','.') as grado,
        //                                     REPLACE(estudios.abreviatura,'.',' ') as complemento,
        //                                     personals.per_nombre,
        //                                     personals.per_paterno,
        //                                     personals.per_materno, 
        //                                     personal_cursos.fecha_otorgacion as fecha
        //                                 FROM personals 
        //                                     INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
        //                                     INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
        //                                     INNER JOIN grados ON personal_escalafones.gra_cod = grados.id
        //                                     INNER JOIN estudios ON personal_estudios.est_cod = estudios.id 
        //                                     INNER JOIN personal_cursos ON personals.per_codigo = personal_cursos.per_codigo 
        //                                     INNER JOIN tipo_cursos ON personal_cursos.tipcur_cod = tipo_cursos.id
        //                                     INNER JOIN desgloce_cursos ON personal_cursos.desgcur_cod = desgloce_cursos.id
        //                                 WHERE personal_escalafones.estado=1 
        //                                 AND personal_estudios.estado=1 
        //                                 AND (personal_cursos.tipcur_cod=98 OR personal_cursos.tipcur_cod=5 OR personal_cursos.tipcur_cod=6 OR personal_cursos.tipcur_cod=8 OR personal_cursos.tipcur_cod=9 OR personal_cursos.tipcur_cod=3 OR personal_cursos.tipcur_cod=4 OR personal_cursos.tipcur_cod=20 OR personal_cursos.tipcur_cod=21 OR personal_cursos.tipcur_cod=160 OR personal_cursos.tipcur_cod=19 OR personal_cursos.tipcur_cod=158 OR personal_cursos.tipcur_cod=159 OR personal_cursos.tipcur_cod=104 OR personal_cursos.tipcur_cod=105 OR personal_cursos.tipcur_cod=155 OR personal_cursos.tipcur_cod=151 OR personal_cursos.tipcur_cod=153 OR personal_cursos.tipcur_cod=154 OR personal_cursos.tipcur_cod=161) 
        //                                 AND date_part('YEAR',personal_cursos.fecha_otorgacion)=$gestion_actual
        //                                 AND personal_escalafones.esca_cod=1 
        //                                 ORDER BY tipo_cursos.orden_dip, 
        //                                     personal_escalafones.esca_cod, 
        //                                     personal_escalafones.subesc_cod,
        //                                     personal_escalafones.gra_cod,
        //                                     SUBSTRING(personals.per_cm,1,3),
        //                                     SUBSTRING(personals.per_cm,4,2),
        //                                     SUBSTRING(personals.per_cm,6,3)");

        // $brevet = pg_query($conn,"SELECT brevets.descripcion, 
        //                 brevets.id as breid
        //                 FROM personals 
        //                 INNER JOIN personal_brevets ON personals.per_codigo = personal_brevets.per_codigo 
        //                 INNER JOIN brevets ON personal_brevets.brevet_cod = brevets.id 
        //                 WHERE brevets.clasificacion='BR' 
        //                 AND (personal_brevets.brevet_cod=38 OR 
        //                 personal_brevets.brevet_cod=39 OR 
        //                 personal_brevets.brevet_cod=40 OR 
        //                 personal_brevets.brevet_cod=41 OR  
        //                 personal_brevets.brevet_cod=42 OR 
        //                 personal_brevets.brevet_cod=43 OR 
        //                 personal_brevets.brevet_cod=4 OR 
        //                 personal_brevets.brevet_cod=5 OR 
        //                 personal_brevets.brevet_cod=6 OR 
        //                 personal_brevets.brevet_cod=9 OR
        //                 personal_brevets.brevet_cod=10 OR
        //                 personal_brevets.brevet_cod=27 OR 
        //                 personal_brevets.brevet_cod=28 OR 
        //                 personal_brevets.brevet_cod=29 OR
        //                 personal_brevets.brevet_cod=30 OR
        //                 personal_brevets.brevet_cod=22 OR
        //                 personal_brevets.brevet_cod=12 OR
        //                 personal_brevets.brevet_cod=13 OR
        //                 personal_brevets.brevet_cod=14 OR
        //                 personal_brevets.brevet_cod=15)
        //                 AND date_part('YEAR',personal_brevets.fecha_imposicion) = $gestion_actual
        //                 --AND personals.per_codigo=393
        //                 group by brevets.descripcion, 
        //                 brevets.id
        //                 ORDER BY brevets.id");
        // $personal_brevets = pg_query($conn,"SELECT brevets.descripcion, 
        //                                     brevets.id as breid,
        //                                     REPLACE(grados.abreviatura,'..','.') as grado,
        //                                     REPLACE(estudios.abreviatura,'.',' ') as complemento,
        //                                     personals.per_nombre,
        //                                     personals.per_paterno,
        //                                     personals.per_materno,
        //                                     personals.per_codigo as pcod, 
        //                                     subescalafones.id, 
        //                                     personal_brevets.fecha_imposicion as fecha
        //                                     FROM personals 
        //                                     INNER JOIN personal_escalafones ON personals.per_codigo = personal_escalafones.per_codigo 
        //                                     INNER JOIN personal_estudios ON personals.per_codigo = personal_estudios.per_codigo 
        //                                     INNER JOIN personal_brevets ON personals.per_codigo = personal_brevets.per_codigo 
        //                                     INNER JOIN brevets ON personal_brevets.brevet_cod = brevets.id 
        //                                     INNER JOIN estudios ON personal_estudios.est_cod = estudios.id 
        //                                     INNER JOIN grados ON personal_escalafones.gra_cod = grados.id
        //                                     INNER JOIN subescalafones ON personal_escalafones.subesc_cod = subescalafones.id
        //                                     INNER JOIN personal_situaciones ON personals.per_codigo = personal_situaciones.per_codigo
        //                                     WHERE brevets.clasificacion='BR' 
        //                                     AND personal_escalafones.estado = 1 
        //                                     AND personal_estudios.estado = 1 
        //                                     AND personal_situaciones.sit_cod = 1 
        //                                     AND personal_situaciones.subsit_cod = 1 
        //                                     AND personal_situaciones.estado = 1 
        //                                     AND (SUBSTRING(personals.per_cm,1,1)='1' OR SUBSTRING(personals.per_cm,1,1)='3' OR SUBSTRING(personals.per_cm,1,1)='5')
        //                                     AND (personal_brevets.brevet_cod=38 OR 
        //                                     personal_brevets.brevet_cod=39 OR 
        //                                     personal_brevets.brevet_cod=40 OR 
        //                                     personal_brevets.brevet_cod=41 OR  
        //                                     personal_brevets.brevet_cod=42 OR 
        //                                     personal_brevets.brevet_cod=43 OR 
        //                                     personal_brevets.brevet_cod=4 OR 
        //                                     personal_brevets.brevet_cod=5 OR 
        //                                     personal_brevets.brevet_cod=6 OR 
        //                                     personal_brevets.brevet_cod=9 OR
        //                                     personal_brevets.brevet_cod=10 OR
        //                                     personal_brevets.brevet_cod=27 OR 
        //                                     personal_brevets.brevet_cod=28 OR 
        //                                     personal_brevets.brevet_cod=29 OR
        //                                     personal_brevets.brevet_cod=30 OR
        //                                     personal_brevets.brevet_cod=22 OR
        //                                     personal_brevets.brevet_cod=12 OR
        //                                     personal_brevets.brevet_cod=13 OR
        //                                     personal_brevets.brevet_cod=14 OR
        //                                     personal_brevets.brevet_cod=15)
        //                                     AND date_part('YEAR',personal_brevets.fecha_imposicion) = $gestion_actual
        //                                     --AND personals.per_codigo=393
        //                                     ORDER BY brevets.id,
        //                                     personal_escalafones.esca_cod, 
        //                                     subescalafones.id,
        //                                     personal_escalafones.gra_cod");

        $pdf = new ReporteDestinosController ('P','mm','Letter');
        $title = 'ORDEN DE DESTINOS';
        $pdf->SetTitle($title);
        $pdf->SetX(20);
        $pdf->AliasNbPages();
        $fecha = date("dHi-M-Y");
        $alias = '{nb}';
        $at = intval($alias) - 1;
        $pdf->Ln(5);

        global $p;
        global $pagina;
        for ( $p=0; $p<=6; $p++) { 
            //INCIO PARTE 1
            if($p == 0){
                // $pdf->StartPageGroup();
                // $pdf->AddPage();
                // $pdf->SetY(20);
                // $pdf->SetX(30);
                // $pdf->Cell(166,239,'',1,0,'L');
                // $pdf->SetY(21);
                // $pdf->SetX(31);
                // $pdf->Cell(164,237,'',1,0,'L');
                // $pdf->SetFont('Arial','B',12);
                // $pdf->SetY(30);
                // $pdf->SetX(35);
                // $pdf->Cell(86,5,utf8_decode('FUERZA AÉREA BOLIVIANA'),0,0,'C');
                // $pdf->SetY(35);
                // $pdf->SetX(35);
                // $pdf->Cell(86,5,utf8_decode('DEPARTAMENTO I - PERSONAL EMGFAB.'),0,0,'C');
                // $pdf->SetFont('Arial','BU',12);
                // $pdf->SetY(40);
                // $pdf->SetX(35);
                // $pdf->Cell(86,5,utf8_decode('BOLIVIA'),0,0,'C');
                // $pdf->Image('./img/gallineta_sinfondo.png',40,50,146,80);
                // $pdf->SetFont('Arial','B',30);
                // $pdf->SetY(140);
                // $pdf->SetX(30);
                // $pdf->Cell(166,15,utf8_decode('ORDEN GENERAL'),0,0,'C');
                // $pdf->SetY(155);
                // $pdf->SetX(30);
                // $pdf->Cell(166,15,utf8_decode('DE DESTINOS'),0,0,'C');
                // $pdf->SetFont('Arial','B',20);
                // $pdf->SetY(190);
                // $pdf->SetX(30);
                // $gestion_abreviada = date("y");
                // $pdf->Cell(166,15,utf8_decode('Nº 02/'.$gestion_abreviada),0,0,'C');
                // $pdf->SetY(230);
                // $pdf->SetX(30);
                // $orden_gestion = $gestion_actual + 1;
                // $pdf->Cell(166,15,utf8_decode('PARA LA GESTIÓN '.$orden_gestion),0,0,'C');
                // $pdf->Ln();
            }
            elseif($p == 1){
                // $pdf->StartPageGroup();
                // $pdf->AddPage();
                // $pdf->SetX(20);
                // $pdf->Bookmark(utf8_decode('PRIMERA PARTE'),false);
                // $pdf->Bookmark(utf8_decode('DE LA SITUACIÓN MILITAR'),false);
                // while($sit = pg_fetch_array($situacion)){
                //     $pdf->SetFont('Arial','B',10);
                //     $pdf->SetX(20);
                //     if($sit['ogd'] == 1){
                //     $pdf->Bookmark(utf8_decode($sit['nombre']),false,1);
                //     $pdf->Cell(176,7,utf8_decode($sit['nombre']),0,0,'L');
                //     $pdf->Ln();
                //     }else{
                //         $pdf->Ln(0);
                //     }
                //     // $pdf->Ln();
                //     pg_result_seek($subsituacion, 0);
                //     while($subsit = pg_fetch_array($subsituacion)){
                //         if($sit['ids'] == $subsit['siid']){
                //             $pdf->SetFont('Arial','B',9);
                //             $pdf->SetX(25);
                //             if($subsit['ogd'] == 1){
                //             $pdf->Bookmark(utf8_decode($subsit['nomsb']),false,2);
                //             $pdf->Cell(176,7,utf8_decode($subsit['nomsb']),0,0,'L');
                //             $pdf->Ln();
                //             }else{
                //                 $pdf->Ln(0);
                //             }
                //             pg_result_seek($detalle_situacion, 0);
                //             while($ds = pg_fetch_array($detalle_situacion)){
                //                 if($ds['subsit_cod'] == $subsit['subsitid']){
                //                     $pdf->SetFont('Arial','B',9);
                //                     $pdf->SetX(30);
                //                     if($ds['ogd'] == 1){
                //                     $pdf->Bookmark(utf8_decode($ds['nomds']),false,3);
                //                     $pdf->Cell(176,7,utf8_decode($ds['nomds']),0,0,'L');
                //                     $pdf->Ln();                           
                //                     }else{
                //                         $pdf->Ln(0);
                //                     }                          
                //                     $pdf->SetFont('Arial','B',9);
                //                     $pdf->SetX(35);
                //                     if($ds['articulo'] != 'SIN ARTICULOS'){
                //                         $pdf->Cell(176,7,utf8_decode($ds['articulo']),0,0,'L');
                //                         $pdf->Ln();
                //                         pg_result_seek($promocion_reserva_activa, 0);
                //                         if($ds['dsid'] == 6){
                //                             while($pra = pg_fetch_array($promocion_reserva_activa)){
                //                                 $pdf->SetFont('Arial','B',9);
                //                                 $pdf->SetX(35);
                //                                 $pdf->Cell(176,7,utf8_decode('PROMOCIÓN "'.$pra['promo'].'"'),0,0,'L');
                //                                 $pdf->Ln();
                //                                 pg_result_seek($reserva_activa, 0);
                //                                 while($ra = pg_fetch_array($reserva_activa)){
                //                                     if($ra['promo'] == $pra['promo']){
                //                                         $pdf->SetFont('Arial','',9);
                //                                         $pdf->SetX(35);
                //                                         $pdf->Cell(110,7,utf8_decode($ra['grado'].$ra['complemento'].' '.$ra['per_nombre'].' '.$ra['per_paterno'].' '.$ra['per_materno']),0,0,'L');
                //                                         $pdf->SetX(145);
                //                                         $fechadoc=$ra['fecha_documento'];
                //                                         $fecha_documento = date('d/m/Y',strtotime($fechadoc));
                //                                         $pdf->Cell(51,7,utf8_decode($fecha_documento),0,0,'C');
                //                                         $pdf->Ln();
                //                                     }
                //                                 }
                //                             }                       
                //                         }
                //                     }else{
                //                         $pdf->Ln(0);
                //                     }
                //                     // pg_result_seek($escalafon,0);
                //                     // while($esc = pg_fetch_array($escalafon)){
                //                     //     $pdf->SetFont('Arial','B',9);
                //                     //     $pdf->SetX(35);
                //                     //     $pdf->Cell(176,7,utf8_decode('ESCALAFON DE '.$esc['nomesc']),0,0,'L');
                //                     //     $pdf->Ln();
                //                         pg_result_seek($personal_situacion, 0);
                //                         while($ps = pg_fetch_array($personal_situacion)){
                //                             // if($ps['detsitid'] == $ds['dsid'] && $esc['escid'] == $ps['escid']){
                //                             if($ps['detsitid'] == $ds['dsid']){
                //                                 if($ps['detsitid'] != 6){
                //                                     $pdf->SetFont('Arial','',9);
                //                                     $pdf->SetX(35);
                //                                     $pdf->Cell(110,7,utf8_decode($ps['grado'].$ps['complemento'].' '.$ps['per_nombre'].' '.$ps['per_paterno'].' '.$ps['per_materno']),0,0,'L');
                //                                     $pdf->SetX(145);
                //                                     $fechadoc=$ps['fecha_documento'];
                //                                     $fecha_documento = date('d/m/Y',strtotime($fechadoc));
                //                                     $pdf->Cell(51,7,utf8_decode($fecha_documento),0,0,'C');
                //                                     $pdf->Ln();
                //                                 }else{
                                                    
                //                                 }
                //                             }
                //                         }
                //                     // }  
                //                 }
                //             }
                //         }
                //     }
                // }
            }//FIN PARTE 1
            //INICIO PARTE 2
            elseif($p == 2){
                $pdf->StartPageGroup();
                $pdf->AddPage();
                $pdf->SetX(20);
                $pdf->Bookmark(utf8_decode('SEGUNDA PARTE'),false);
                $pdf->Bookmark(utf8_decode('DE LOS DESTINOS'),false);
                while($ent = pg_fetch_array($entidad)){
                    $pdf->SetFont('Arial','B',10);
                    $pdf->SetX(20);
                    if($ent['ogd'] == 1){
                    $pdf->Bookmark(utf8_decode($ent['descripcion']),false,1);
                    $pdf->Cell(176,7,utf8_decode($ent['descripcion']),0,0,'L');
                    $pdf->Ln();
                    }else{
                        $pdf->Ln(0);
                    }
                    pg_result_seek($gran_unidad, 0);
                    while($gu = pg_fetch_array($gran_unidad)){
                        if($gu['d1cod'] == $ent['iddestn1']){
                            $pdf->SetFont('Arial','B',9);
                            $pdf->SetX(22,5);
                            if($gu['ogd'] == 1){
                            $pdf->Bookmark(utf8_decode($gu['descripcion']),false,2);
                            $pdf->Cell(176,7,utf8_decode($gu['descripcion']),0,0,'L');
                            $pdf->Ln();
                            }else{
                                $pdf->Ln(0);
                            }
                            pg_result_seek($reparticion, 0);
                            while($rep = pg_fetch_assoc($reparticion)){
                                if($rep['d2cod'] == $gu['iddestn2']){
                                    $pdf->SetFont('Arial','B',9);
                                    $pdf->SetX(25);
                                    if($rep['ogd'] == 1){
                                    $pdf->Bookmark(utf8_decode($rep['descripcion']),false,3);
                                    $pdf->Cell(176,7,utf8_decode($rep['descripcion']),0,0,'L');
                                    $pdf->Ln();
                                    }else{
                                        $pdf->Ln(0);
                                    }
                                    pg_result_seek($subreparticion, 0);
                                    while($subrep = pg_fetch_assoc($subreparticion)){
                                        if($subrep['d3cod'] == $rep['iddestn3']){
                                            $pdf->SetFont('Arial','B',9);
                                            $pdf->SetX(27,5);
                                            if($subrep['ogd'] == 1){
                                            $pdf->Cell(176,7,utf8_decode($subrep['descripcion']),0,0,'L');
                                            $pdf->Ln();
                                            }else{
                                                $pdf->Ln(0);
                                            }
                                            pg_result_seek($personalDestinos1, 0);
                                            while($pd1 = pg_fetch_assoc($personalDestinos1)){
                                                if($pd1['d4_cod'] == $subrep['iddestn4']){
                                                    $pdf->SetFont('Arial','',9);
                                                    $pdf->SetX(27,5);
                                                    $pdf->Cell(100,7,utf8_decode($pd1['grado'].$pd1['complemento'].' '.$pd1['per_nombre'].' '.$pd1['per_paterno'].' '.$pd1['per_materno']),0,0,'L');
                                                    $pdf->SetX(127,5);
                                                    $pdf->Cell(40,7,utf8_decode($pd1['descripcion']),0,0,'L');
                                                    pg_result_seek($personalDestinos2, 0);
                                                    while($pd2 = pg_fetch_assoc($personalDestinos2)){
                                                        if($pd2['idpersonal_destinos'] == $pd1['idpersonal_destinos']){
                                                            $pdf->SetFont('Arial','',9);
                                                            $pdf->SetX(170);
                                                            if($pd2['idcargo'] != '369'){
                                                            $pdf->Cell(45,7,utf8_decode($pd2['descripcion']),0,0,'L');
                                                            }
                                                        }
                                                    }
                                                    $pdf->Ln(); 
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $pdf->Ln();
            }//FIN PARTE 2
            //INICIO PARTE 3
            elseif($p == 3){
                // // $pdf->StartPageGroup();
                // $pdf->AddPage();
                // $pdf->Bookmark(utf8_decode('TERCERA PARTE'),false);
                // $pdf->Bookmark(utf8_decode('DE LOS TITULOS Y DIPLOMAS'),false);
                // $pdf->SetFont('Arial','B',10);
                // $pdf->SetX(20);
                // $pdf->Bookmark(utf8_decode('DIPLOMAS'),false,1);
                // $pdf->Cell(176,7,utf8_decode('I.        DIPLOMAS'),0,0,'L');
                // $pdf->Ln();
                // $letradip = 'A';
                // $a = 0;
                // while ($dip = pg_fetch_array($diplomas)) {
                //     $pdf->SetFont('Arial','B',9);
                //     $pdf->SetX(30);
                //     $pdf->Cell(10,7,utf8_decode($letradip.'.'),0,0,'L');
                //     $pdf->Bookmark(utf8_decode($dip['descripcion']),false,2);
                //     $pdf->Cell(156,7,utf8_decode($dip['descripcion']),0,0,'L');
                //     $letradip++;
                //     $pdf->Ln();
                //     pg_result_seek($personal_diplomas, 0);
                //     while($perdip = pg_fetch_assoc($personal_diplomas)){
                //         if($perdip['desgid'] == $dip['desgid']){
                //             $pdf->SetFont('Arial','',9);
                //             $pdf->SetX(40);
                //             $pdf->Cell(156,7,utf8_decode($perdip['grado'].$perdip['complemento'].' '.$perdip['per_nombre'].' '.$perdip['per_paterno'].' '.$perdip['per_materno']),0,0,'L');
                //             $pdf->Ln();
                //         }
                //     }
                // }
                // $pdf->SetFont('Arial','B',10);
                // $pdf->SetX(20);
                // $pdf->Bookmark(utf8_decode('BREVETS'),false,1);
                // $pdf->Cell(176,7,utf8_decode('II.        BREVETS'),0,0,'L');
                // $pdf->Ln();
                // $letrabrev = 'A';
                // $b = 0;
                // while ($bre = pg_fetch_array($brevet)) {
                //     $pdf->SetFont('Arial','B',9);
                //     $pdf->SetX(30);
                //     $pdf->Cell(10,7,utf8_decode($letrabrev.'.'),0,0,'L');
                //     $pdf->Bookmark(utf8_decode($bre['descripcion']),false,2);
                //     $pdf->Cell(156,7,utf8_decode($bre['descripcion']),0,0,'L');
                //     $letrabrev++;
                //     $pdf->Ln();
                //     pg_result_seek($personal_brevets, 0);
                //     while($perbre = pg_fetch_assoc($personal_brevets)){
                //         if($perbre['breid'] == $bre['breid']){
                //             $pdf->SetFont('Arial','',9);
                //             $pdf->SetX(40);
                //             $pdf->Cell(166,7,utf8_decode($perbre['grado'].$perbre['complemento'].' '.$perbre['per_nombre'].' '.$perbre['per_paterno'].' '.$perbre['per_materno']),0,0,'L');
                //             $pdf->Ln();
                //         }
                //     }
                // }
            }//FIN PARTE 3
            //INICIO PARTE 4
            elseif($p == 4){
                // // $pdf->StartPageGroup();
                // $pdf->AddPage();
                // $pdf->Bookmark(utf8_decode('CUARTA PARTE'),false);
                // $pdf->Bookmark(utf8_decode('DISPOSICIONES COMPLEMENTARIAS'),false);
                // $pdf->SetFont('Arial','B',12);
                // $pdf->SetX(20);
                // $pdf->Bookmark(utf8_decode('AGRADECIMIENTO'),false,1);
                // $pdf->Cell(176,7,utf8_decode('I.    AGRADECIMIENTO'),0,0,'L');
                // $pdf->Ln();
                // $pdf->SetFont('Arial','',11);
                // $pdf->SetX(27);
                // $pdf->MultiCell(169,5,utf8_decode('El Comando General de la Fuerza Aérea Boliviana, hace llegar a todo el personal sus más sinceros agradecimientos por el eficiente servicio prestado a la Institución, expresándoles su reconocimiento por la honestidad, lealtad y disciplina, valores con los cuales se desempeñaron en las diferentes funciones que les fueron asignadas. '),0);
                // $pdf->Ln(10);
                // $pdf->SetFont('Arial','B',12);
                // $pdf->SetX(20);
                // $pdf->Bookmark(utf8_decode('VARIOS'),false,1);
                // $pdf->Cell(176,7,utf8_decode('II.    VARIOS'),0,0,'L');
                // $pdf->Ln();
                // $pdf->SetFont('Arial','',11);
                // $pdf->SetX(27);
                // $pdf->MultiCell(169,5,utf8_decode('El personal deberá constituirse en su nuevo destino dentro del plazo establecido. El personal no consignado en la presente Orden General tiene la obligación de hacer conocer esta novedad al DPTO. I PERSONAL - EMGFAB. y continuar prestando servicios en su actual destino hasta nueva orden. '),0);
                // $pdf->Ln(50);
                // $pdf->SetFont('Arial','BI',12);
                // $pdf->SetX(20);
                // $pdf->Cell(176,7,utf8_decode('"EL MAR NOS PERTENECE POR DERECHO,'),0,0,'C');
                // $pdf->Ln();
                // $pdf->SetX(20);
                // $pdf->Cell(176,7,utf8_decode('RECUPERARLO ES UN DEBER"'),0,0,'C');
                // $pdf->Ln();
                // //FIRMAS
                // $cmdtefab = $request->cmdtefab;
                // $cmdteffaa = $request->cmdteffaa;
                // $mindef = $request->mindef;
                // $presidente = $request->presidente;
                // $pdf->AddPage();
                // $pdf->Ln(30);
                // $pdf->SetFont('Arial','',12);
                // $pdf->SetX(20);
                // $pdf->Cell(115,5,utf8_decode($cmdtefab),0,0,'C');
                // $pdf->Ln();
                // $pdf->SetFont('Arial','B',12);
                // $pdf->SetX(20);
                // $pdf->Bookmark(utf8_decode('FIRMAS'),false,2);
                // $pdf->Cell(115,5,utf8_decode('COMANDANTE GENERAL ACC. DE LA FUERZA AÉREA'),0,0,'C');
                // $pdf->Ln(10);
                // $pdf->SetFont('Arial','',12);
                // $pdf->SetX(70);
                // $pdf->Cell(125,5,utf8_decode('AUTORIZADO:'),0,0,'C');
                // $pdf->Ln(30);
                // $pdf->SetFont('Arial','',12);
                // $pdf->SetX(70);
                // $pdf->Cell(125,5,utf8_decode($cmdteffaa),0,0,'C');
                // $pdf->Ln();
                // $pdf->SetFont('Arial','B',12);
                // $pdf->SetX(70);
                // $pdf->Cell(125,5,utf8_decode('COMANDANTE EN JEFE ACC. DE LAS FF.AA. DEL ESTADO'),0,0,'C');
                // $pdf->Ln(10);
                // $pdf->SetFont('Arial','',12);
                // $pdf->SetX(20);
                // $pdf->Cell(90,5,utf8_decode('ES CONFORME:'),0,0,'C');
                // $pdf->Ln(30);
                // $pdf->SetFont('Arial','',12);
                // $pdf->SetX(20);
                // $pdf->Cell(90,5,utf8_decode($mindef),0,0,'C');
                // $pdf->Ln();
                // $pdf->SetFont('Arial','B',12);
                // $pdf->SetX(20);
                // $pdf->Cell(90,5,utf8_decode('MINISTRO DE DEFENSA'),0,0,'C');
                // $pdf->Ln(10);
                // $pdf->SetFont('Arial','',12);
                // $pdf->SetX(90);
                // $pdf->Cell(100,5,utf8_decode('APROBADO:'),0,0,'C');
                // $pdf->Ln(30);
                // $pdf->SetFont('Arial','',12);
                // $pdf->SetX(90);
                // $pdf->Cell(100,5,utf8_decode($presidente),0,0,'C');
                // $pdf->Ln();
                // $pdf->SetFont('Arial','B',12);
                // $pdf->SetX(90);
                // $pagina = $pdf->PageNo() - 1;
                // $pdf->MultiCell(100,5,utf8_decode('PRESIDENTE DEL ESTADO PLURINACIONAL DE BOLIVIA Y CAPITÁN GENERAL DE LAS FUERZAS ARMADAS'),0,'C');
                
                //FIN FIRMAS
            }//FIN PARTE 4
            //INCIO INDICE
            elseif($p == 5){
                $pdf->StartPageGroup();
                $pdf->AddPage();
                $pdf->CreateIndex();
            }//FIN INDICE
            
        }//FIN FOR
        $pdf->SetX(20);
        ob_clean();
        $pdf->SetX(20);
        $pdf->Output();
        $pdf->SetX(20);
        exit;
    }
}
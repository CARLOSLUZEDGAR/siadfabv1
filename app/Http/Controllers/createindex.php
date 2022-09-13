<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codedge\Fpdf\Fpdf\Fpdf;

use App\Http\Controllers\bookmark;

class createindex extends bookmark
{
    function CreateIndex(){
        $this->lMargin = 20;
        $this->rMargin = 20;

        $this->SetFontSize(10);
        // $this->SetX(25);
        $this->Ln(0);
    
        //CALCULA CANTIDAD DE ELEMENTOS DEL INDICE
        $size=sizeof($this->outlines);
        // $PageCellSize=$this->GetStringWidth('p. '.$this->outlines[$size-1]['p'])+2;
        $PageCellSize=12;
        for ($i=0;$i<$size;$i++){
            //Offset
            $level=$this->outlines[$i]['l'];
            if($level>0)
                $this->Cell($level*3);
    
            //Caption
            $str=utf8_decode($this->outlines[$i]['t']);
            $strsize=$this->GetStringWidth($str);
            
            $avail_size=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*3)-4;
            while ($strsize>=$avail_size){
                // $str=substr($str,0,-1);S
                $strsize=$this->GetStringWidth($str);
            }
            // $this->SetX(20);
            if($level == 0){
                // $this->SetFontSize(20);
                $this->Cell(176,$this->FontSize+2,$str,0,0,'C');
                $this->Ln();
            }
            else{
                $this->Cell($strsize+2,$this->FontSize+2,$str);

                //Filling dots
                $w=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*3)-($strsize+2)-5;
                $nb=$w/$this->GetStringWidth('.');
                $dots=str_repeat('.',$nb);
                $this->Cell($w,$this->FontSize+2,$dots,0,0,'R');
        
                //Page number
                // $this->Cell($PageCellSize+4,$this->FontSize+2,$this->outlines[$i]['p'].' '.'-'.' '.'{nb}',0,1,'R');
                $this->Cell($PageCellSize+4,$this->FontSize+2,$this->outlines[$i]['p'].' '.'-'.' '.$this->CantPagesAnterior(),0,1,'R');

            }
            // $this->Cell($strsize+2,$this->FontSize+2,$str);
    
            //Filling dots
            // $w=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*3)-($strsize+2);
            // $nb=$w/$this->GetStringWidth('.');
            // $dots=str_repeat('.',$nb);
            // $this->Cell($w,$this->FontSize+2,$dots,0,0,'R');
    
            // //Page number
            // $this->Cell($PageCellSize+4,$this->FontSize+2,$this->outlines[$i]['p'].' '.'-'.' '.'{nb}',0,1,'R');
        }
    }

    public function Header()
    { 
        global $p;
        if ($p != 0){
            $this->SetFont('Arial','B',12);
            $this->Image('./img/comando_agua.png',33,61.5,150,150);
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
            $this->Cell(176,7,utf8_decode('ORDEN GENERAL DE DESTINOS 02/'.$nrogestion),0,2,'C');
            $this->SetFont('Arial','B',10);
            $this->SetX(20);
            if ($p == 1){ 
                $this->Cell(176,7,utf8_decode('PRIMERA PARTE'),0,2,'C');
                $this->SetFont('Arial','BU',10);
                $this->SetX(20);
                $this->Cell(176,7,utf8_decode('DE LA SITUACIÓN MILITAR'),0,2,'C');
            }
            elseif ($p == 2){
                $this->Cell(176,7,utf8_decode('SEGUNDA PARTE'),0,2,'C');
                $this->SetFont('Arial','BU',10);
                $this->SetX(20);
                $this->Cell(176,7,utf8_decode('DE LOS DESTINOS'),0,2,'C');
            }
            elseif ($p == 3){
                $this->Cell(176,7,utf8_decode('TERCERA PARTE'),0,2,'C');
                $this->SetFont('Arial','BU',10);
                $this->SetX(20);
                $this->Cell(176,7,utf8_decode('DE LOS TITULOS Y DIPLOMAS'),0,2,'C');
            }
            elseif ($p == 4){
                $this->Cell(176,7,utf8_decode('CUARTA PARTE'),0,2,'C');
                $this->SetFont('Arial','BU',10);
                $this->SetX(20);
                $this->Cell(176,7,utf8_decode('DISPOSICIONES COMPLEMENTARIAS'),0,2,'C');
            }
            elseif ($p == 5){
                $this->SetFont('Arial','BU',10);
                $this->Cell(176,7,utf8_decode('ÍNDICE'),0,2,'C');
            } 
        }
        else{}
    }
    public function Footer()
    {
        global $pagina;
        // if($this->PageNo() >= 2){
            $this->SetFont('Arial','B',12);
            $this->SetY(-15);
            $this->SetX(20);
            $this->Cell(176,5,utf8_decode('- SECRETO -'),0,0,'C');
            $this->SetFont('Arial','B',10);
            $this->SetY(-11);
            $this->SetX(20);
            // $page = $this->PageNo() - 1;
            // $this->Cell(176,5,$this->PageNo().' '.'-'.' '.'{nb}',0,0,'C');
            // $this->Cell(176,5,$page.' '.'-'.' '.$pagina,0,0,'C');
            $this->Cell(176,5,$this->GroupPageNo().' - '.$this->PageGroupAlias(),0,0,'C');
        // }
    }
}

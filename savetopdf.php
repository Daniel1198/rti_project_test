<?php
    require('fpdf/fpdf.php');
    include('connect.php');

    class PDF extends FPDF
    {

        // Pied de page
        function Footer()
        {
            // Positionnement à 1,5 cm du bas
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('Arial','',8);
            // Numéro de page
            $this->Cell(0,10, $this->PageNo(),0,0,'C');
        }
        var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';

    function WriteHTML($html)
    {
        //Parseur HTML
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Texte
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
                else
                    $this->Write(5,$e);
            }
            else
            {
                //Balise
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extraction des attributs
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Balise ouvrante
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Balise fermante
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modifie le style et sélectionne la police correspondante
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Place un hyperlien
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
    }
    
    $pdf = new PDF('L', 'mm', 'A4');
    // $pdf->AddFont('Ubuntu','','Ubuntu-Regular.ttf');
    $pdf->AddPage();
    $pdf->SetTitle('Bilan');
    $pdf->Image('icon/icon.png',10,7,10,5);
    $pdf->SetFont('Arial','',9);
    $pdf->Write(0, utf8_decode('            Radiodiffusion Télévision Ivoirienne'));
    $pdf->Cell(0, 0, 'Date d\'exportation : '.date("d/m/Y"), 0, 0, 'R');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',12);
    $pdf->Rect(97, 20, 100, 10);
    $pdf->Cell(0, 10, 'BILAN DES EMISSIONS', '', 1, 'C');
    // $pdf->SetY(-15);
    // $pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');
    $pdf->Ln(10);

    // requête d'affichage des enregistrements de la base de données
    $req = $pdo->query("SELECT * FROM emissions ORDER BY datEmi DESC");
    $nommbreEnr = $req->rowCount();

    if ($nommbreEnr == 0) {
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(0, 10, 'Aucun enregistrement', 0, 1, 'C');
        $pdf->Ln(10);

    }
    else {
        $pdf->SetFillColor(236, 236, 236);
        $pdf->SetFont('Arial','B',10);
        $pdf->Write(0, utf8_decode('Nombre d\'enregistrement : '.$nommbreEnr));
        $pdf->Ln(10);
        $pdf->SetTextColor(0, 115, 0);
        $pdf->Cell(27, 10, utf8_decode('Libéllé'), '', 0, '', true);
        $pdf->Cell(90, 10, utf8_decode('Thème'), '', 0, '', true);
        $pdf->Cell(23, 10, 'Date', '', 0, '', true);
        $pdf->Cell(18, 10, utf8_decode('Durée'), '', 0, '', true);
        $pdf->Cell(75, 10, utf8_decode('Invité(s)'), '', 0, '', true);
        $pdf->Cell(40, 10, utf8_decode('Date de rédiffusion'), '', 0, '', true);

        while ($data = $req->fetch()){
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial','',9);
            $pdf->Ln();
            $pdf->Cell(27, 10, utf8_decode($data['libEmi']), 'B');
            $pdf->Cell(90, 10, utf8_decode($data['thEmi']), 'B');
            $pdf->Cell(23, 10, utf8_decode($data['datEmi']), 'B');
            $pdf->Cell(18, 10, utf8_decode($data['durEmi']), 'B');

            // requête d'affichage des invités pour chaque emission de la base de données
            $req2 = $pdo->query("SELECT * FROM invites, inviter WHERE inviter.idInv = invites.idInv AND inviter.idEmi = '".$data['idEmi']."'");

            $donnees = "";

            // stockage de la liste des invités par emission dans la variable $donnees en faisant une concaténation
            while ($data2 = $req2->fetch()) {
                $donnees .= $data2['nomInv'].', ';  
            }
            $lastChar = strlen($donnees);
            $donnees[$lastChar-2] = ' ';
            $pdf->Cell(75, 10, 
                trim($donnees)
            , 'B');
            $pdf->Cell(40, 10, utf8_decode($data['datRdEmi']), 'B');
        }
    }
    
    $pdf->Output();
?>

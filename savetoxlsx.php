<?php
    include('connect.php');
    require('vendor/autoload.php');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    $headerStyle = [
        'fill'=>[
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => '005416'
            ]
        ],

        'font'=>[
            'color' => [
                'rgb' => 'FFFFFF'
            ]
        ]
    ];

    $rowStyle = [
        'fill'=>[
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'B5FFC9'
            ]
        ],
    ];

    // Creates New Spreadsheet
    $spreadsheet = new Spreadsheet();
    
    // Retrieve the current active worksheet
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->getStyle('A1:G1')->getFont()->setBold(true);
    $sheet->getStyle('A1:G1')   ->applyFromArray($headerStyle);

    // definition d'une taille automatique pour les cellules A,B,C,D,E,F & G
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);

    // définition du libéllé de l'entête
    
    $sheet->setCellValue('A1', 'Libéllé');
    
    $sheet->setCellValue('B1', 'Thème');
    $sheet->setCellValue('C1', 'Date');
    $sheet->setCellValue('D1', 'Durée');
    $sheet->setCellValue('E1', 'Présentateur');
    $sheet->setCellValue('F1', 'Invités');
    $sheet->setCellValue('G1', 'Date de rédiffusion');

    // requête d'affichage des enregistrements de la base de données
    $req = $pdo->query("SELECT * FROM emissions ORDER BY datEmi DESC");
    $nommbreEnr = $req->rowCount();

    // variable correspondant aux lignes de la feuille de calcul excel
    $line = 2;
    // affichage des lignes des données à partir de la ligne 2 de la feuille de calcul d'excel
    while ($data = $req->fetch()){
        if ($line%2==0) {
            $sheet->getStyle('A'.$line.':G'.$line)->applyFromArray($rowStyle);
        }
        $sheet->setCellValue('A'.$line, $data['libEmi']);
        $sheet->setCellValue('B'.$line, $data['thEmi']);
        $sheet->setCellValue('C'.$line, $data['datEmi']);
        $sheet->setCellValue('D'.$line, $data['durEmi']);
        $sheet->setCellValue('E'.$line, $data['prEm']);
        
        // requête d'affichage des invités pour chaque emission de la base de données
        $req2 = $pdo->query("SELECT * FROM invites, inviter WHERE inviter.idInv = invites.idInv AND inviter.idEmi = '".$data['idEmi']."'");

        $donnees = "";

        // stockage de la liste des invités par emission dans la variable $donnees en faisant une concaténation
        while ($data2 = $req2->fetch()) {
            $donnees .= $data2['nomInv'].', ';  
        }
        $lastChar = strlen($donnees);
        $donnees[$lastChar-2] = ' ';

        $sheet->setCellValue('F'.$line, trim($donnees));
        $sheet->setCellValue('G'.$line, $data['datRdEmi']);
        $line++;
    }
    $line--;

    $sheet->setAutoFilter('A1:G'.$line);
    
    // Write an .xlsx file
    $writer = new Xlsx($spreadsheet);

    header('Content-Disposition: attachment;filename="bilan_'.date('d-m-Y').'.xlsx"');
    $writer->save('php://output');
?>
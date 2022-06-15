<?php
use App\Core\Controller;
use App\Models\PDF_Model;
class PrintController extends Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $position_entete = 8;
        $pdf = new PDF_Model('P','mm','A4');
        $pdf->AddPage();
        $pdf->SetFont('Times','B',14);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0); // Couleur du fond
        $pdf->SetFillColor(600); // Couleur des filets
        $pdf->SetTextColor(0); // Couleur du texte
        //ENTETE TABLE
        $this->Theader($pdf,8);
        $this->content($pdf);

        $this->tableau($pdf,118);
        $pdf->Output();

    }
    private function Theader($pdf,$position){
        $pdf->SetY($position);
        $pdf->SetX(20);
        $pdf->Cell(35,25,"",1,0,'C',$pdf->image(\getImg('logo-esmia.png'),25.5,11,23));
            
        $pdf->Cell(135,25,"",1,0,'C',
            $pdf->Text(111,14,'ESMIA'),
            $pdf->SetFont('Times','',11),
            $pdf->Text(73,18,utf8_decode("Ecole Supérieure de Management et d'Informatique Appliquée")),
            $pdf->Text(84,24,"BP 418, 101 Antananarivo - MADAGASCAR"),
            $pdf->Text(69,30,"020 26 413 62 /"),
            $pdf->SetFont('Times','U',11),
            $pdf->SetTextColor(20,21,220),
            $pdf->Text(94.6,30,"contact@esmia-mada.com"),
            $pdf->SetFont('Times','',11),
            $pdf->SetTextColor(0),
            $pdf->Text(137,30,"/"),
            $pdf->SetFont('Times','U',11),
            $pdf->SetTextColor(20,21,220),
            $pdf->Text(139.1,30,"www.esmia-mada.com")
        );
        $pdf->SetFont('Times','',12);
        $pdf->SetTextColor(0);
        $pdf->Cell(20.2,25,utf8_decode('N°'),0,0,'C',$pdf->Ellipse(199.7,20.5,7,7));
    }
    private function tableau ($pdf,$position){
		$pdf->SetDrawColor(0); // Couleur du fond
		$pdf->SetFillColor(600); // Couleur des filets
		$pdf->SetTextColor(0); // Couleur du texte
		$pdf->SetY($position);
		$pdf->SetX(20);
		$pdf->Cell(39,7,"CRITERES",1,0,'C');
		$pdf->Cell(24,7,"TRES BIEN",1,0,'C',1);
		$pdf->Cell(24,7,"BIEN",1,0,'C');
		$pdf->Cell(24.5,7,"ASSEZ BIEN",1,0,'C');
		$pdf->Cell(24.5,7,"PASSABLE",1,0,'C');
		$pdf->Cell(34,7,"OBSERVATIONS",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,utf8_decode("Présentation de soi"),1,0,'L');
		$pdf->Cell(24,7,"",1,0,'C',1);
		$pdf->Cell(24,7,"",1,0,'C');
		$pdf->Cell(24.5,7,"",1,0,'C');
		$pdf->Cell(24.5,7,"",1,0,'C');
		$pdf->Cell(34,7,"",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,utf8_decode("Domaine souhaité"),1,0,'L');
		$pdf->Cell(131,7,"",1,1,'C',$pdf->Ellipse(62,136,1.1,1.1),$pdf->Text(65,137,"MEGP"),$pdf->Ellipse(82.7,136,1.1,1.1),$pdf->Text(85.7,137,"IRD"),$pdf->Ellipse(99,136,1.1,1.1),$pdf->Text(102,137,"BANCASS"),$pdf->Ellipse(128.2,136,1.1,1.1),$pdf->Text(131.2,137,"IMP"),$pdf->Ellipse(145.7,136,1.1,1.1),$pdf->Text(148.7,137,"MIAGE"),$pdf->Ellipse(170,136,1.1,1.1),$pdf->Text(173,137,"QUADD"));
		$pdf->SetX(20);
		$pdf->Cell(39,7,"Connaissance ESMIA",1,0,'C');
		$pdf->Cell(131,7,"",1,1,'C',1);
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,"Vision",1,0,'L');
		$pdf->Cell(48,7,"",1,0,'C');
		$pdf->Cell(83,7,"Motivations",1,1,'L');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,utf8_decode("Problèmes"),1,0,'L');
		$pdf->Cell(131,7,"",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,"Attente",1,0,'L');
		$pdf->Cell(131,7,"",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,"Projet pro / perso",1,0,'L');
		$pdf->Cell(131,7,"",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(87,12,utf8_decode("Qualités"),1,0,'L');
		$pdf->Cell(83,12,utf8_decode("Défauts"),1,1,'L');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,"Loisirs",1,0,'L');
		$pdf->Cell(131,7,"",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,"Adresse",1,0,'L');
		$pdf->Cell(131,7,"",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(39,7,"Autres",1,0,'L');
		$pdf->Cell(131,7,"",1,1,'C');
		
		$pdf->SetX(20);
		$pdf->Cell(39,12,"Famille",1,0,'L');
		$pdf->Cell(24,12,utf8_decode("Père"),1,0,'L',1);
		$pdf->Cell(24,12,utf8_decode("Mère"),1,0,'L');
		$pdf->Cell(24.5,12,"Soeur",1,0,'L');
		$pdf->Cell(24.5,12,utf8_decode("Frère"),1,0,'L');
		$pdf->Cell(34,12,"Observations",1,1,'L');
		$pdf->Ln(5);
		
		$pdf->SetX(20);
		$pdf->Cell(48,7,utf8_decode("Niveau de français"),1,0,'L');
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(75,227.7,1.1,1.1),$pdf->Text(81,228.5,"1 (-)"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(101,227.7,1.1,1.1),$pdf->Text(107,228.5,"2"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(126,227.7,1.1,1.1),$pdf->Text(132,228.5,"3"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(151,227.7,1.1,1.1),$pdf->Text(157,228.5,"4"));
		$pdf->Cell(24.5,7,"",1,1,'L',$pdf->Ellipse(172,227.7,1.1,1.1),$pdf->Text(178,228.5,"5 (+)"));
		
		$pdf->SetX(20);
		$pdf->Cell(48,7,utf8_decode("Niveau d'anglais"),1,0,'L');
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(75,234.7,1.1,1.1),$pdf->Text(81,235.5,"1 (-)"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(101,234.7,1.1,1.1),$pdf->Text(107,235.5,"2"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(126,234.7,1.1,1.1),$pdf->Text(132,235.5,"3"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(151,234.7,1.1,1.1),$pdf->Text(157,235.5,"4"));
		$pdf->Cell(24.5,7,"",1,1,'L',$pdf->Ellipse(172,234.7,1.1,1.1),$pdf->Text(178,235.5,"5 (+)"));
		
		$pdf->SetX(20);
		$pdf->Cell(48,7,utf8_decode("Niveau en informatique"),1,0,'L');
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(75,241.7,1.1,1.1),$pdf->Text(81,242.5,"1 (-)"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(101,241.7,1.1,1.1),$pdf->Text(107,242.5,"2"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(126,241.7,1.1,1.1),$pdf->Text(132,242.5,"3"));
		$pdf->Cell(24.5,7,"",1,0,'L',$pdf->Ellipse(151,241.7,1.1,1.1),$pdf->Text(157,242.5,"4"));
		$pdf->Cell(24.5,7,"",1,1,'L',$pdf->Ellipse(172,241.7,1.1,1.1),$pdf->Text(178,242.5,"5 (+)"));
		
		$pdf->SetX(20);
		$pdf->Cell(48,7,utf8_decode("Réactivité"),1,0,'L');
		$pdf->Cell(73.5,7,"",1,0,'L',$pdf->Ellipse(75,249,1.1,1.1),$pdf->Text(81,250,"Meneur (Dynamique)"));
		$pdf->Cell(49,7,"",1,1,'L',$pdf->Ellipse(151,249,1.1,1.1),$pdf->Text(157,250,"Suiveur (Amorphe)"));
		
		$pdf->SetX(20);
		$pdf->Cell(48,7,utf8_decode("Avis : "),1,0,'L');
		$pdf->Cell(73.5,7,"",1,0,'L',$pdf->Ellipse(75,255.5,1.1,1.1),$pdf->Text(81,256.8,"Favorable"));
		$pdf->Cell(49,7,"",1,1,'L',$pdf->Ellipse(151,255.5,1.1,1.1),$pdf->Text(157,256.8,utf8_decode("Défavorable")));
		$pdf->Ln(5);
		
		$pdf->SetX(20);
		$pdf->Cell(170,12,"Les membres : ",1,0,'L',$pdf->Ellipse(55,270,1.1,1.1),$pdf->Text(60,271,"RSB"),$pdf->Ellipse(75,270,1.1,1.1),$pdf->Text(80,271,"RR"),$pdf->Ellipse(95,270,1.1,1.1),$pdf->Text(100,271,"ARR"),$pdf->Ellipse(115,270,1.1,1.1),$pdf->Text(120,271,"MB"),$pdf->Ellipse(135,270,1.1,1.1),$pdf->Text(140,271,"AUTRES :    ___________"));
    }
    
    private function content($pdf){
        $pdf->Text(20,40,'Candidature pour :                          ______________________________');
        $pdf->Text(20,47,utf8_decode("Date de l'entretien :                         ______________________________" ));
        $pdf->Text(20,54,utf8_decode('Date de rappel (Réservé SPDE) :   __________  Inscription :'),
        $pdf->Ellipse(131,53,1.1,1.1),$pdf->Text(134.5,54,"Oui, le __________"),
        $pdf->Ellipse(172,53,1.1,1.1),$pdf->Text(175.5,54,"Non  "),
        $pdf->Ellipse(191,53,1.1,1.1),
        $pdf->Text(194.5,54,utf8_decode("Indécis  ")));
        $pdf->Text(20,61,'Nom :                                             '."MON NOM" );
        $pdf->Text(20,68,utf8_decode('Prénom(s) :                                    '."MON PRENOMS"));
        $pdf->Text(20,75,'Date de naissance :                        '."2018-2019");
        $pdf->Text(20,82,utf8_decode('Téléphone :                                    '."MES CONTACTES"));
        $pdf->Text(20,89,utf8_decode('Dernier établissement fréquenté : '."MON ETABLISSEMENT P"));
        $pdf->Text(20,96,utf8_decode('Dernier diplôme obtenu :               '."DIPLOME"));
        $pdf->Text(20,103,utf8_decode('Niveau candidaté :                         '."NIVEAU"));
        $pdf->Text(20,110,'Religion :                                        ____________________________________________________');   
    }

}
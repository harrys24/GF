<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel='stylesheet' href='/assets/css/src/print.css'>
    <title>Document</title>
</head>
<body>
    
    <?php 
        $montant = explode(" ",ucwords($this->convertToLetter($recus[0]['montant'])));
        $reste = explode(" ",ucwords($this->convertToLetter($recus[0]['reste'])));
    ?>
    <div id="print" style="width: 80mm; height: auto; font-size: 12px; padding: 15px;">
        <div class="d-flex justify-content-between" style="line-height: 6px !important; text-align: right;">
            <div class="bd-highlight" id="img">
                <!-- <img src="/assets/images/logo-esmia.png" alt="" style="width: 78px;"> -->
            </div>
            <div class="d-flex flex-column mt-2" style="margin-left: 10px; line-height: 0px !important;"> 
                <p><b>ESMIA - Service Financier</b></p>
                <p><b>NIF:</b> 30018212367</p>
                <p ><b>STAT:</b> 85302 11 2014 0 10990</p>
                <p>034 50 660 54</p>
                <p>contact@esmia-mada.com</p>
            </div>
        </div>
        <h6 class="text-center mt-1">REÇU DE PAIEMENT N°<?= $recus[0]['idR'] ?></h6>
        <div class="container mt-4" style="line-height: 6px;">
            <div class="row">
                <p class="col-4"><b>Nom:</b></p>
                <p class="col-8" style="line-height: 13px;"><?= $recus[0]['nom'] ?></p>
            </div>
            <div class="row">
                <p class="col-4"><b>Prénoms:</b></p>
                <p class="col-8" style="line-height: 13px;"><?= $recus[0]['prenom'] ?></p>
            </div>
            <div class="row">
                <p class="col-4"><b>NIE:</b></p>
                <p class="col-8"><?= $recus[0]['NIE'] ?></p>
            </div>
            <div class="row">
                <p class="col-4"><b>Niveau:</b></p>
                <p class="col-8"><?= $recus[0]['nom_niv'].''.$recus[0]['nom_gp'] ?></p>
            </div>
            <div class="row" style="line-height: 10px;">
                <p class="col-4" ><b>Désignation:</b></p>
                <p class="col-8"><?= $recus[0]['designation'] ?></p>
            </div>
            <div class="row" style="line-height: 13px;">
                <p class="col-4"><b>Montant payé:</b></p>
                <div class="col-8 mt-1">
                    <div class="d-flex flex-column">
                        <p style="line-height: 1px; margin-bottom:8px"><?= number_format($recus[0]['montant'], 2,",",' ') ?> Ar</p>
                        <p style="line-height: 12px;"><?= $montant[0] == "Millions" ? "Un ".ucwords($this->convertToLetter($recus[0]['montant'])) : ucwords($this->convertToLetter($recus[0]['montant'])) ?> Ariary</p>
                    </div>
                </div>
            </div>
            <div class="row" style="line-height: 13px;">
                <p class="col-4"><b>Reste à payer:</b></p>
                <div class="col-8 mt-1">
                    <div class="d-flex flex-column">
                        <p style="line-height: 1px; margin-bottom:8px"><?= number_format($recus[0]['reste'], 2,",",' ') ?> Ar </p>
                        <p style="line-height: 12px;"><?= $reste[0] == "Millions" ? "Un ".ucwords($this->convertToLetter($recus[0]['reste'])) : ucwords($this->convertToLetter($recus[0]['reste'])) ?> Ariary</p>
                    </div>
                </div>
                
            </div>
            <div class="row" style="line-height: 13px;">
                <p class="col-4" ><b>Mode de paiement:</b></p>
                <p class="col-8 mt-2"><?= $recus[0]['mode'] ?></p>
            </div>
            <?php if($recus[0]['mode'] == "MVOLA"){?>
                <div class="row">
                    <p class="col-4"><b> Ref :</b></p>
                    <p class="col-8"><?= $recus[0]['num'] ?></p>
                </div>
            <?php }else if($recus[0]['mode'] =="ESP"){?>
            <?php }else if($recus[0]['mode'] =="Cheque"){?>
                <div class="row">
                    <p class="col-4" style="line-height: 13px;"><b> N°Chèque:</b></p>
                    <p class="col-8 mt-1"><?= $recus[0]['num'] ?></p>
                </div>
            <?php }else{ ?>
                <div class="row">
                    <p class="col-4" style="line-height: 13px;"><b> Bordereau <?=$recus[0]['mode'] ?>:</b></p>
                    <p class="col-8 mt-2"><?= $recus[0]['num'] ?></p>
                </div>

            <?php } ?>
        </div>
        <div class="d-flex justify-content-between mr-2 mt-2">
            <p>Reçu par <b><?= $recus[0]['signataire'] ?></b> le <?php echo((new DateTime($recus[0]['date_heure']))->format("d-m-Y"))?> à <?php echo((new DateTime($recus[0]['date_heure']))->format("H:i"))?></p>
        </div>
        <div class="mt-5" style="border-bottom: 1px solid #000; font-size: 0.75rem; text-align: justify;">
            L’écriture sur ce reçu s’efface avec le temps. Si vous souhaitez le conserver sur une longue durée, merci d’en faire une copie<b>.</b>
        </div>
    </div>
</body>
</html>
<script>
    window.onload=function(){window.print();}
    var i = 0;
    window.onmousemove=function(){
        if(i == 1){
            window.close();
        }else{
            window.print();
            i+=1;
        }
    }
</script>
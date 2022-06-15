<?php
use App\Core\Controller;
class SendController extends Controller
{
    const MAIL='';
    const PWD='';
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        // Create the Transport
        // $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
        $transport = (new Swift_SmtpTransport('localhost', 1025))
        ->setUsername('')
        ->setPassword('');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        $imgP=\getImg('photo.jpg');
        // Create a message
        $message = (new Swift_Message('Note d\'information'))
        ->setFrom(['lovaharisonrakotoarivo@gmail.com' =>'Service informatique'])
        ->setTo(['informatique@esmia-mada.com' => 'Etudiants'])
        ->setBody("Bonjour, \n\rVeuillez-trouver ci-joint le fichier. \nBonne réception.")
        ->attach(Swift_Attachment::fromPath($imgP))
        ;

        // Send the message
        if ($mailer->send($message)) {
            echo 'Email envoyé !';
        } else {
            echo 'Email erreur !';
        }
        
    }

    

}
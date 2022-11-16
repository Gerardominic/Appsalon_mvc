<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        // Crear el objeto de email
        $mail = new PHPMailer();

        // Conectarse al MailTrap con PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b996f7e1ed6275';
        $mail->Password = '8fac93611f8217';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        // Asunto
        $mail->Subject = 'Confirma tu cuenta';
        
        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = $this->getContenidoHTML(
            'Confirma tu cuenta',
            'Gracias por registrarte, por favor confirma tu correo electrónico para disfrutar los servicios dando click al botón de enlace',
            'confirmarcuenta',
            'Confirmar Cuenta','
            Si tú no te registraste en AppSalon, por favor ignora este correo electrónico'
        );
        $mail->Body = $contenido;
        
        // Enviar el mail
        $mail->send();
    }

    
    public function enviarInstrucciones(){
        /*
        En caso de que el Usuario se le olvido la contraseña, se le envia un correo para que pueda reestablecer
        su contraseña dirigiendolo a un link con su token que tiene en su base de datos
        */


        // Crear el objeto de email
        $mail = new PHPMailer();

        // Conectarse al MailTrap con PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b996f7e1ed6275';
        $mail->Password = '8fac93611f8217';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        // Asunto
        $mail->Subject = 'Reestablece tu Contraseña';
        
        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = $this->getContenidoHTML(
            'Reestablece tu Contraseña',
            'Has solicitado reestablecer tu Contraseña, sigue el siguiente enlace para hacerlo',
            'recuperar',
            'Reestablecer Contraseña',
            'Si tú no solicitaste este cambio, puedes ignorar el mensaje'
        );
        $mail->Body = $contenido;
        
        // Enviar el mail
        $mail->send();
    }

    public function getContenidoHTML($asunto, $mensaje, $ruta, $textoBoton, $textoAviso){
        /*
        @return String $cuerpoHTML

        Plantilla del contenido HTML cuando se envia el correo al usuario.

        $asunto = El asunto del mensaje que muestra abajo el nombre de la pagina
        $mensaje = El mensaje que le quieres dar al usuario cuando se registra o quiere reestablecer su contraseña, etc.
        $ruta = La ruta que lo enviara por el MVC al hacer click en el botón.
        $textoBoton = El enlace es un botón por lo tanto tiene texto, lo cual decidiras que texto tendra el botón.
        $textoAviso = El mensaje de aviso en caso de que el usuario no hizo dicha acción y desconoce el por qué de ese correo
        que le enviaron               
        */

        $cuerpoHTML = "
        <html>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap');

            html {
                font-size: 62.5%;
            }

            body {
                font-size: 16px;
                font-family: 'Poppins', sans-serif;
                max-width: 100%;
            }

            h1 {
                text-align:  center;
            }
            
            h2 {
                text-align: center;
            }

            .texto {
                text-align: justify;
                max-width: 95%;
            }

            .texto p {
                margin: 20px 0;
                width: 100%;
            }

            .texto p span{
                font-weight: bold;
            }

            .boton-link{                       
                text-decoration: none;
                text-align: center;
                background-color: #1a1b15;
                color: #ffffff;
                padding: 15px;
                font-weight: bold;
                display: block;            
            }

            @media (min-width: 768px) {
                .boton-link {     
                    display: inline-block;
                }
            }

            .boton-link:hover{
                background-color: #2b2a2a;
            }

            .borde {
                border-bottom: 1px solid #a09f9f;
                margin-bottom: 20px;
            }

            .texto-debajo {
                text-align: center;
            }
        </style>

        <body>
            <h1>AppSalon</h1>

            <h2>${asunto}</h2>

            <div class='texto'>
                <p>¡Saludos! <span>" .$this->nombre . " (".$this->email.").</span> ${mensaje}</p>
                <a href='http://appsalon.localhost/${ruta}?token=" . $this->token . "' class='boton-link'>${textoBoton}</a>
                <p class='texto-italic'>${textoAviso}</p>
            </div>

            <div class='borde'></div>

            <div class='Texto-debajo'>
                <span>No responder a este correo</span>
            </div>
        </body>
        </html>       
        ";

        return $cuerpoHTML;
    }
}

?>
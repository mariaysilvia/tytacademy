<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Clase EmailModel
 * Maneja todas las operaciones relacionadas con el envío de correos electrónicos
 */
class EmailModel {
    private $pdo;
    
    /**
     * Constructor de la clase
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Obtiene el nombre del módulo desde la base de datos
     * @param int $idModulo ID del módulo
     * @return string Nombre del módulo
     */
    public function obtenerNombreModulo($idModulo) {
        $stmt = $this->pdo->prepare("SELECT modulo FROM Modulo WHERE idModulo = ?");
        $stmt->execute([$idModulo]);
        $moduloData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $moduloData ? $moduloData['modulo'] : 'Módulo no especificado';
    }
    
    /**
     * Envía un correo de bienvenida al instructor
     * @param array $datos Datos del instructor
     * @return bool Resultado del envío
     */
    public function enviarCorreoBienvenida($datos) {
        require_once '../../vendor/phpmailer/phpmailer/src/Exception.php';
        require_once '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require_once '../../vendor/phpmailer/phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        
        try {
            // Obtener el nombre del módulo
            $nombreModulo = $this->obtenerNombreModulo($datos['modulo']);
            
            // Configuración del servidor
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tytacademy28@gmail.com';
            $mail->Password = 'hyec dmpy qpoe skhl';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = function($str, $level) {
                error_log("PHPMailer: $str");
            };

            // Remitente y destinatario
            $mail->setFrom('tytacademy28@gmail.com', 'Sistema TYT Academy');
            $mail->addAddress($datos['email'], $datos['nombre']);

            // Cargar y procesar el template HTML
            $templatePath = __DIR__ . '/../vista/bienvenidainstructor.html';
            if (!file_exists($templatePath)) {
                error_log("Error: No se encontró el archivo template en: " . $templatePath);
                return false;
            }

            $template = file_get_contents($templatePath);
            if ($template === false) {
                error_log("Error: No se pudo leer el archivo template");
                return false;
            }

            // Reemplazar variables en el template
            $template = str_replace('{{nombre}}', $datos['nombre'], $template);
            $template = str_replace('{{documento}}', $datos['documento'], $template);
            $template = str_replace('{{modulo}}', $nombreModulo, $template);
            $template = str_replace('{{email}}', $datos['email'], $template);
            $template = str_replace('{{clave}}', $datos['clave_original'], $template);

            // Agregar la firma electrónica
            $rutaFirma = __DIR__ . '/../publico/imagenes/firmaelectronica.jpg';
            error_log("Intentando cargar firma desde: " . $rutaFirma);
            
            if (file_exists($rutaFirma)) {
                // Agregar la imagen como adjunto incrustado
                $mail->addEmbeddedImage($rutaFirma, 'firmaelectronica', 'firmaelectronica.jpg');
                error_log("Firma electrónica agregada correctamente");
            } else {
                error_log("Error: No se encontró la imagen de la firma electrónica en: " . $rutaFirma);
            }

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenido a TYT Academy';
            $mail->Body = $template;
            $mail->AltBody = 'Bienvenido a TYT Academy. Por favor, visualiza este correo en un cliente que soporte HTML.';

            // Agregar logs para depuración
            error_log("Cuerpo del correo antes de enviar: " . $template);

            if (!$mail->send()) {
                error_log("Error al enviar correo: " . $mail->ErrorInfo);
                return false;
            }
            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Prepara el cuerpo del correo reemplazando las variables en el template
     * @param array $datos Datos del instructor
     * @param string $nombreModulo Nombre del módulo
     * @return string Cuerpo del correo
     */
    private function prepararCuerpoCorreo($datos, $nombreModulo) {
        $cuerpo = file_get_contents('../vista/bienvenidainstructor.html');
        if ($cuerpo === false) {
            error_log("❌ No se pudo leer el archivo bienvenidainstructor.html");
            return false;
        }

        $cuerpo = str_replace('{{nombre}}', $datos['nombre'], $cuerpo);
        $cuerpo = str_replace('{{email}}', $datos['email'], $cuerpo);
        $cuerpo = str_replace('{{clave}}', $datos['clave'], $cuerpo);
        $cuerpo = str_replace('{{modulo}}', $nombreModulo, $cuerpo);
        $cuerpo = str_replace('{{documento}}', $datos['documento'], $cuerpo);
        
        return $cuerpo;
    }
    
    /**
     * Agrega la firma electrónica al correo
     */
    private function agregarFirmaElectronica() {
        $rutaImagen = '../publico/imagenes/firmaelectronica.jpg';
        if (file_exists($rutaImagen)) {
            $this->mailer->addEmbeddedImage($rutaImagen, 'firmaelectronica');
        }
    }
} 
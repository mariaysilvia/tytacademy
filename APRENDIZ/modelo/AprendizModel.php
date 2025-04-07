<?php
//Clase AprendizModel
//Maneja todas las operaciones relacionadas con los aprendices en la base de datos,
//incluyendo registro, validación y gestión de datos de aprendices.
class AprendizModel {
    //Instancia de conexión a la base de datos
    private $pdo;
    
    //Constructor de la clase
    //@param PDO $pdo Conexión a la base de datos
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    //Valida los datos del aprendiz antes de guardarlos
    //@param array $datos Datos del aprendiz a validar
    //@return bool True si los datos son válidos, False en caso contrario
    public function validarDatos($datos) {
        return !empty($datos['documento']) && 
            !empty($datos['nombres']) && 
            !empty($datos['apellidos']) && 
            !empty($datos['correo']) && 
            !empty($datos['clave']);
    }
    
    //Guarda un nuevo aprendiz en la base de datos
    //@param array $datos Datos del aprendiz a guardar
    //@return bool True si se guardó correctamente, False en caso contrario
    public function guardarAprendiz($datos) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Aprendiz (documento, nombres, apellidos, correo, clave) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([
                $datos['documento'],
                $datos['nombres'],
                $datos['apellidos'],
                $datos['correo'],
                $datos['clave']
            ]);
        } catch (PDOException $e) {
            error_log("Error al guardar aprendiz: " . $e->getMessage());
            return false;
        }
    }
    
    //Verifica si un correo electrónico ya está registrado
    //@param string $correo Correo electrónico a verificar
    //@return bool True si el correo ya existe, False en caso contrario
    public function verificarCorreoExistente($correo) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Aprendiz WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetchColumn() > 0;
    }
    
    //Verifica si un documento ya está registrado
    //@param string $documento Documento a verificar
    //@return bool True si el documento ya existe, False en caso contrario
    public function verificarDocumentoExistente($documento) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Aprendiz WHERE documento = ?");
        $stmt->execute([$documento]);
        return $stmt->fetchColumn() > 0;
    }

    public function validarPassword($password) {
        if (strlen($password) < 8) return false;
        if (!preg_match('/[0-9]/', $password)) return false;
        if (!preg_match('/[A-Z]/', $password)) return false;
        if (!preg_match('/[a-z]/', $password)) return false;
        return true;
    }

    public function login($documento, $correo, $contraseña) {
        $stmt = $this->pdo->prepare("SELECT * FROM Aprendiz WHERE documento = ? AND correo = ?");
        $stmt->execute([$documento, $correo]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            return $usuario;
        }
        return false;
    }

    public function registrar($documento, $nombres, $apellidos, $correo, $contraseña, $celular) {
        // Verificar documento y correo duplicados
        $stmt = $this->pdo->prepare("
            SELECT 
                SUM(CASE WHEN documento = ? THEN 1 ELSE 0 END) as doc_count,
                SUM(CASE WHEN correo = ? THEN 1 ELSE 0 END) as email_count
            FROM Aprendiz
        ");
        $stmt->execute([$documento, $correo]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['doc_count'] > 0) {
            throw new Exception('Este documento ya está registrado');
        }
        if ($result['email_count'] > 0) {
            throw new Exception('Este correo electrónico ya está registrado');
        }

        // Hash de la contraseña
        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

        // Insertar nuevo aprendiz
        $stmt = $this->pdo->prepare("
            INSERT INTO Aprendiz (documento, nombres, apellidos, correo, contraseña, celular) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([$documento, $nombres, $apellidos, $correo, $contraseña_hash, $celular]);
    }

    public function obtenerPerfil($idAprendiz) {
        $stmt = $this->pdo->prepare("
            SELECT documento, nombres, apellidos, correo, celular, foto_perfil 
            FROM Aprendiz 
            WHERE idAprendiz = ?
        ");
        $stmt->execute([$idAprendiz]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarFotoPerfil($idAprendiz, $rutaFoto) {
        $stmt = $this->pdo->prepare("
            UPDATE Aprendiz 
            SET foto_perfil = :rutaFoto 
            WHERE idAprendiz = :idAprendiz
        ");
        
        $stmt->bindParam(':rutaFoto', $rutaFoto);
        $stmt->bindParam(':idAprendiz', $idAprendiz, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function obtenerIdAprendiz($idAprendiz) {
        return $idAprendiz;
    }
} 
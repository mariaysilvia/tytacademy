<?php
//Clase InstructorModel
//Maneja todas las operaciones relacionadas con los instructores en la base de datos,
//incluyendo creación, validación y gestión de datos de instructores.
class InstructorModel {
    //Instancia de conexión a la base de datos
    private $pdo;
    
    //Constructor de la clase
    //@param PDO $pdo Conexión a la base de datos
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    //Valida los datos del instructor antes de guardarlos
    // $datos Datos del instructor a validar
    // True si los datos son válidos, False en caso contrario
    public function validarDatos($datos) {
        return !empty($datos['documento']) && 
            !empty($datos['nombre']) && 
            !empty($datos['apellido']) && 
            !empty($datos['email']) && 
            !empty($datos['clave']) && 
            !empty($datos['modulo']);
    }
    
    public function validarDatosEdicion($datos) {
        return !empty($datos['id']) &&
            !empty($datos['nombre']) && 
            !empty($datos['apellido']) && 
            !empty($datos['documento']) && 
            !empty($datos['email']) && 
            !empty($datos['modulo']);
    }
    
    //Guarda un nuevo instructor en la base de datos
    //@param array $datos Datos del instructor a guardar
    //True si se guardó correctamente, False en caso contrario
    public function guardarInstructor($datos) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO Instructor (documento, nombre, apellido, email, clave, celular, idModulo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([
                $datos['documento'],
                $datos['nombre'],
                $datos['apellido'],
                $datos['email'],
                $datos['clave'],
                $datos['celular'],
                $datos['modulo']
            ]);
        } catch (PDOException $e) {
            error_log("Error al guardar instructor: " . $e->getMessage());
            return false;
        }
    }
    
    //Obtiene todos los módulos disponibles
    // Lista de módulos disponibles
    public function getModulos() {
        try {
            $stmt = $this->pdo->query("SELECT idModulo, modulo FROM Modulo");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener módulos: " . $e->getMessage());
            return [];
        }
    }
    //Obtiene todos los instructores de la base de datos
    //Lista de instructores con todos  sus datos
    public function obtener() {
        try {
            $sql = "SELECT i.idInstructor, i.documento, i.nombre, i.apellido, i.email, i.clave, i.celular, i.idModulo, m.modulo as nombreModulo 
                    FROM Instructor i 
                    LEFT JOIN Modulo m ON i.idModulo = m.idModulo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener instructores: " . $e->getMessage());
            return [];
        }
    }
    
    //Verifica si hay instructores en la base de datos
    // True si hay instructores, False si no hay ninguno
    public function hayinstructores() {
        $sql = "SELECT COUNT(*) FROM Instructor";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
    //Elimina un instructor de la base de datos
    //@param int $id ID del instructor a eliminar
    //True si se eliminó correctamente, False en caso contrario
    public function eliminarInstructor($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Instructor WHERE idInstructor = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error al eliminar instructor: " . $e->getMessage());
            return false;
        }
    }
    
    public function obtenerInstructor($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT idInstructor, documento, nombre, apellido, email, celular, idModulo FROM Instructor WHERE idInstructor = ?");
            $stmt->execute([$id]);
            $instructor = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Si se encontró el instructor, obtener el nombre del módulo
            if ($instructor) {
                $stmtModulo = $this->pdo->prepare("SELECT modulo FROM Modulo WHERE idModulo = ?");
                $stmtModulo->execute([$instructor['idModulo']]);
                $modulo = $stmtModulo->fetch(PDO::FETCH_ASSOC);
                
                if ($modulo) {
                    $instructor['nombreModulo'] = $modulo['modulo'];
                }
            }
            
            return $instructor;
        } catch (PDOException $e) {
            error_log("Error al obtener instructor: " . $e->getMessage());
            return false;
        }
    }
    
    public function editarInstructor($datos) {
        try {
            $stmt = $this->pdo->prepare("UPDATE Instructor SET 
                documento = ?, 
                nombre = ?, 
                apellido = ?, 
                email = ?, 
                celular = ?, 
                idModulo = ? 
                WHERE idInstructor = ?");
            
            return $stmt->execute([
                $datos['documento'],
                $datos['nombre'],
                $datos['apellido'],
                $datos['email'],
                $datos['celular'],
                $datos['modulo'],
                $datos['id']
            ]);
        } catch (PDOException $e) {
            error_log("Error al editar instructor: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verifica las credenciales de un instructor para el inicio de sesión
     * @param string $documento Documento del instructor
     * @param string $email Email del instructor
     * @param string $clave Clave del instructor
     * @return array|false Datos del instructor si las credenciales son correctas, false en caso contrario
     */
    public function login($documento, $email, $clave) {
        try {
            error_log("InstructorModel: Intentando login con documento: $documento, email: $email");
            
            // Obtener el instructor por documento y email
            $stmt = $this->pdo->prepare("SELECT idInstructor, documento, nombre, apellido, email, clave, idModulo 
                                        FROM Instructor 
                                        WHERE documento = ? AND email = ?");
            $stmt->execute([$documento, $email]);
            $instructor = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($instructor) {
                error_log("InstructorModel: Instructor encontrado, verificando contraseña");
                // Verificar si la contraseña coincide con la hasheada
                if (password_verify($clave, $instructor['clave'])) {
                    error_log("InstructorModel: Contraseña verificada correctamente");
                    // Si coincide, eliminamos la clave del array antes de devolverlo
                    unset($instructor['clave']);
                    
                    // Obtener el nombre del módulo
                    $stmtModulo = $this->pdo->prepare("SELECT modulo FROM Modulo WHERE idModulo = ?");
                    $stmtModulo->execute([$instructor['idModulo']]);
                    $modulo = $stmtModulo->fetch(PDO::FETCH_ASSOC);
                    
                    if ($modulo) {
                        $instructor['nombreModulo'] = $modulo['modulo'];
                    }
                    
                    return $instructor;
                } else {
                    error_log("InstructorModel: Contraseña incorrecta");
                }
            } else {
                error_log("InstructorModel: No se encontró instructor con documento: $documento y email: $email");
            }
            
            return false;
        } catch (PDOException $e) {
            error_log("Error en login de instructor: " . $e->getMessage());
            return false;
        }
    }
}

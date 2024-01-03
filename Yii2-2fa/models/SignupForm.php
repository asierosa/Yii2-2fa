<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Modelo para el formulario de registro.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @return array las reglas de validación.
     */
    public function rules()
    {
        return [
            // Todos los campos son requeridos
            [['username', 'email', 'password'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Este nombre de usuario ya ha sido tomado.'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Esta dirección de correo electrónico ya ha sido tomada.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Registra un nuevo usuario.
     * @return User|null el modelo User guardado o null si el guardado falla
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}

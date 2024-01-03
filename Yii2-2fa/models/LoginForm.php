<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm es el modelo detrás del formulario de inicio de sesión.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * Reglas de validación.
     */
    public function rules()
    {
        return [
            // username y password son requeridos
            [['username', 'password'], 'required'],
            // rememberMe debe ser un valor booleano
            ['rememberMe', 'boolean'],
            // password es validado por validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Valida la contraseña.
     * Este método sirve como la validación en línea para la contraseña.
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Nombre de usuario o contraseña incorrecta.');
            }
        }
    }

    /**
     * Inicia sesión a un usuario usando el nombre de usuario y contraseña proporcionados.
     * @return bool si el inicio de sesión fue exitoso
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Encuentra un usuario por su nombre de usuario
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

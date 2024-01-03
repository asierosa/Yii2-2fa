<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $fecha_creacion
 */
class Usuarios extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','nombre', 'email', 'password_hash','auth_key'], 'required'],
            [['fecha_creacion'], 'safe'],
            [['username','nombre', 'email'], 'string', 'max' => 100],
            [['password_hash'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'fecha_creacion' => 'Fecha Creacion',
        ];
    }

        /**
     * Encuentra una identidad por el ID dado.
     *
     * @param string|int $id el ID a buscar
     * @return IdentityInterface|null la identidad encontrada
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Encuentra una identidad por el token de acceso dado.
     * No implementado en este ejemplo ya que no se usa.
     *
     * @param string $token el token de acceso a buscar
     * @param mixed $type el tipo del token
     * @return IdentityInterface|null la identidad encontrada
     * @throws NotSupportedException siempre, ya que no implementamos este método.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" no está implementado.');
    }

    /**
     * @return string|int el ID del usuario
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Encuentra un usuario por su nombre de usuario.
     *
     * @param string $username El nombre de usuario a buscar.
     * @return static|null El objeto usuario si se encuentra, null en caso contrario.
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }



    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    /**
     * @return string la clave de autenticación del usuario
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Valida la clave de autenticación.
     *
     * @param string $authKey la clave de autenticación a validar
     * @return bool si la clave de autenticación es válida
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * Valida la contraseña.
     *
     * @param string $password La contraseña a validar.
     * @return bool si la contraseña es válida para el usuario actual.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

}

<?php

use yii\bootstrap5\ActiveForm as Bootstrap5ActiveForm;
use yii\helpers\Html;

$this->title = 'Iniciar Sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>Por favor, llena los siguientes campos para iniciar sesión:</p>

    <?php $form = Bootstrap5ActiveForm::begin([
        'id' => 'login-form',
        // Otras configuraciones del formulario si son necesarias
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Iniciar Sesión', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('No tengo cuenta', ['site/register'], ['class' => 'btn btn-secondary']) ?>
        </div>

    <?php Bootstrap5ActiveForm::end(); ?>
</div>

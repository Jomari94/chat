<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$listener = getenv('LISTENER')?: 'localhost:3000';
$js = <<<JS
var listener = "$listener";
var socket = io.connect(listener);
socket.emit('join', 'usuario');
socket.emit('switchRoom', 'sala');

$('#chat-form').submit(function(){
      socket.emit('chat message', JSON.stringify({name: $('#name-field').val(), message: $('#message-field').val()}));
      $('#message-field').val('');
      return false;
});

socket.on('chat message', function(msg){
    msg = JSON.parse(msg);
    $('#messages').append($('<li>').text(msg.name + ': ' + msg.message));
});

socket.on('joined', function(msg){
    $('#messages').append($('<li>').text(msg + ' se ha conectado'));
});

socket.on('leave', function(msg){
    $('#messages').append($('<li>').text(msg + ' se ha desconectado'));
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY)
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="well col-lg-8 col-lg-offset-2">

                <?= Html::beginForm(['/site/index'], 'POST', [
                    'id' => 'chat-form'
                ]) ?>

                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group">
                            <?= Html::textInput('name', null, [
                                'id' => 'name-field',
                                'class' => 'form-control',
                                'placeholder' => 'Name'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <div class="form-group">
                            <?= Html::textInput('message', null, [
                                'id' => 'message-field',
                                'class' => 'form-control',
                                'placeholder' => 'Message'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="form-group">
                            <?= Html::submitButton('Send', [
                                'class' => 'btn btn-block btn-success'
                            ]) ?>
                        </div>
                    </div>
                </div>

                <?= Html::endForm() ?>

                <div id="messages" ></div>
            </div>
        </div>

    </div>
</div>

<?php
use yii\widgets\ActiveForm;
?>
<div class="box box-primary messageRead">
    
    <div class="box-header with-border">
        <p class="messageRead__from">
            <span class="pull-right messageRead__createdAt">12 Januari 1990 12:31:19</span>
            From: Yanuar Nurcahyo - <i>yanuar@microad.co.id</i>
        </p>
        <p class="messageRead__subject">
            Subject: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do 
        </p>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <p>
            <?= $message->body ?>
        </p>
        <?php foreach( $message->messageReplies as $reply ): ?>
            <div class="direct-chat-msg right">
                <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right"><?= $reply->user->fullname ?></span>
                    <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                </div>
                <!-- /.direct-chat-info -->
                <img class="direct-chat-img" src="<?= BASE_URL ?>/backend/img/avatar5.png" alt="message user image"><!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    <?= $reply->body ?>
                </div>
              <!-- /.direct-chat-text -->
            </div>
        <?php endforeach; ?>
    </div>

    <div class="box-footer">
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field( $model, 'body', [
                'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'Type something for them' ]] )
                ->textarea(['rows' => 3])
                ->label(false); ?>
                <div class="pull-right">
                    <a href="message/index" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Send &nbsp; <i class="fa fa-location-arrow"></i></button>
                </div>
        <?php ActiveForm::end() ?>
    </div>
</div>

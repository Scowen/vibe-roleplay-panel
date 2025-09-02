<?php

/** @var yii\web\View $this */
/** @var frontend\models\ContactForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Page Header -->
<div class="page-header text-center py-5 bg-primary text-white" style="margin-top: -2rem;">
    <div class="container">
        <h1 class="display-3 fw-bold">Contact Vibe Roleplay</h1>
        <p class="lead">Get in touch with our team and join the Miami Vice City community</p>
    </div>
</div>

<!-- Contact Information Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-primary mb-3">Get in Touch</h2>
                <p class="lead text-muted">We're here to help you start your Vibe Roleplay journey</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-discord fa-3x text-primary"></i>
                    </div>
                    <h4>Discord Community</h4>
                    <p class="text-muted">Join our Discord server to connect with other players, get support, and stay updated on server events.</p>
                    <a href="#" class="btn btn-primary">Join Discord</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-envelope fa-3x text-primary"></i>
                    </div>
                    <h4>Email Support</h4>
                    <p class="text-muted">Send us an email for general inquiries, bug reports, or partnership opportunities.</p>
                    <a href="mailto:support@viberoleplay.com" class="btn btn-primary">Send Email</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-gamepad fa-3x text-primary"></i>
                    </div>
                    <h4>Server Status</h4>
                    <p class="text-muted">Check our server status and get real-time information about uptime and maintenance.</p>
                    <a href="#" class="btn btn-primary">Check Status</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Send us a Message</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (Yii::$app->session->hasFlash('success')): ?>
                            <div class="alert alert-success">
                                <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger">
                                <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'name')->textInput(['class' => 'form-control form-control-lg', 'placeholder' => 'Your Name']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'email')->textInput(['class' => 'form-control form-control-lg', 'placeholder' => 'Your Email']) ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'subject')->textInput(['class' => 'form-control form-control-lg', 'placeholder' => 'Subject']) ?>

                        <?= $form->field($model, 'body')->textarea(['rows' => 6, 'class' => 'form-control form-control-lg', 'placeholder' => 'Your Message']) ?>

                        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                            'options' => ['class' => 'form-control form-control-lg', 'placeholder' => 'Verification Code']
                        ]) ?>

                        <div class="form-group text-center">
                            <?= Html::submitButton('Send Message', ['class' => 'btn btn-primary btn-lg px-5 py-3', 'name' => 'contact-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-primary mb-3">Frequently Asked Questions</h2>
                <p class="lead text-muted">Quick answers to common questions about Vibe Roleplay</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="accordion" id="faqAccordion1">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button collapsed bg-white text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                How do I join the server?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="faq1" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body">
                                To join Vibe Roleplay, you'll need to join our Discord server first, read the rules, and complete a brief application. Once approved, you'll receive connection details and can start your Miami adventure!
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed bg-white text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                What makes Vibe Roleplay different?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body">
                                Our server focuses on personal character development in a medium roleplay environment. We balance accessibility with depth, creating an experience that's engaging for both newcomers and veterans while maintaining the authentic Miami Vice City atmosphere.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="accordion" id="faqAccordion2">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed bg-white text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Do I need GTA 6 to play?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body">
                                Yes, you'll need GTA 6 to play on our server. We're designed specifically for the upcoming game and will launch alongside it, providing the most authentic Miami Vice City experience possible.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed bg-white text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                How active is the staff team?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body">
                                Our staff team is highly active and dedicated to maintaining a positive community environment. We have moderators available around the clock to help with issues, answer questions, and ensure everyone has a great experience.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community Links Section -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h2 class="display-4 fw-bold mb-4">Join Our Community</h2>
        <p class="lead mb-4">Connect with other players and stay updated on all things Vibe Roleplay</p>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="p-3">
                    <i class="fab fa-discord fa-3x mb-3"></i>
                    <h5>Discord</h5>
                    <p>Join our community chat</p>
                    <a href="#" class="btn btn-light">Join Now</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <i class="fab fa-twitter fa-3x mb-3"></i>
                    <h5>Twitter</h5>
                    <p>Follow for updates</p>
                    <a href="#" class="btn btn-light">Follow</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <i class="fab fa-youtube fa-3x mb-3"></i>
                    <h5>YouTube</h5>
                    <p>Watch gameplay videos</p>
                    <a href="#" class="btn btn-light">Subscribe</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3">
                    <i class="fab fa-instagram fa-3x mb-3"></i>
                    <h5>Instagram</h5>
                    <p>See server highlights</p>
                    <a href="#" class="btn btn-light">Follow</a>
                </div>
            </div>
        </div>
    </div>
</section>
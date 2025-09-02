<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Welcome to Vibe Roleplay';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Hero Section -->
<div class="hero-section text-center py-5" style="min-height: 80vh; display: flex; align-items: center; margin-top: -2rem;">
    <div class="container">
        <h1 class="display-1 fw-bold mb-4 text-dark">
            Vibe Roleplay
        </h1>
        <p class="lead mb-4 text-muted" style="font-size: 1.5rem;">
            Experience the ultimate GTA 6 Miami Vice City roleplay adventure
        </p>
        <p class="mb-5 text-muted" style="font-size: 1.2rem;">
            Immerse yourself in a world of personal character development, thrilling stories, and authentic Miami atmosphere
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="#features" class="btn btn-primary btn-lg px-4 py-3">Discover More</a>
            <a href="<?= \yii\helpers\Url::to(['site/about']) ?>" class="btn btn-outline-secondary btn-lg px-4 py-3">About Our Server</a>
        </div>
    </div>
</div>

<!-- Features Section -->
<section id="features" class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-primary mb-3">Why Choose Vibe Roleplay?</h2>
                <p class="lead text-muted">Discover what makes our Miami Vice City server unique</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title">Character Development</h4>
                        <p class="card-text">Focus on personal growth and deep character stories in a medium roleplay environment that encourages meaningful interactions.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-map-marked-alt fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title">Miami Vice City</h4>
                        <p class="card-text">Set in the vibrant and iconic Miami Vice City from the upcoming GTA 6, featuring authentic locations and atmosphere.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-star fa-3x text-primary"></i>
                        </div>
                        <h4 class="card-title">Quality Experience</h4>
                        <p class="card-text">Medium roleplay server designed for players who want depth without overwhelming complexity, perfect for both newcomers and veterans.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Server Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold text-primary mb-4">Server Features</h2>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Custom Jobs & Economy:</strong> Build your career from the ground up
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Housing System:</strong> Own property in prime Miami locations
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Gang & Faction System:</strong> Join or create powerful organizations
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Custom Vehicles:</strong> Cruise in style with unique Miami rides
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        <strong>Active Staff Team:</strong> Dedicated support and community management
                    </li>
                </ul>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <img src="https://images.unsplash.com/photo-1549924231-f129b911e442?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                        alt="Miami Vice City"
                        class="img-fluid rounded shadow"
                        style="max-height: 400px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Ready to Start Your Miami Adventure?</h2>
        <p class="lead mb-4">Join our community and experience the most immersive GTA 6 roleplay server</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?= \yii\helpers\Url::to(['site/contact']) ?>" class="btn btn-light btn-lg px-4 py-3">Get in Touch</a>
            <a href="<?= \yii\helpers\Url::to(['site/about']) ?>" class="btn btn-outline-light btn-lg px-4 py-3">Learn More</a>
        </div>
    </div>
</section>

<!-- Community Stats Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="p-4">
                    <h3 class="display-6 fw-bold text-primary">500+</h3>
                    <p class="text-muted">Active Players</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-4">
                    <h3 class="display-6 fw-bold text-primary">24/7</h3>
                    <p class="text-muted">Server Uptime</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-4">
                    <h3 class="display-6 fw-bold text-primary">50+</h3>
                    <p class="text-muted">Custom Jobs</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-4">
                    <h3 class="display-6 fw-bold text-primary">100+</h3>
                    <p class="text-muted">Unique Locations</p>
                </div>
            </div>
        </div>
    </div>
</section>
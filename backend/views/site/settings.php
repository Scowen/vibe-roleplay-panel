<?php

/** @var $this yii\web\View */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Settings';
?>

<div class="settings-container fade-in">
    <!-- Settings Header -->
    <div class="settings-header" style="margin-bottom: 2rem;">
        <h2 style="color: #2c3e50; margin-bottom: 0.5rem;">
            <i class="fas fa-cog" style="color: #667eea; margin-right: 0.75rem;"></i>
            Account Settings
        </h2>
        <p style="color: #6c757d; font-size: 1.1rem; margin: 0;">Manage your account preferences and security settings</p>
    </div>

    <!-- Settings Tabs -->
    <div class="settings-tabs" style="margin-bottom: 2rem;">
        <div class="tab-navigation" style="display: flex; gap: 0.5rem; border-bottom: 1px solid #e9ecef; margin-bottom: 2rem;">
            <button class="tab-btn active" data-tab="general" style="padding: 0.75rem 1.5rem; background: none; border: none; border-bottom: 3px solid #667eea; color: #667eea; font-weight: 600; cursor: pointer;">
                <i class="fas fa-sliders-h" style="margin-right: 0.5rem;"></i>
                General
            </button>
            <button class="tab-btn" data-tab="security" style="padding: 0.75rem 1.5rem; background: none; border: none; border-bottom: 3px solid transparent; color: #6c757d; font-weight: 600; cursor: pointer;">
                <i class="fas fa-shield-alt" style="margin-right: 0.5rem;"></i>
                Security
            </button>
            <button class="tab-btn" data-tab="notifications" style="padding: 0.75rem 1.5rem; background: none; border: none; border-bottom: 3px solid transparent; color: #6c757d; font-weight: 600; cursor: pointer;">
                <i class="fas fa-bell" style="margin-right: 0.5rem;"></i>
                Notifications
            </button>
            <button class="tab-btn" data-tab="privacy" style="padding: 0.75rem 1.5rem; background: none; border: none; border-bottom: 3px solid transparent; color: #6c757d; font-weight: 600; cursor: pointer;">
                <i class="fas fa-user-secret" style="margin-right: 0.5rem;"></i>
                Privacy
            </button>
        </div>

        <!-- General Settings Tab -->
        <div class="tab-content active" id="general-tab">
            <div class="profile-section">
                <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">General Preferences</h3>

                <div class="settings-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label class="form-label">Language</label>
                                <select class="form-control">
                                    <option value="en">English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                    <option value="de">German</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label class="form-label">Time Zone</label>
                                <select class="form-control">
                                    <option value="UTC">UTC (Coordinated Universal Time)</option>
                                    <option value="EST">EST (Eastern Standard Time)</option>
                                    <option value="PST">PST (Pacific Standard Time)</option>
                                    <option value="GMT">GMT (Greenwich Mean Time)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label class="form-label">Theme</label>
                                <select class="form-control">
                                    <option value="light">Light Theme</option>
                                    <option value="dark">Dark Theme</option>
                                    <option value="auto">Auto (System)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 1.5rem;">
                                <label class="form-label">Date Format</label>
                                <select class="form-control">
                                    <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                                    <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                                    <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top: 2rem;">
                        <button type="button" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <i class="fas fa-undo"></i> Reset to Default
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings Tab -->
        <div class="tab-content" id="security-tab">
            <div class="profile-section">
                <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Security Settings</h3>

                <div class="security-options" style="display: grid; gap: 1rem; margin-bottom: 2rem;">
                    <div class="security-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-key" style="color: #667eea; margin-right: 0.5rem;"></i>
                                    Two-Factor Authentication
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Add an extra layer of security to your account
                                </p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="twoFactorToggle">
                                <label class="form-check-label" for="twoFactorToggle"></label>
                            </div>
                        </div>
                    </div>

                    <div class="security-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-lock" style="color: #28a745; margin-right: 0.5rem;"></i>
                                    Login Notifications
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Get notified when someone logs into your account
                                </p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="loginNotificationsToggle" checked>
                                <label class="form-check-label" for="loginNotificationsToggle"></label>
                            </div>
                        </div>
                    </div>

                    <div class="security-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-clock" style="color: #ffc107; margin-right: 0.5rem;"></i>
                                    Session Timeout
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Automatically log out after inactivity
                                </p>
                            </div>
                            <select class="form-control" style="width: auto;">
                                <option value="15">15 minutes</option>
                                <option value="30" selected>30 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="120">2 hours</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Security Settings
                    </button>
                </div>
            </div>
        </div>

        <!-- Notifications Settings Tab -->
        <div class="tab-content" id="notifications-tab">
            <div class="profile-section">
                <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Notification Preferences</h3>

                <div class="notification-options" style="display: grid; gap: 1rem; margin-bottom: 2rem;">
                    <div class="notification-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-envelope" style="color: #667eea; margin-right: 0.5rem;"></i>
                                    Email Notifications
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Receive important updates via email
                                </p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotificationsToggle" checked>
                                <label class="form-check-label" for="emailNotificationsToggle"></label>
                            </div>
                        </div>
                    </div>

                    <div class="notification-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-bell" style="color: #28a745; margin-right: 0.5rem;"></i>
                                    Push Notifications
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Get real-time notifications in your browser
                                </p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="pushNotificationsToggle">
                                <label class="form-check-label" for="pushNotificationsToggle"></label>
                            </div>
                        </div>
                    </div>

                    <div class="notification-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-server" style="color: #ffc107; margin-right: 0.5rem;"></i>
                                    Server Updates
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Notify me about server maintenance and updates
                                </p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="serverUpdatesToggle" checked>
                                <label class="form-check-label" for="serverUpdatesToggle"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Notification Settings
                    </button>
                </div>
            </div>
        </div>

        <!-- Privacy Settings Tab -->
        <div class="tab-content" id="privacy-tab">
            <div class="profile-section">
                <h3 style="color: #2c3e50; margin-bottom: 1.5rem;">Privacy Settings</h3>

                <div class="privacy-options" style="display: grid; gap: 1rem; margin-bottom: 2rem;">
                    <div class="privacy-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-eye" style="color: #667eea; margin-right: 0.5rem;"></i>
                                    Profile Visibility
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Control who can see your profile information
                                </p>
                            </div>
                            <select class="form-control" style="width: auto;">
                                <option value="public">Public</option>
                                <option value="friends" selected>Friends Only</option>
                                <option value="private">Private</option>
                            </select>
                        </div>
                    </div>

                    <div class="privacy-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-search" style="color: #28a745; margin-right: 0.5rem;"></i>
                                    Search Visibility
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Allow others to find you in searches
                                </p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="searchVisibilityToggle" checked>
                                <label class="form-check-label" for="searchVisibilityToggle"></label>
                            </div>
                        </div>
                    </div>

                    <div class="privacy-item" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e9ecef;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="color: #2c3e50; margin-bottom: 0.5rem; font-size: 1.1rem;">
                                    <i class="fas fa-chart-line" style="color: #ffc107; margin-right: 0.5rem;"></i>
                                    Activity Tracking
                                </h4>
                                <p style="color: #6c757d; margin: 0; font-size: 0.9rem;">
                                    Allow tracking of your activity for analytics
                                </p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="activityTrackingToggle">
                                <label class="form-check-label" for="activityTrackingToggle"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Privacy Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        // Tab switching functionality
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');

                // Remove active class from all tabs and buttons
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));

                // Add active class to clicked button and corresponding content
                this.classList.add('active');
                document.getElementById(targetTab + '-tab').classList.add('active');
            });
        });

        // Form submission handling
        const saveButtons = document.querySelectorAll('.btn-primary');
        saveButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                this.disabled = true;

                // Simulate save operation
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-check"></i> Saved!';
                    this.style.background = '#28a745';

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                        this.style.background = '';
                    }, 2000);
                }, 1500);
            });
        });

        // Toggle switches
        const toggles = document.querySelectorAll('.form-check-input');
        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.checked) {
                    label.style.color = '#28a745';
                } else {
                    label.style.color = '#6c757d';
                }
            });
        });
    });
</script>
<?php
/**
 * Created by PhpStorm.
 * User: micah
 * Date: 1/1/2019
 * Time: 1:59 PM
 */

$cardTitle = "Card";

if($this->app->objCustomPlatform->getCompanyId() === 0)
{
    $cardTitle = "EZcard";
}

?>
<div class="BodyNavigationBox" style="display:none;">
    <div class="NavigationModule">
        <a href="/account"><span class="fas fa-tachometer-alt fas-large desktop-35px"></span><span class="fas-large">DASHBOARD</span></a>
    </div>
    <div class="NavigationModule">
        <span onclick="dash.expand('my-ezcards');">MY <?php echo strtoupper($cardTitle); ?>S</span>
        <ul class="my-ezcards">
            <li>
                <a href="/account/cards">LIST My Cards</a>
            </li>
            <li style="opacity:.4;">
                <a href="/account/cards/get-new-card">GET a New Card</a>
            </li>
            <li>
                <a href="/account/cards/image-library">Image Library</a>
            </li>
            <li>
                <a href="/account/cards/widget-library">Widget Library</a>
            </li>
            <li style="opacity:.4;">
                <a href="/account/cards/video-library">Video Library</a>
            </li>
            <li style="opacity:.4;">
                <a href="/account/cards/social-media-library">Social Media Library</a>
            </li>
            <li style="opacity:.4;">
                <a href="/account/cards/help">HELP</a>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('scan');"><span class="fas fa-camera1 fa-lock fas-large desktop-35px"></span><span class="fas-large">SCAN</span></a>
        <ul class="scan">
            <li>
                <a href="/account/scans/scan-business-card">SCAN Business Card</a>
            </li>
            <li>
                <a href="/account/scans/">LIST Scanned Cards</a>
            </li>
            <li>
                <a href="/account/scans/how-it-works">How It Works</a>
            </li>
            <li>
                <a href="/account/scans/help">HELP</a>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('messages');"><span class="fas fa-envelope1 fa-lock fas-large desktop-35px"></span><span class="fas-large">MESSAGES</span></a>
        <ul class="messages" style="display:block;">
            <li>
                <span onclick="dash.expand('inbox');">INBOX</span>
                <ul class="inbox">
                    <li><span>My Account</span></li>
                    <li><span>My EZcards</span></li>
                    <li><span>EZcard App</span></li>
                    <li><span>Social Media</span></li>
                </ul>
            </li>
            <li>
                <span onclick="dash.expand('outbox');">OUTBOX</span>
                <ul class="outbox">
                    <li><span>Create</span></li>
                    <li><span>Schedule</span></li>
                    <li><span>Send</span></li>
                    <li><span>Templates</span></li>
                </ul>
            </li>
            <li>
                <span>HELP</span>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('share-ezcards');"><span class="fas fa-share-alt1 fa-lock fas-large desktop-35px"></span><span class="fas-large">SHARE EZCARDS</span></a>
        <ul class="share-ezcards">
            <li>
                <span>EMAIL share</span>
            </li>
            <li>
                <span> TEXT share</span>
            </li>
            <li>
                <span>EZcard APP invitation</span>
            </li>
            <li>
                <span>Upload Contacts</span>
            </li>
            <li>
                <span>HELP</span>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('find-ezcards');"><span class="fas fa-search1 fa-lock fas-large desktop-35px"></span><span class="fas-large">FIND EZCARDS</span></a>
        <ul class="find-ezcards">
            <li>
                <span>EZcard Directory</span>
            </li>
            <li>
                <span>Create a Group</span>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:1;">
        <a onclick="dash.expand('contacts-and-groups');"><span class="fas fa-users fas-large desktop-35px"></span><span class="fas-large">CONTACTS & GROUPS</span></a>
        <ul class="contacts-and-groups">
            <li>
                <a href="/account/contacts">View/Edit Contacts</a>
            </li>
            <li>
                <a href="/account/contacts/my-groups" style="opacity:.4;">My Groups</a>
            </li>
            <li>
                <a href="/account/contacts/upload" style="opacity:.4;">Upload Contacts</a>
            </li>
            <li>
                <a href="/account/contacts/learn-about-contacts" style="opacity:.4;">Learn About Contacts</a>
            </li>
            <li>
                <a href="/account/contacts/learn-about-groups" style="opacity:.4;">Learn About Groups</a>
            </li>
            <li>
                <a href="/account/contacts/help" style="opacity:.4;">HELP</a>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('ez-biz-pro');"><span class="fas fa-briefcase1 fa-lock fas-large desktop-35px"></span><span class="fas-large">EZ BIZ PRO</span></a>
        <ul class="ez-biz-pro">
            <li>
                <span>Activate FREE Trial!</span>
            </li>
            <li>
                <span>Contacts</span>
            </li>
            <li>
                <span>EZcard Marketing</span>
            </li>
            <li>
                <span>Click Funnels</span>
            </li>
            <li>
                <span>Email Marketing</span>
            </li>
            <li>
                <span>Campaigns</span>
            </li>
            <li>
                <span>Text Marketing</span>
            </li>
            <li>
                <span>EZcard App Marketing</span>
            </li>
            <li>
                <span>Coupons</span>
            </li>
            <li>
                <span>BUY</span>
            </li>
            <li>
                <span>HELP</span>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('social-media');"><span class="fas fa-comments1 fa-lock fas-large desktop-35px"></span><span class="fas-large">SOCIAL MEDIA</span></a>
        <ul class="social-media">
            <li>
                <span>Activate FREE Trial!</span>
            </li>
            <li>
                <span>How It Works</span>
            </li>
            <li>
                <span>INBOX</span>
            </li>
            <li>
                <span>OUTBOX</span>
            </li>
            <li>
                <span>TASKS</span>
            </li>
            <li>
                <span>BUY</span>
            </li>
            <li>
                <span>HELP</span>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('my-reviews');"><span class="fas fa-comment-dots1 fa-lock fas-large desktop-35px"></span><span class="fas-large">MY REVIEWS</span></a>
        <ul class="my-reviews">
            <li>
                <span>Learn About Reviews</span>
            </li>
            <li>
                <span>SoTellUs Lite - FREE!</span>
            </li>
            <li>
                <span>SoTellus Premium</span>
            </li>
            <li>
                <span>HELP</span>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('programs');"><span class="fas fa-sign-in-alt1 fa-lock fas-large desktop-35px"></span><span class="fas-large">PROGRAMS</span></a>
        <ul class="programs">
            <li>
                <span>About Our Programs</span>
            </li>
            <li>
                <span>Community Partners</span>
            </li>
            <li>
                <span>JOIN Program</span>
            </li>
            <li>
                <span>Member Program</span>
            </li>
            <li>
                <span>Member Agreement</span>
            </li>
            <li>
                <span>Member Policies</span>
            </li>
            <li>
                <span>JOIN Member Program</span>
            </li>
            <li>
                <span>HELP</span>
            </li>
        </ul>
    </div>
    <div class="NavigationModule" style="opacity:.4;display:none;">
        <a onclick="dash.expand('policies');"><span class="fas fa-file-alt1 fa-lock fas-large desktop-35px"></span><span class="fas-large">POLICIES</span></a>
        <ul class="policies">
            <li>
                <span>Privacy Policy</span>
            </li>
            <li>
                <span>Content Policy</span>
            </li>
            <li>
                <span>Refund Policy</span>
            </li>
            <li>
                <span>HELP</span>
            </li>
        </ul>
    </div>
</div>

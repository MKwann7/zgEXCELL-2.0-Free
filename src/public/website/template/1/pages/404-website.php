<?php

/** @var \App\Website\Website $this */

$this->CurrentPage->BodyId            = "404-page";
$this->CurrentPage->BodyClasses       = ["page", "404-page", "no-columns"];
$this->CurrentPage->Meta->Title       = "Oops! 404 - Card Not Found";
$this->CurrentPage->Meta->Description = "The card you are looking for might have been removed had its name changed or is temporarily unavailable.";
$this->CurrentPage->Meta->Keywords    = "Card Not Found";
$this->CurrentPage->SnipIt->Title     = "404 Card Not Found";
$this->CurrentPage->SnipIt->Excerpt   = "The card you are looking for might have been removed had its name changed or is temporarily unavailable.";
$this->CurrentPage->Columns           = 0;

?>
<div class="wrapper">
    <div class="wrapper-inner">
        <div class="content">
            <div id="notfound">
                <div class="notfound">
                    <div class="notfound-404">
                        <h1>Oops!</h1>
                    </div>
                    <h2 style="margin-bottom: 35px;">Card not found</h2>
                    <p><span class="pretty-text"><?php echo $this->app->objHttpRequest->Uri[0]; ?></span> is unavailable.</p>
                    <p>You may try again,<br>or we can guide you to the <?php echo $this->app->objCustomPlatform->getPublicName() ; ?> login.</p>
                    <a href="<?php echo $this->app->objCustomPlatform->getFullPortalDomainName() ; ?>/login">Go To Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        width: 100%;
        height: 100%;
    }

    .wrapper-inner {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .wrapper .content {
        width: 100%;
        padding: 0;
        margin-top: -5%;
    }

    #notfound * {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    #notfound {
        position: relative;
        min-height: 560px;
    }

    #notfound .notfound {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .notfound {
        max-width: 410px;
        width: 100%;
        text-align: center;
    }

    .notfound .notfound-404 {
        height: 280px;
        position: relative;
        z-index: -1;
    }

    .notfound .notfound-404 h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 230px;
        margin: 0px;
        font-weight: 900;
        position: absolute;
        color:#555;
        left: 50%;
        -webkit-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        transform: translateX(-50%);
        /*background: url('../img/bg.jpg') no-repeat;*/
        /*-webkit-background-clip: text;*/
        /*-webkit-text-fill-color: transparent;*/
        /*background-size: cover;*/
        /*background-position: center;*/
    }

    .notfound h2 {
        font-family: 'Montserrat', sans-serif;
        color: #000;
        font-size: 24px;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 0;
    }

    .notfound p {
        font-family: 'Montserrat', sans-serif;
        color: #000;
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 20px;
        margin-top: 0px;
    }

    .notfound a {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        text-decoration: none;
        text-transform: uppercase;
        background: #989898;
        display: inline-block;
        padding: 15px 30px;
        border-radius: 40px;
        color: #fff;
        font-weight: 700;
        -webkit-box-shadow: 0px 4px 15px -5px #989898;
        box-shadow: 0px 4px 15px -5px #989898;
    }

    .pretty-text {
        display: inline-block;
        padding: 2px 10px;
        color: #fff;
        background-color: #4dadff;
        border-radius: 5px;
        letter-spacing: 2px;
    }


    @media only screen and (max-width: 767px) {
        .notfound .notfound-404 {
            height: 142px;
        }
        .notfound .notfound-404 h1 {
            font-size: 112px;
        }
    }

    @media (max-width:850px) {
        .content {
            width: 100%;
        }
    }

</style>
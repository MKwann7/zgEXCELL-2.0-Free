<div id="arc-menu">
    <canvas id="bg-menu">&#160;</canvas>
    <div class="navWrap">
        <div>
            <nav>
                <ul>
                    <li class="mainLink show up"><a><img alt="Menu Up" src="/website/images/menu-arrow-up.png"/></a></li>
                </ul>
                <ul class="drag">
                    <li class="mainLink show <?php if ( $strCurrentPage == "index") { ?>current<?php } ?>"><a href="/">Home</a></li>
                    <li class="mainLink show <?php if ( $strCurrentPage == "purchase") { ?>current<?php } ?>"><a href="/account/cards">Cards</a></li>
                    <li class="mainLink show <?php if ( $strCurrentPage == "about") { ?>current<?php } ?>"><a href="/account/cards/image-library">Image Library</a></li>
                    <li class="mainLink show <?php if ( $strCurrentPage == "contact-us") { ?>current<?php } ?>"><a href="/account/cards/widget-library">Widget Library</a></li>
                    <li class="mainLink show <?php if ( $strCurrentPage == "login") { ?>current<?php } ?>"><a href="#" onclick="app.Logout()">logout</a></li>
                </ul>
                <ul>
                    <li class="mainLink show arrow down"><a><img alt="Menu Down" src="/website/images/menu-arrow-down.png"/></a></li>
                </ul>
            </nav>
        </div>
    </div>
    <a id="dismiss"><img alt="dismiss" src="/website/images/dismiss.png"/></a>
</div>

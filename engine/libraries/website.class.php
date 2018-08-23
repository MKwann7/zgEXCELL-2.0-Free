<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */
if (!defined('App')) { die('Illegal Access'); }

class Website
{
    public static  $arCurrentPage                 = array();
    public static  $objWebsiteCurrentPage         = null;
    public static  $intWebsiteCurrentPageId       = null;
    public static  $intWebsiteCurrentPageParentId = null;
    private static $strTemplateHeader             = "";
    private static $strTemplateMobileNav          = "";
    private static $strTemplateMeta               = "";
    private static $strTemplateFooter             = "";
    private static $strTemplateInterface          = "";
    private static $strPageBody                   = "";
    private static $strPageLeftColumn                   = "";
    private static $strPageView                   = "";
    public static  $arDdrPages                    = array();
    public static  $blnShow404Page                = false;

    public static function GetPages()
    {
        $objAllActivePages = PageModule::GetAllActivePages();

        foreach ( $objAllActivePages["Pages"] as $currKey => $currPageData)
        {
            if ( $currPageData->ddr_widget != null)
            {
                self::$arDdrPages[$currPageData->page_id] = $currPageData->ddr_widget;
            }
        }

        return $objAllActivePages;
    }

    public static function Load()
    {
        if(!self::ConfigurePageFromUri( App::$objAppSession["Core"]["CurrentPage"]) )
        {
            // 404
        }

        self::BuildPageTemplate();

        self::BuildPageContent();

        self::RenderPage();
    }

    private static function ConfigurePageFromUri($strCurrentUriRequest = "/")
    {
        if (self::$blnShow404Page == true)
        {
            // 404 page. Set 404 template criteria
            // header('X-PHP-Response-Code: 404', true, 404);
            return false;
        }

        self::$objWebsiteCurrentPage = self::GetCurrentPageFromUri($strCurrentUriRequest);

        if ( self::$objWebsiteCurrentPage == null )
        {
            // 404 page. Set 404 template criteria
            // header('X-PHP-Response-Code: 404', true, 404);
            self::$blnShow404Page = true;
            return false;
        }

        self::$intWebsiteCurrentPageId       = self::$objWebsiteCurrentPage->page_id;
        self::$intWebsiteCurrentPageParentId = self::$objWebsiteCurrentPage->page_parent_id;

        if ( self::$objWebsiteCurrentPage->ddr_widget != null)
        {
            // TODO: Build out DDR Logic
            self::ConfigureDdrWebpage();

            self::ConfigureWebpageWidgets();

            self::ApplyWebpageContentCarets();
        }
        elseif (substr(self::$objWebsiteCurrentPage->type,0,7) == "dynamic")
        {
            // TODO: Build out LLP Logic
            self::ConfigureDynamicWebpage();

            self::ConfigureWebpageWidgets();

            self::ApplyWebpageContentCarets();
        }
        else
        {
            self::ConfigureWebsitePage();

            self::ConfigureWebpageWidgets();

            self::ApplyWebpageContentCarets();
        }
    }

    private static function ConfigureWebsitePage()
    {
        self::$arCurrentPage["h1-tag"] = htmlentities(self::$objWebsiteCurrentPage->title);
        self::$arCurrentPage["body-id"] = (self::$objWebsiteCurrentPage->unique_url == "/" ? "home-page" : self::$objWebsiteCurrentPage->unique_url . "-page");
        self::$arCurrentPage["body-class"] = self::GenerageInitialBodyClass();
        self::$arCurrentPage["meta"]["title"] = htmlentities(self::$objWebsiteCurrentPage->meta_title);
        self::$arCurrentPage["meta"]["description"] = htmlentities(self::$objWebsiteCurrentPage->meta_description,ENT_SUBSTITUTE,'utf-8');
        self::$arCurrentPage["meta"]["keywords"] = htmlentities(self::$objWebsiteCurrentPage->meta_keywords,ENT_SUBSTITUTE,'utf-8');
        self::$arCurrentPage["snipit"]["title"] = htmlentities(self::$objWebsiteCurrentPage->title);
        self::$arCurrentPage["snipit"]["excerpt"] = htmlentities(self::$objWebsiteCurrentPage->excerpt,ENT_SUBSTITUTE,'utf-8');
        self::$arCurrentPage["columns"] = self::$objWebsiteCurrentPage->columns;

        if ( !empty(self::$objWebsiteCurrentPage->ChildEntities) )
        {
            self::$arCurrentPage["blocks"] = self::GeneratePageBlocks(self::$objWebsiteCurrentPage->ChildEntities["PageBlocks"]);
        }
    }

    private static function GenerageInitialBodyClass()
    {
        $strInitialBodyClass = "current_page_" . self::$objWebsiteCurrentPage->page_id . " " . ( self::$objWebsiteCurrentPage->columns == 2 ? "double-column" : "single-column") . " page_type_" . self::$objWebsiteCurrentPage->type;

        return $strInitialBodyClass;
    }


    private static function ConfigureDdrWebpage()
    {
        // self::$objWebsiteCurrentPage->ddr_widget
    }

    private static function ConfigureDynamicWebpage()
    {

    }

    private static function ConfigureWebpageWidgets()
    {

    }

    private static function ApplyWebpageContentCarets()
    {

    }

    private static function GetCurrentPageFromUri($strCurrentUriRequest)
    {
        foreach(App::$objWebsitePages["Pages"] as $currKey => $currData)
        {
            if ( $strCurrentUriRequest == $currData->unique_url )
            {
                $objCurrentPage = PageModule::GetById($currData->page_id);

                return $objCurrentPage["Pages"][0];
            }
        }

        return null;
    }

    private static function GeneratePageBlocks($objPageBlockList)
    {
        $arPageBlockList = array();

        foreach($objPageBlockList as $currKey => $currData)
        {
            $arPageBlockList[$currKey]["block_id"]    = $currData->page_block_id;
            $arPageBlockList[$currKey]["page_id"]     = $currData->page_id;
            $arPageBlockList[$currKey]["title"]       = htmlentities($currData->title);
            $arPageBlockList[$currKey]["description"] = htmlentities($currData->description, ENT_SUBSTITUTE, 'utf-8');
            $arPageBlockList[$currKey]["visibility"]  = $currData->visibility;

            foreach ( $currData->block_data as $currColumnKey => $currColumnData )
            {
                $arPageBlockList[$currKey]["columns"][$currColumnKey] = $currColumnData;
            }
        }

        return $arPageBlockList;
    }


    private static function BuildPageTemplate()
    {
        self::$strTemplateMobileNav = self::GetTemplateMobileNavigation();
        self::$strTemplateHeader = self::GetTemplateHeader();
        self::$strTemplateMeta = self::GetTemplateMeta();
        self::$strTemplateFooter = self::GetTemplateFooter();
        self::$strTemplateInterface = self::GetTemplateInterface();
    }

    private static function BuildPageContent()
    {
        ob_start();

        //require(AppWebsiteData . "home.page" . XT);
        //zgPrint(App::$objAppSession);

        //$objModel = App::CreateModel("pages","zgPage", App::$arRequestParams);

        $objPageRequest = PageModule::GetById(1);

        zgPrint($objPageRequest["Pages"][0]->ChildEntities["PageBlocks"][0]->block_data["blocks"][1]);

        //$strBlockHtml = "<h1>MEET. SHARE. CONNECT. REPEAT.</h1><h3>Make your <em>first impression</em> count.</h3><p><span>We all have a smartphone. You’ve got one, right? With the EZcard you can be where people can find you - right on their phones.  And they can reach out to you with the touch of a finger.</span></p><p><span>The EZcard is a V-card on steroids, except with simplicity, flexibility, and convenience. It can be added to your contacts and do a lot more.</span></p><p><span>It can display virtually anything:</span></p><ul><li>Your “Business Card” Information</li><li>A Page from Your Website</li><li>Your Social Media Feeds</li><li>A Google Map or Calendar</li><li>Videos and Other Rich Content</li><li>A Custom Phone Directory</li><li>Your Own Photo and Link Library</li></ul><p><span>Whatever can appear on the web, can be contained in your own EZcard.</span></p>";
        //$strBase64BlockHtml = base64_encode($strBlockHtml);
        //zgPrint($strBase64BlockHtml);
        //zgPrint($objPageRequest["Pages"]);
        //zgPrint($objPageRequest["Pages"][0]->title);


        //zgPrint(self::$arCurrentPage);
        //zgPrint(self::$objWebsiteCurrentPage);


        // Get output buffering results
        self::$strPageBody = ob_get_clean();

        // self::$strPageLeftColumn = "sdfsdf";
    }

    private static function GetTemplateMobileNavigation()
    {
        // Output buffering start
        ob_start();

        switch(App::$objCoreData["Website"]["Theme"]["ThemeId"])
        {
            case "custom":
                require(WebTheme . 'custom/custom.mobile.mav' . XT);
                break;
            case "core-x-1":
                require(AppWebsiteTheme . 'core-x-1/mobile.mav' . XT);
                break;
        }

        // Get output buffering results
        $strTemplateElement = ob_get_clean();

        return $strTemplateElement;
    }

    private static function GetTemplateHeader()
    {
        // Output buffering start
        ob_start();

        switch(App::$objCoreData["Website"]["Theme"]["ThemeId"])
        {
            case "custom":
                require(WebTheme . 'custom/custom.header' . XT);
                break;
            case "core-x-1":
                require(AppWebsiteTheme . 'core-x-1/header' . XT);
                break;
        }

        // Get output buffering results
        $strTemplateElement = ob_get_clean();

        return $strTemplateElement;
    }

    private static function GetTemplateMeta()
    {
        // Output buffering start
        ob_start();

        switch(App::$objCoreData["Website"]["Theme"]["ThemeId"])
        {
            case "custom":
                require(WebTheme . 'custom/custom.meta' . XT);
                break;
            case "core-x-1":
                require(AppWebsiteTheme . 'core-x-1/meta' . XT);
                break;
        }

        // Get output buffering results
        $strTemplateElement = ob_get_clean();

        return $strTemplateElement;
    }

    private static function GetTemplateFooter()
    {
        // Output buffering start
        ob_start();

        switch(App::$objCoreData["Website"]["Theme"]["ThemeId"])
        {
            case "custom":
                require(WebTheme . 'custom/custom.footer' . XT);
                break;
            case "core-x-1":
                require(AppWebsiteTheme . 'core-x-1/footer' . XT);
                break;
        }

        // Get output buffering results
        $strTemplateElement = ob_get_clean();

        return $strTemplateElement;
    }

    private static function GetTemplateInterface()
    {
        // Output buffering start
        ob_start();

        switch(App::$objCoreData["Website"]["Theme"]["ThemeId"])
        {
            case "custom":
                require(WebTheme . 'custom/custom.interface' . XT);
                break;
            case "core-x-1":
                require(AppWebsiteTheme . 'core-x-1/interface' . XT);
                break;
        }

        // Get output buffering results
        $strTemplateElement = ob_get_clean();

        return $strTemplateElement;
    }

    private static function RenderPage()
    {
        self::$strPageView = str_replace(array("[APP_REPLACE_VIEW]", "[APP_REPLACE_HEADER]"), array(self::$strPageBody, self::$strTemplateHeader), self::$strTemplateInterface);

        // Eventually include theme switches here
        include(AppWebsiteTheme . 'default/theme' . XT);
        die();
    }
}
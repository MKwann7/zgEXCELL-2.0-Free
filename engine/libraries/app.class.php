<?php
/**
 * SHELL _site_core Extention for zgWeb.Solutions Web.CMS.App
 */
if (!defined('App')) { die('Illegal Access'); }

class App
{
    // Define all statics
    public static $objCoreData = array();
    public static $objTemplateData = array();
    public static $arRequestParams = array();
    public static $strRequestParams = "";
    public static $objRequestUri = array();
    public static $strRequestUri = "";
    public static $strCurrentPageRequestFull = "";
    public static $strCurrentPageRequestUri = "";
    public static $strCurrentPageRequestParams = "";
    public static $objRequestVerb = "";
    public static $objParameterCoreFunctionRequests = array();
    public static $objActiveSession = false;
    public static $objAppSession = array();
    public static $objAppModules = array();
    public static $objSocialMediaLinks = array();
    public static $objSocialMediaVerfy = array();
    public static $objAllowedServers = array();
    public static $objBlockedServers = array();
    public static $objCustomerAccountStatuses = array();
    public static $objCustomerAccountTypes = array();
    public static $objAcceptedCreditCards = array();
    public static $objTransactionReference = array();
    public static $objUnitedStates = array();
    public static $objAllowedExt = array(".pdf",".jpeg",".jpg",".png",".gif",".html",".map",".css",".js",".zgcss",".zgjs",".woff",".txt",".xml",".svg");
    public static $strActiveExtensionRequestType = "";
    public static $strActiveWebsiteLocation = "";
    public static $blnLoggedIn = false;
    public static $objWebsitePages = array();

	// This loads it all
    public static function Load()
    {
        self::ParseSubmittedUriRequest();
        self::BuildCurrentRequestUri();
        self::LoadCoreData();
        self::CheckForCustomPreSecurityData();
        self::StartCoreSession();
        self::CheckForParameterCoreFunctionRequests();
        self::RegisterCoreSessionData();
        self::CheckForAllowedFileTypesAndRedirectNonSlashedUrls();
        self::LoadModuleRouting();
        self::RunSecurityCore();
    }
	
	// This runs the app
    public static function Run()
    {
        // find the correct application request
        self::ApplicationRoutingWithUri(self::$objRequestUri[0]);
    }

	// This runs the app
    public static function ApplicationRoutingWithUri($strRequestUriFirst)
    {
        switch($strRequestUriFirst)
        {
            case self::$objCoreData["Admin"]["LoggedInFolder"]:
                // Send To Controller System
                break;
            case self::$objCoreData["Member"]["LoggedInFolder"]:
                // Send To Controller System
                break;
            case self::$objCoreData["Admin"]["LoginFolder"]:
                if ( self::$blnLoggedIn == true )
                {
                    self::ExecuteUrlRedirect(self::$objCoreData["Website"]['FullUrl']. self::$objCoreData["Admin"]["LoggedInFolder"].'/');
                }
                break;
            case self::$objCoreData["Member"]["LoginFolder"]:
                if ( self::$blnLoggedIn == true )
                {
                    self::ExecuteUrlRedirect(self::$objCoreData["Website"]['FullUrl']. self::$objCoreData["Member"]["LoggedInFolder"].'/');
                }
                break;
            case "!module":
                self::ModuleControllerRequest();
                break;
            case "_core":
                self::CoreFileRequest();
                break;
            default:

                // Load Website & Page Classes
                require(AppLibraries . "website.class".XT);
                require(AppModules . "pages/classes/main.class".XT);

                self::$strActiveWebsiteLocation = "front";

                self::$objWebsitePages = Website::GetPages();

                if ( self::$objWebsitePages["Result"]["success"] == false || self::$objWebsitePages["Result"]["rows"] == 0 )
                {
                    Website::$blnShow404Page == true;
                }

                Website::Load();
                break;
        }
    }
	
	//------------------------------------------------ CORE LOAD
    private static function ParseSubmittedUriRequest()
    {
		$zg_uripagerequest = "";
        $objRequestUriPath = array();
        extract($_REQUEST, EXTR_PREFIX_ALL|EXTR_REFS, 'zg');
        self::$strRequestUri = escapeString(strip_tags($zg_uripagerequest));
        self::$strRequestParams = $_SERVER["QUERY_STRING"];
		
        if ( self::$strRequestUri != "" )
        {
            $objRequestUriPath = explode("/",$zg_uripagerequest);
            $objRequestUriParameters = explode("&",$_SERVER["QUERY_STRING"]);

            foreach ( $objRequestUriParameters as $strRequestUriParameterFull )
            {
                $objRequestUriParameter = explode("=",$strRequestUriParameterFull);

                if ( substr($objRequestUriParameter[0],-2) == '[]')
                {
                    self::$arRequestParams[substr($objRequestUriParameter[0],0,-2)][trim(urldecode($objRequestUriParameter[1]))] = trim(urldecode($objRequestUriParameter[1]));
                }
                else
                {
                    self::$arRequestParams[$objRequestUriParameter[0]] = trim(urldecode($objRequestUriParameter[1]));
                }
            }
        }
        else
        {
            $objRequestUriParameters = explode("&",$_SERVER["QUERY_STRING"]);

            foreach ( $objRequestUriParameters as $strRequestUriParameterFull )
            {
                $objRequestUriParameter = explode("=",$strRequestUriParameterFull);
                if ( !empty($objRequestUriParameter[0]))
                {
                    self::$arRequestParams[$objRequestUriParameter[0]] = trim(urldecode($objRequestUriParameter[1]));
                }
            }
        }
		if (count($objRequestUriPath) > 1)
		{
			self::$objRequestUri = array_filter($objRequestUriPath);
			return;
		}
		
        self::$objRequestUri = array("/");
    }
	
	private static function BuildCurrentRequestUri()
    {
        // build current uri folder request
        $strFullUriRequstPath = '';
        foreach ( self::$objRequestUri as $currUriFolderLabel )
        {
            $strFullUriRequstPath .= $currUriFolderLabel . '/';
        }
        $strFullUriRequstPath  = substr($strFullUriRequstPath, 0, -1);
        self::$strCurrentPageRequestUri = $strFullUriRequstPath;

        // Build current uri parameter requests
        $strFullRequestParamString = '?';
        unset(self::$arRequestParams['uripagerequest']);
        foreach ( self::$arRequestParams as $currRequestParamsLabel => $currRequestParamsValue )
        {
            $strFullRequestParamString .= $currRequestParamsLabel . '=' . $currRequestParamsValue . '&';
        }
        $strFullRequestParamString = substr($strFullRequestParamString, 0, -1);
        self::$strCurrentPageRequestParams = $strFullRequestParamString;

        if ( !empty($strFullRequestParamString) )
        {
            self::$strCurrentPageRequestFull = $strFullUriRequstPath . $strFullRequestParamString;
        }
        else
        {
            self::$strCurrentPageRequestFull = $strFullUriRequstPath;
        }
    }
	
	private static function StartCoreSession()
    {
        session_set_cookie_params(0,'/');
        self::$objActiveSession = session_start();

        if ( self::$objActiveSession !== true ) {
            self::ThrowProcessException("Core session unable to start."); }

        self::$objAppSession = &$_SESSION['_zgexcell'];
    }

	private static function LoadCoreData()
    {
        self::$objCoreData = self::GetCoreDataFromFile("data.core");

        self::$objCoreData["Database"]['Host'] = 'localhost';
        self::$objCoreData["Database"]['User'] = 'zgadmin';
        self::$objCoreData["Database"]['Password'] = 'Avpe1|bU{J2/P8';

        // Load Website Overrides for Core Data
        require(WebCore."core/config/website.config".XT);

        self::$objCoreData["Website"]['FullUrl'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER["HTTP_HOST"];
        self::$objCoreData["Website"]['DomainName'] = $_SERVER["HTTP_HOST"];
        self::$objRequestVerb = $_SERVER["REQUEST_METHOD"];
    }

    private static function GetCoreDataFromFile($strDataFileRequest)
    {
        if ( !is_file(AppCoreData.$strDataFileRequest.".json") )
        {
            return null;
        }

        $objCoreData = json_decode(file_get_contents(AppCoreData.$strDataFileRequest.".json"), true);

        return $objCoreData;
    }
	
	private static function CheckForParameterCoreFunctionRequests()
    {
        foreach ( self::$objParameterCoreFunctionRequests as $currRequestParam => $currParamRequest )
        {
            if ( !empty(self::$arRequestParams[$currRequestParam]) )
            {
                self::$objAppSession['Core']['CoreRequests'][$currRequestParam]['_toggle'] = true;

                foreach ( $currParamRequest as $currParamRequestLabel => $currParamRequestValue )
                {
                    if ( self::$arRequestParams[$currRequestParam] == $currParamRequestLabel )
                    {
                        self::$objAppSession['Core']['CoreRequests'][$currRequestParam][$currParamRequestLabel] = $currParamRequestValue;
                        unset(self::$arRequestParams[$currRequestParam]);
                        self::BuildCurrentRequestUri();
                        self::ExecuteUrlRedirect(self::$objCoreData["Website"]['FullUrl'].self::$strCurrentPageRequestFull);
                    }
                }
            }
        }
    }
	
	private static function RegisterCoreSessionData()
    {
        self::$objAppSession['Core']['CurrentPage'] = self::$strCurrentPageRequestUri;
        self::$objAppSession['Core']['CurrentPageObject'] = self::$objRequestUri;
        self::$objAppSession['Core']['CurrentRequestParams'] = self::$strCurrentPageRequestParams;
        self::$objAppSession['Core']['CurrentRequestParamsObject'] = self::$arRequestParams;
    }
	
	private static function CheckForCustomPreSecurityData()
    {
        // This will check to see if there is a pre-security custom data loading request on the zgexcell site.
    }
	
	private static function CheckForAllowedFileTypesAndRedirectNonSlashedUrls()
    {
        if ( substr(self::$strRequestUri,-1) != "/" || empty(self::$strRequestUri) || self::$strRequestUri == "/" )
        {
            return;
        }

        foreach(self::$objAllowedExt as $currAllowedExt)
        {
            if (strpos(self::$strRequestUri, $currAllowedExt, 0) !== false)
            {
                self::$strActiveExtensionRequestType = $currAllowedExt;
                break;
            }
        }

        if (!empty(self::$strActiveExtensionRequestType))
        {
            return;
        }

        // TODO - Can we fix this??
        if (strpos($_SERVER["QUERY_STRING"],'zgCore_Dynamic_Request=nA0jEn8L3J68u73x3yC5uWgZ386Fu4eq1i8H1821') !== false)
        {
            return;
        }

        $strOriginalPageRequestUri = str_replace('uripagerequest='.self::$strRequestUri.'&','',self::$strRequestParams);
        $strOriginalPageRequestUri = str_replace('uripagerequest='.self::$strRequestUri,'',$strOriginalPageRequestUri);


        self::$strRequestUri = substr(self::$strRequestUri,0,-1);

        if ( !empty($strOriginalPageRequestUri) )
        {
            self::ExecuteUrlRedirect(self::$objCoreData["Website"]['FullUrl'] . "/". self::$strRequestUri . "?" . $strOriginalPageRequestUri);
        }

        self::ExecuteUrlRedirect(self::$objCoreData["Website"]['FullUrl'] . "/". self::$strRequestUri);
    }
    
    private static function CoreFileRequest()
    {
        $blnDynamicFileType = false;

        switch (self::$strActiveExtensionRequestType)
        {
            case ".html":
                header('Content-Type:text/html');
                break;
            case ".js":
                header('Content-Type:text/javascript');
                break;
            case ".zgjs":
                $blnDynamicFileType = true;
                break;
            case ".css":
                header('Content-Type:text/css');
                break;
            case ".zgcss":
                $blnDynamicFileType = true;
                break;
            case ".jpeg":
                header('Content-Type:image/jpeg');
                break;
            case ".jpg":
                header('Content-Type:image/jpeg');
                break;
            case ".png":
                header('Content-Type:image/png');
                break;
            case ".gif":
                header('Content-Type:image/gif');
                break;
            case ".svg":
                header('Content-Type:image/svg+xml');
                break;
            case ".pdf":
                header('Content-Type:application/pdf');
                break;
            case ".eot":
                header('Content-Type:application/x-font-eot');
                break;
            case ".woff":
                header('Content-Type:application/x-font-woff');
                break;
            case ".map":
                header('X-PHP-Response-Code: 404', true, 404);
                break;
        }
        unset(self::$objRequestUri[0]);

        $strCoreFileRequest = implode('/',self::$objRequestUri);

        if ( substr($strCoreFileRequest,-1) == '/' )
        {
            $strCoreFileRequest = substr($strCoreFileRequest,0,-1);
        }

        if ( $blnDynamicFileType === false )
        {
            if ( ! is_file(AppCore.$strCoreFileRequest))
            {
                die();
            }
            $strFileContents = file_get_contents(AppCore.$strCoreFileRequest,FILE_USE_INCLUDE_PATH);
            echo $strFileContents;
            die();
        }
        else
        {
            include(AppCore.$strCoreFileRequest);
            die();
        }
    }
	
    private static function LoadModuleRouting()
	{
        if (is_file(WebCore."core/routing/modules.json"))
        {
            self::$objAppModules = json_decode(file_get_contents(WebCore."core/routing/modules.json"),true);
        }

        if (!is_dir(WebCore."core"))
        {
            mkdir(WebCore."core");
        }

        if (!is_dir(WebCore."core/routing"))
        {
            mkdir(WebCore."core/routing");
        }

        $objActiveApplets = self::BuildModules();

        file_put_contents(WebCore."core/routing/modules.json",json_encode($objActiveApplets));

        self::$objAppModules = $objActiveApplets;
	}

    private static function BuildModules()
	{
        $objModulesDir = glob(AppCore."modules/*" , GLOB_ONLYDIR);

        $objActiveAppModules = array();

        foreach( $objModulesDir as $currModuleDir)
        {
            if ( is_file($currModuleDir . "/info/main.routing.json"))
            {
                $objCurrentModule = json_decode(file_get_contents($currModuleDir . "/info/main.routing.json"),true);
                $objActiveAppModules = array_merge($objActiveAppModules, $objCurrentModule);
            }
        }

        return $objActiveAppModules;
	}

    public static function ZGetModel($strEntityName, $strModelName)
    {
        $objTestObject = new AppModel($strEntityName, $strModelName);

        return $objTestObject;
    }

    public static function CreateModel($strEntityName, $strModelName, $objParamValues)
    {
        $objTestObject = self::GetModel($strEntityName,$strModelName);

        foreach($objParamValues as $strKey => $objvalue)
        {
            $objTestObject->Add($strKey,$objvalue);
        }

        $objTestObject->validate();

        return $objTestObject;
    }

    private static function ModuleControllerRequest()
    {

    }

    private static function RunSecurityCore()
	{

	}

    //------------------------------------------------ HELPER METHODS
    static public function ExecuteUrlRedirect($strNewUrlLocation)
    {
        header("Location: ".$strNewUrlLocation);
        exit;
    }
	
	private static function ThrowProcessException()
	{
        die($strMessage);
	}
}
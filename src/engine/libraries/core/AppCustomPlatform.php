<?php

namespace App\Core;

use App\Utilities\Excell\ExcellCollection;
use Entities\Companies\Classes\Companies;
use Entities\Companies\Classes\CompanySettings;
use Entities\Companies\Models\CompanyModel;
use Entities\Companies\Models\CompanySettingModel;

class AppCustomPlatform
{
    protected AppCustomDomain $publicDomain;
    protected AppCustomDomain $portalDomain;
    protected CompanyModel $company;
    protected ExcellCollection $listCompanySettings;

    protected Companies $companies;
    protected CompanySettings $companySettings;

    protected int $company_id;
    protected int $parent_id;
    protected bool $sameDomain = true;
    protected $public_domain;
    protected $public_domain_full;
    protected $public_domain_ssl;
    protected $public_domain_name;
    protected $portal_domain;
    protected $portal_domain_full;
    protected $portal_domain_ssl;
    protected $portal_domain_name;



    public function __construct (
        Companies $companies,
        CompanySettings $companySettings,
        $companyId = 0,
        $parentId = 0,
        AppCustomDomain $publicDomain,
        AppCustomDomain $portalDomain,
        CompanyModel $company = null
    )
    {
        $this->companies = $companies;
        $this->companySettings = $companySettings;

        $this->company_id = $companyId;
        $this->parent_id = $parentId;
        $this->sameDomain = $publicDomain->getDomain() === $portalDomain->getDomain();
        $this->publicDomain = $publicDomain;
        $this->portalDomain = $portalDomain;

        if ($company !== null) {
            $this->company = $company;
        }
    }

    public function addCompany(CompanyModel $company) : self
    {
        $this->company = $company;
        $this->loadCompanySettings((int) $company->company_id);
        return $this;
    }

    public function loadCompanySettings(int $companyId) : self
    {
        $companySettingResult = $this->companySettings->getByCompanyId($companyId);
        $this->listCompanySettings = $companySettingResult->getData();

        return $this;
    }

    public function hydrateCompanyFromCache(array $company, array $companySettings) : self
    {
        $this->company = new CompanyModel($company);
        $this->loadCompanySettingsFromCache($companySettings);
        return $this;
    }

    public function loadCompanySettingsFromCache(array $settings) : self
    {
        $collection = new ExcellCollection();

        foreach($settings as $currSetting) {
            $collection->Add(new CompanySettingModel($currSetting));
        }
        $this->listCompanySettings = $collection;
        return $this;
    }

    public function getApplicationType() : string
    {
        if (empty($this->listCompanySettings)) {
            $this->loadCompanySettings($this->getCompanyId());
        }

        return $this->getCompanySettings()->FindEntityByValue("label", "application_type")->value ?? "default";
    }

    public function getCompany() : ?CompanyModel
    {
        if (!isset($this->company_id))
        {
            return null;
        }

        if (empty($this->company))
        {
            $companyResult = $this->companies->getById($this->company_id);

            if ($companyResult->result->Count !== 1)
            {
                return null;
            }

            $this->company = $companyResult->getData()->first();
        }


        return $this->company;
    }

    public function refreshCompany() : self
    {
        $companyResult = $this->companies->getById($this->company_id);

        if ($companyResult->result->Count === 0)
        {
            $this->blnNoDomain = true;
            return $this;
        }

        return $this->addCompany($companyResult->getData()->first());
    }

    public function getCompanySettings() : ExcellCollection
    {
        return $this->listCompanySettings ?? new ExcellCollection();
    }

    public function getCompanyId() : int
    {
        return floatval($this->company_id ?? 0);
    }

    public function getCompanyParentId() : int
    {
        return floatval($this->parent_id ?? $this->company_id ?? 0);
    }

    public function getPublicDomainName() : string
    {
        return $this->publicDomain->getDomain();
    }

    public function getFullPublicDomainName() : string
    {
        return $this->publicDomain->getDomainFull();
    }

    public function getPortalDomainName() : string
    {
        return $this->portalDomain->getDomain();
    }

    public function getFullPortalDomainName() : string
    {
        return $this->portalDomain->getDomainFull();
    }

    public function isSameDomain() : bool
    {
        return $this->sameDomain;
    }

    public function getPublicDomain() : AppCustomDomain
    {
        return $this->websiteDomain;
    }

    public function getPortalDomain() : AppCustomDomain
    {
        return $this->portalDomain;
    }

    public function getPortalName() : string
    {
        return $this->getPortalDomain()->getName();
    }

    public function getPublicName() : string
    {
        return $this->getPublicDomain()->getName();
    }
}
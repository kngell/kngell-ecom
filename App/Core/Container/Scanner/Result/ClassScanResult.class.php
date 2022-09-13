<?php

declare(strict_types=1);

class ClassScanResult
{
    private array $scannedServices;

    /**
     * Construct.
     *
     * @param ComponentMetaData[] $scannedServices
     */
    public function __construct(array $scannedServices)
    {
        $this->scannedServices = $scannedServices;
    }

    /**
     * Get the value of scannedServices.
     * @return ComponentMetaData[] $scannedServices
     */
    public function getScannedServices(): array
    {
        return $this->scannedServices;
    }
}

<?php

declare(strict_types=1);

class SlidersEntity extends Entity
{
    /** @id */
    private int $slId;
    /** @media */
    private string $media;
    private string $pageSlider;
    private string $sliderTitle;
    private string $sliderSubtitle;
    private string $sliderText;
    private string $sliderBtnText;
    private string $sliderBtnLink;
    private string $status;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    /**
     * Get the value of slId.
     */
    public function getSlId() : int
    {
        return $this->slId;
    }

    /**
     * Set the value of slId.
     *
     * @return  self
     */
    public function setSlId(int $slId) : self
    {
        $this->slId = $slId;

        return $this;
    }

    /**
     * Get the value of media.
     */
    public function getMedia() : string
    {
        return $this->media;
    }

    /**
     * Set the value of media.
     *
     * @return  self
     */
    public function setMedia(string $media) : self
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get the value of pageSlider.
     */
    public function getPageSlider() : string
    {
        return $this->pageSlider;
    }

    /**
     * Set the value of pageSlider.
     *
     * @return  self
     */
    public function setPageSlider(string $pageSlider) : self
    {
        $this->pageSlider = $pageSlider;

        return $this;
    }

    /**
     * Get the value of sliderTitle.
     */
    public function getSliderTitle() : string
    {
        return $this->sliderTitle;
    }

    /**
     * Set the value of sliderTitle.
     *
     * @return  self
     */
    public function setSliderTitle(string $sliderTitle) : self
    {
        $this->sliderTitle = $sliderTitle;

        return $this;
    }

    /**
     * Get the value of sliderSubtitle.
     */
    public function getSliderSubtitle() : string
    {
        return $this->sliderSubtitle;
    }

    /**
     * Set the value of sliderSubtitle.
     *
     * @return  self
     */
    public function setSliderSubtitle(string $sliderSubtitle) : self
    {
        $this->sliderSubtitle = $sliderSubtitle;

        return $this;
    }

    /**
     * Get the value of sliderText.
     */
    public function getSliderText() : string
    {
        return $this->sliderText;
    }

    /**
     * Set the value of sliderText.
     *
     * @return  self
     */
    public function setSliderText(string $sliderText) : self
    {
        $this->sliderText = $sliderText;

        return $this;
    }

    /**
     * Get the value of sliderBtnText.
     */
    public function getSliderBtnText() : string
    {
        return $this->sliderBtnText;
    }

    /**
     * Set the value of sliderBtnText.
     *
     * @return  self
     */
    public function setSliderBtnText(string $sliderBtnText) : self
    {
        $this->sliderBtnText = $sliderBtnText;

        return $this;
    }

    /**
     * Get the value of sliderBtnLink.
     */
    public function getSliderBtnLink() : string
    {
        return $this->sliderBtnLink;
    }

    /**
     * Set the value of sliderBtnLink.
     *
     * @return  self
     */
    public function setSliderBtnLink(string $sliderBtnLink) : self
    {
        $this->sliderBtnLink = $sliderBtnLink;

        return $this;
    }

    /**
     * Get the value of createdAt.
     */
    public function getCreatedAt() : DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt.
     *
     * @return  self
     */
    public function setCreatedAt(DateTimeInterface $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt.
     */
    public function getUpdatedAt() : DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt.
     *
     * @return  self
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt) : self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of status.
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * Set the value of status.
     *
     * @return  self
     */
    public function setStatus(string $status) : self
    {
        $this->status = $status;

        return $this;
    }
}

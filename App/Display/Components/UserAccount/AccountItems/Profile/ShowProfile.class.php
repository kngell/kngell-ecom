<?php

declare(strict_types=1);

class ShowProfile extends AbstractShowProfile implements DisplayPagesInterface
{
    public function __construct(UsersEntity $userProfile, CustomReflector $reflect, FormBuilder $frm, UserAccountPaths $paths)
    {
        parent::__construct($userProfile, $reflect, $frm, $paths);
    }

    public function displayAll(): mixed
    {
        $template = $this->getTemplate('userProfilePath');
        $template = str_replace('{{user_profile_menu}}', $this->getTemplate('userProfileMenuPath'), $template);
        $template = str_replace('{{user_profile_data}}', $this->userProfile(), $template);
        $template = str_replace('{{user_profile_formdata}}', $this->userProfileform(), $template);

        return $template;
    }

    /**
     * Set the value of userProfile.
     */
    public function setUserProfile(UsersEntity $userProfile): self
    {
        $this->userProfile = $userProfile;

        return $this;
    }
}

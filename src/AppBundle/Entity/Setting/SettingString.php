<?php
// src/AppBundle/Entity/Setting/SettingString.php
namespace AppBundle\Entity\Setting;

use Symfony\Component\Validator\Constraints as Assert,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Utility\Traits\DoctrineMapping\IdMapperTrait,
    AppBundle\Validator\Constraints as CustomAssert;

/**
 * @ORM\Table(name="settings_string")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Setting\Repository\SettingStringRepository")
 *
 * @UniqueEntity(fields="name", message="settings.common.name.unique")
 * @UniqueEntity(fields="settingKey", message="settings.common.setting_key.unique")
 */
class SettingString
{
    use IdMapperTrait;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Setting\Setting", inversedBy="settingsString")
     * @ORM\JoinColumn(name="setting_id", referencedColumnName="id")
     */
    protected $setting;

    /**
     * @ORM\Column(type="string", length=250, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $settingKey;

    /**
     * @ORM\Column(type="string", length=250)
     *
     * @Assert\NotBlank(message="settings.string.setting_value.not_blank")
     * @Assert\Length(
     *      min=1,
     *      max=250,
     *      minMessage="settings.string.setting_value.length.min",
     *      maxMessage="settings.string.setting_value.length.max"
     * )
     */
    protected $settingValue;

    public function __toString()
    {
        return ( $this->name ) ? $this->name : "";
    }

    /**
     * Set name
     *
     * @param string $name
     * @return SettingString
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set settingKey
     *
     * @param string $settingKey
     * @return SettingString
     */
    public function setSettingKey($settingKey)
    {
        $this->settingKey = $settingKey;

        return $this;
    }

    /**
     * Get settingKey
     *
     * @return string
     */
    public function getSettingKey()
    {
        return $this->settingKey;
    }

    /**
     * Set settingValue
     *
     * @param string $settingValue
     * @return SettingString
     */
    public function setSettingValue($settingValue)
    {
        $this->settingValue = $settingValue;

        return $this;
    }

    /**
     * Get settingValue
     *
     * @return string
     */
    public function getSettingValue()
    {
        return $this->settingValue;
    }

    /**
     * Set setting
     *
     * @param \AppBundle\Entity\Setting\Setting $setting
     * @return SettingString
     */
    public function setSetting(\AppBundle\Entity\Setting\Setting $setting = null)
    {
        $this->setting = $setting;

        return $this;
    }

    /**
     * Get setting
     *
     * @return \AppBundle\Entity\Setting\Setting
     */
    public function getSetting()
    {
        return $this->setting;
    }
}

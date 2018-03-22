<?php

namespace Beebmx\Panel\Features;

trait HasSettings
{
    protected $settings = [];
    protected $defaults = [];

    protected function setDefaults()
    {
        if (isset($this->defaults) and is_array($this->defaults)) {
            $this->defaults = array_replace_recursive($this->getDefaults(), $this->defaults);
        } else {
            $this->defaults = $this->getDefaults();
        }
        foreach ($this->defaults as $setting => $value) {
            if (!isset($this->settings[$setting])) {
                $this->setSetting($setting, $value);
            }
        }
    }

    protected function getSetting($setting)
    {
        if (!$setting) {
            return;
        }
        if (isset($this->settings[$setting])) {
            return $this->settings[$setting];
        }
    }

    protected function setSetting($setting, $value)
    {
        $this->settings[$setting] = $value;
        return $this;
    }

    public function __get($setting)
    {
        return $this->getSetting($setting);
    }

    public function __set($setting, $value)
    {
        $this->setSetting($setting, $value);
    }
}

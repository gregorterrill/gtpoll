<?php
/**
 * GT Poll plugin for Craft CMS
 *
 * Create polls and get your users' opinions.
 *
 *
 * @author    Gregor Terrill
 * @copyright Copyright (c) 2016 Gregor Terrill
 * @link      http://gregorterrill.com
 * @package   GtPoll
 * @since     1.0.0
 */

namespace Craft;

class GtPollPlugin extends BasePlugin
{
    /**
     * Called after the plugin class is instantiated; do any one-time initialization here such as hooks and events:
     *
     * craft()->on('entries.saveEntry', function(Event $event) {
     *    // ...
     * });
     *
     * or loading any third party Composer packages via:
     *
     * require_once __DIR__ . '/vendor/autoload.php';
     *
     * @return mixed
     */
    public function init()
    {
    }

    /**
     * Returns the user-facing name.
     *
     * @return mixed
     */
    public function getName()
    {
        $pluginName = Craft::t('GT Poll');
        $pluginNameOverride = $this->getSettings()->pluginNameOverride;

        return ($pluginNameOverride) ? $pluginNameOverride : $pluginName;
    }

    /**
     * Plugins can have descriptions of themselves displayed on the Plugins page by adding a getDescription() method
     * on the primary plugin class:
     *
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Create polls and get your users\' opinions.');
    }

    /**
     * Plugins can have links to their documentation on the Plugins page by adding a getDocumentationUrl() method on
     * the primary plugin class:
     *
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/gregorterrill/gtpoll/blob/master/README.md';
    }

    /**
     * Plugins can now take part in Craft’s update notifications, and display release notes on the Updates page, by
     * providing a JSON feed that describes new releases, and adding a getReleaseFeedUrl() method on the primary
     * plugin class.
     *
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/gregorterrill/gtpoll/master/releases.json';
    }

    /**
     * Returns the version number.
     *
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * As of Craft 2.5, Craft no longer takes the whole site down every time a plugin’s version number changes, in
     * case there are any new migrations that need to be run. Instead plugins must explicitly tell Craft that they
     * have new migrations by returning a new (higher) schema version number with a getSchemaVersion() method on
     * their primary plugin class:
     *
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * Returns the developer’s name.
     *
     * @return string
     */
    public function getDeveloper()
    {
        return 'Gregor Terrill';
    }

    /**
     * Returns the developer’s website URL.
     *
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'http://gregorterrill.com';
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('gtpoll/settings', array(
            'settings' => $this->getSettings()
        ));
    }

    protected function defineSettings()
    {
        return array(
            'pluginNameOverride'    => AttributeType::String,
        );
    }

    /**
     * Returns whether the plugin should get its own tab in the CP header.
     *
     * @return bool
     */
    public function hasCpSection()
    {
        return true;
    }

    public function registerCpRoutes()
    {
        return array(
            'gtpoll/edit/(?P<pollId>\d+)' => 'gtpoll/edit',
       );
    }
}
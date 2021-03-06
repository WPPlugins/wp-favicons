<?php
/**
 * Deletes the Favicon Cache
 * @package WP-Favicons
 * @author Edward de Leau <e@leau.net>, http://edward.de.leau.net
 * @since 0.4.0
 */
namespace leau\co\wp_favicons_server;

if (!class_exists("\\leau\\co\\wp_favicons_server\\metadata_favicon_empty_metadata_cache"))
{
	/**
	 * Deletes the Favicon Cache
	 * This plugin offers functionality to delete the favicon cache
 	 * @author Edward de Leau <e@leau.net>, http://edward.de.leau.net
 	 * @since 0.4.0 *
	 */
	class metadata_favicon_empty_metadata_cache extends Plugin
	{

		/**
    	 * Executes admin functions
    	 */
     	function ExecuteAdminAction()
        {
        	/* first get the options array */
        	$options_array = Config::GetOptionsAsArray();

        	/* if the user wants to clean the cache */
        	if (1 == Config::GetOptionsArrayValue(Config::GetPluginSlug() . 'empty_cache'))
        	{
        		/*
        		 * 1. we noticed that when the cache is on, on a busy blog that the cache was filling
        		 * up on one side while trying to clean on the other side, so first turn off
        		 * the cache
        		 */
        		$turn_cache_back_on_afterwards = false;
        		if (true == Config::GetOptionsArrayValue('use_cache')) {
        			$turn_cache_back_on_afterwards = true;
        			$options_array[Config::GetPluginSlug() . 'use_cache'] = false;
        			Config::UpdateOptions($options_array);
        		}

        		/* 2. delete the db cache */
				Database::EmptyIconCache();

            	/* 3. now set the empty cache option back to 0 again */
				$options_array[Config::GetPluginSlug() . 'empty_cache'] = 0;
				$options_array[Config::GetPluginSlug() . 'cache_emptied_date'] = current_time("mysql");
				Config::UpdateOptions($options_array);

				/* 4. and set the last time the cache was emptied */
				$temp_line =
				__('Empty the current favicon db cache.','wp-favicons');
				Config::SetModulePlugin($this->_module,$this->_plugin,'header',
					$temp_line  . 'Last time Emptied on: ' .
				Config::GetOptionsArrayValue(Config::GetPluginSlug() .'cache_emptied_date'));

				/* 6. finally turn the cache back on again */
				if (true == $turn_cache_back_on_afterwards)
				{
					$options_array[Config::GetPluginSlug() . 'use_cache'] = true;
        			Config::UpdateOptions($options_array);
				}
        	}
        }
	}
}


<?php
/**
 * goback Plugin: Go back to previous page button.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Denis Gravel <denis.gravel@outlook.fr>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

/**
 * Class action_plugin_goback
 *
 * Go back to previous page button
 */
class action_plugin_goback extends DokuWiki_Action_Plugin {

    /**
     * Register the events
     *
     * @param Doku_Event_Handler $controller
     */
    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TEMPLATE_PAGETOOLS_DISPLAY', 'BEFORE', $this, 'addbutton', array());
    }

    /**
     * Add 'goback'-button to pagetools
     *
     * @param Doku_Event $event
     */
    public function addbutton(Doku_Event $event) {
        global $ID, $REV;

        if($event->data['view'] == 'main') {
            $params = array('do' => 'goback');
            if($REV) {
                $params['rev'] = $REV;
            }

            // insert button at position before last (up to top)
            $event->data['items'] = array_slice($event->data['items'], 0, -1, true) +
                array('goback' =>
                          '<li>'
                          . '<a href="javascript:history.back()" class="action goback" accesskey="p" rel="nofollow" title="' . $this->getLang('goback_button') . '">'
                          . '<span>' . $this->getLang('goback_button') . '</span>'
                          . '</a>'
                          . '</li>'
                ) +
                array_slice($event->data['items'], -1, 1, true);
        }
    }
}

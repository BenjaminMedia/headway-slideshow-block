<?php

class HeadwaySlideshowBlockOptions extends HeadwayBlockOptionsAPI {
    public $tabs = array(
        'settings' => 'Settings',
    );

    public $inputs = array(
        'settings' => array(
            'timeout' => array(
                'type' => 'text',
                'name' => 'timeout',
                'label' => 'Autoplay timeout',
                'default' => '5000',
                'tooltip' => ''
            ),
            'speed' => array(
                'type' => 'text',
                'name' => 'speed',
                'label' => 'Autoplay speed',
                'default' => '1000',
                'tooltip' => ''
            )
        )
    );
}
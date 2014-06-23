<?php

class ThePoserPlugin extends MantisPlugin {
    function register() {
        $this->name = 'The Poser';    # Proper name of plugin
        $this->description = 'So you can explain to your boss why Mantis is better. (Look matters after all)';    # Short description of the plugin
        $this->page = 'config';           # Default plugin page

        $this->version = '1.0';     # Plugin version string
        $this->requires = array(    # Plugin dependencies, array of basename => version pairs
            'MantisCore' => '1.2.0',  #   Should always depend on an appropriate version of MantisBT
            );

        $this->author = 'Agave Storm Inc.';         # Author/team name
        $this->contact = 'agavestorm@gmail.com';        # Author/team e-mail address
        $this->url = 'http://agavestorm.com/poser';            # Support webpage
    }
    
    function hooks() {
//        throw new Exception();
        return array(
            'EVENT_LAYOUT_RESOURCES' => 'initlook',
        );
    }
    
    function initlook($p_event) {
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo plugin_file( 'main.css' ); ?>"/>
        <?php
    }
}
//new Poser();
//throw new Exception();
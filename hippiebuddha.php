<?php
/*
Plugin Name: HippieBuddha Special
Plugin URI: http://hippiebuddha.com
Description: Add the HB Love
Version: 1.0
Author: Chirag Chamoli
Author URI: http://chiragchamoli.com
Author Email: chirax@gmail.com
License: Nikita upreti
*/


Class HB_Post{

    public function __construct(){
        $this->register_post_type();
        $this->taxonomies();
        $this->metaboxes();

    }

    public function register_post_type(){

        $icon_path = dirname(__FILE__);


    $args= array(
            'labels' => array(
                'name' => 'HB Posts',
                'singular_name' => 'HB Post',
                'add_new' => 'New HB Post',
                'add_new_item' => 'New HB Post',
                'edit_item' => 'Edit HB Post',
                'new_item' => 'Add New HB Post',
                'view_item' => 'View HB Post',
                'search_items' => 'Search HB',
                'not_found' => 'No HB Post',
                'not_found_in_trash' => 'No HB Post in Trash'
                ),
            'query_var' => 'hb',
//            'rewrite' => array('slug' => 'hb/'),
            'public' => true,
            'menu_position' => 2,
            'menu_icon' => plugin_dir_url(__FILE__).'/hbicon.png',
            'supports' =>  array(
                'title','thumbnail','editor'
            )
        );

        register_post_type('hb',$args);
    }

    public function taxonomies(){
        $taxonomies = array();
        $taxonomies['type'] = array(
                                    'hierarchical' => true,
                                    'query_var' => 'hb_type',
                                    'labels' => array(
                                    'name' => 'HB Type',
                                    'singular_name' => 'HB Type',
                                    'add_new' => 'New HB Type',
                                    'add_new_item' => 'New HB Type',
                                    'edit_item' => 'Edit HB Type',
                                    'new_item' => 'Add New HB Type',
                                    'view_item' => 'View HB Type',
                                    'search_items' => 'Search HB Type',
                                    'not_found' => 'No HB Type',
                                    'not_found_in_trash' => 'No HB  Type in Trash'
                                    )
                                );

        $this->register_all_taxonomies($taxonomies);
    }

    public function register_all_taxonomies($taxonomies){
            foreach($taxonomies as $name => $arr)
            {
                register_taxonomy($name, array('hb'), $arr);
            }

            
    }

    public function metaboxes()
    {
        
        add_action('add_meta_boxes', function(){
            add_meta_box('hb_source_url', 'Source for this HB', 'hb_source_post', 'hb');

        });

        function hb_source_post($post){
            
            $source = get_post_meta($post->ID, 'hb_source_url', true );

            ?>
            <p> 
                <label for="hb_source_url"> Source for the Article: Leave empty for Videos </label>
                <input type="text" class="widefat" name="hb_source_url" id="hb_source_url" value="<?php echo  $source; ?> " />

                
            </p>
            <?php 
        }         

        add_action('save_post', function($id){
                if(isset($_POST['hb_source_url']))
                {
                    update_post_meta($id,'hb_source_url', strip_tags($_POST['hb_source_url']));    
                }

        });
    }

}

add_action('init',function(){
    new HB_Post();
});

<?php

/*
  Plugin Name: Simple MD5 Generator
  Description: Simple Plugin to generate MD5.
  Version: 1.0
  Author: Egenie Next Web Solutions
  Author URI: https://www.egenienext.com/

 */

class simplemd5generator
{

    public function __construct()
    {
        if (is_admin()) {
            add_action('admin_menu', array($this, 'md5_setting_menu'));
            add_action('admin_action_md5', array($this, 'md5_convert_string'));
        }
    }

    public function md5_setting_menu()
    {
        add_options_page('Simple MD5 Generator', 'Simple MD5 Generator', 'manage_options', 'simple_md5_generator', array($this, 'simple_md5_generator_page'));
    }

    public function simple_md5_generator_page()
    {
        $result = '';
        $simple_text = '';
        $md5_text = '';
        if (isset($_GET['event']) == "success") {
            echo '<div id="message" class="updated"><p><strong>MD5 has been generated successfully</strong></p></div>';
            $simple_text = sanitize_text_field($_GET['text']);
            $md5_text = sanitize_text_field($_GET['md5']);
            $result = true;
        } else if (isset($_GET['event']) == "failure") {
            echo '<div id="message" class="error"><p><strong>Error in generating MD5</strong></p></div>';
            $result = false;
        }

        ?>
        <div class="wrap">

            <h2>Simple MD5 Generator!</h2>
            <form action="<?php echo admin_url('admin.php'); ?>" method="POST">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="simple_text">Enter Text</label>
                        </th>
                        <td>
                            <input type="text" name="simple_text" id="simple_text" required="required"
                                   value="<?php echo $simple_text; ?>"/>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="hidden" name="action" value="md5"/>
                    <input type="submit" class="button-primary" value="Generate"/>
                </p>
            </form>
            <?php if ($result == true) { ?>
                <h3>
                    <strong>Result:</strong> <?php echo $md5_text; ?>
                </h3>

            <?php } ?>

        </div>


        <?php
    }

    public function md5_convert_string()
    {
        $status = '';
        if (isset($_POST["action"]) == "md5") {
            $simple_text = sanitize_text_field($_POST["simple_text"]);
            $generate_md5 = md5($simple_text);
            $status = 'success';
            wp_safe_redirect(wp_get_referer() . '&md5=' . $generate_md5 . '&text=' . $simple_text . '&event=' . $status);
        } else {
            $status = 'failure';
            wp_safe_redirect(wp_get_referer() . '&event=' . $status);
        }
    }


}

new simplemd5generator();
